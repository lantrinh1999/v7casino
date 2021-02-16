<?php

namespace Botble\BlogCrawler\Commands;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Events\CreatedContentEvent;
use Botble\BlogCrawler\Enums\CrawlStatusEnum;
use Botble\BlogCrawler\Models\CrawlerCategory;
use Botble\BlogCrawler\Models\CrawlerPost;
use Botble\Blog\Models\Post;
use Botble\Blog\Services\StoreCategoryService;
use Botble\Blog\Services\StoreTagService;
use Botble\Media\Repositories\Interfaces\MediaFolderInterface;
use Botble\Slug\Services\SlugService;
use Goutte\Client;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mimrahe\StripTags\Stripper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class BlogCrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:post-crawler {--page=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command crawler posts';
    protected $dir = null;

    protected $category_link;
    protected $client;
    protected $slugService;
    protected $tagService;
    protected $categoryService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        Client $client,
        SlugService $slugService,
        StoreTagService $tagService,
        StoreCategoryService $categoryService
    ) {
        $this->client = $client;
        $this->slugService = $slugService;
        $this->tagService = $tagService;
        $this->categoryService = $categoryService;
        $dir = $this->checkPostDir();
        $this->dir = $dir;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mix
     */
    public function handle()
    {
        // DB::beginTransaction();

        try {

            while ($info = $this->getInfoCrawler()) {
                $this->category_link = $info->link;

                if (preg_match('[page]', $info->link)) {
                    $limit = $info->limit ?? 10;
                    for ($i = 0; $i < $limit; $i++) {

                        $inf = $info;
                        $a = $i;
                        $inf->link = str_replace('[page]', "$a", $inf->link);
                        $return = $this->scraper($inf);
                        if(empty($return)) {
                            break;
                        }
                        $inf = null;

                    }
                } else {
                    $this->scraper($info);
                }
                $info->crawl_status = CrawlStatusEnum::DONE;
                $info->save();

            }

            $this->checkDone();
            $this->info('[DONE]');
            // DB::commit();
        } catch (Exception $exception) {
            // DB::rollBack();
            \Log::error($exception->getMessage());
        }
    }

    protected function getInfoCrawler()
    {
        return CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)->where('crawl_status', CrawlStatusEnum::NOT_RUNNING)->inRandomOrder()->first();
    }

    protected function scraper($category)
    {
        // DB::beginTransaction();

        try {
            $category_link = $category->link;
            $this->info("--- $category_link");
            $category->crawl_status = CrawlStatusEnum::RUNNING;

            // dump($this->category_link);
            $category->link = $this->category_link;
            $category->save();

            $data = [];
            $data['categories'] = json_decode($category->categories_id, true);
            $data['status'] = BaseStatusEnum::PENDING;
            $data['is_featured'] = 0;
            $data['model'] = Post::class;
            $data['author_id'] = 1;
            $data['slug_id'] = 0;

            $crawler_name = $category->name;
            $this->info("+ Crawl $crawler_name");

            $domain = trim(parse_url($category_link)['host']);

            $crawler = $this->client->request('GET', $category_link);
            // dump($crawler);
            $post_link_selectors = explode('|', $category->post_link_selector);

            $links = [];
            foreach ($post_link_selectors as $selector) {
                $ary_links = $crawler->filter(trim($selector))->extract(['href']);
                if (!empty($ary_links) && is_array($ary_links) && count($ary_links) > 0) {
                    $links = [...$links, ...$ary_links];
                }
            }
            dump($links);
            if(empty(count($links))) {
                return false;
            }

            $links = array_reverse($links);

            if (!empty($links) && is_array($links) && count($links) > 0) {
                foreach ($links as $link) {
                    if (!filter_var($link, FILTER_VALIDATE_URL)) {
                        $link = trim($domain) . '/' . trim($link, '/');
                    }

                    if (CrawlerPost::where('link', $link)->exists()) {

                        continue;
                    }

                    $this->info($link);
                    $crawler = $this->client->request('GET', $link);
                    // get title
                    if (!empty($category->title_selector)) {
                        $title_filter = $crawler->filter($category->title_selector);
                        if (!empty($title_filter->count())) {
                            $title = $title_filter->text();
                            $data['name'] = $title;
                            $data['seo_meta']['seo_title'] = $title;
                            $slug = $this->slugService->create($title, 0, Post::class);
                            $data['slug'] = $slug;
                        } else {
                            continue;
                        }

                    }
                    if (!empty($category->image_selector)) {
                        $image_filter = $crawler->filter($category->image_selector)->eq(0);
                        if (!empty($image_filter->count())) {
                            $image = $image_filter->attr('src');
                        }
                    } else {

                    }
                    if (empty($category->image_selector) || empty($image)) {
                        $image_filter = $crawler->filterXPath("//meta[@property='og:image']");
                        if (!empty($image_filter->count())) {
                            $image = $image_filter->attr('content');
                        }
                    }
                    if (!empty($image)) {
                        $image_result = \RvMedia::uploadFromUrl($image, $this->dir->id, $this->dir->slug);
                        $data['image'] = $image_result['data']->url ?? null;
                    }
                    // get description
                    if (!empty($category->description_selector)) {
                        $description_filer = $crawler->filter($category->description_selector);
                        if (!empty($description_filer->count())) {
                            $description = $description_filer->text();
                            $data['description'] = $description;
                            $data['seo_meta']['seo_description'] = $description;
                        }
                    } else {
                        $description_filer = $crawler->filterXPath("//meta[@property='description']");
                        if (!empty($description_filer->count())) {
                            $description = $description_filer->attr('content');
                            $data['description'] = $description;
                            $data['seo_meta']['seo_description'] = $description;
                        }
                    }

                    // get content
                    if (!empty($category->content_selector)) {
                        $content = $crawler->filter($category->content_selector);
                        if (!empty($content->count())) {
                            $content_html = $content->html();
                            // remove a tag
                            $content_html_clean = $this->stripAtag(clean($content_html)) ?? clean($content_html);

                            $imgs = $this->getImgSrc($content_html_clean);
                            if (!empty($imgs)) {
                                $new_imgs = [];
                                foreach ($imgs as $img) {
                                    if (!filter_var($img, FILTER_VALIDATE_URL)) {
                                        $img = trim($domain) . '/' . trim($img, '/');
                                    }
                                    $imgscr = \RvMedia::uploadFromUrl($img, $this->dir->id, $this->dir->slug);
                                    if (!empty($imgscr['data'])) {
                                        $new_imgs[] = \get_object_image($imgscr['data']->url);
                                    }
                                }
                                if (count($new_imgs)) {
                                    $content_html_clean = str_replace($imgs, $new_imgs, $content_html_clean);
                                }
                            }

                            $data['content'] = $content_html_clean;

                            // get image
                            if (!empty($category->content_image_attr_selector)) {
                                $ary_attr_scr_name = explode(',', $category->content_image_attr_selector);
                                if (!empty($ary_attr_scr_name) && is_array($ary_attr_scr_name) && count($ary_attr_scr_name) > 0) {
                                    $ary_attr_scr_name = collect($ary_attr_scr_name)->map(function ($item, $key) {
                                        return trim($item);
                                    })->all();
                                    $images = $content->filter('img')->extract($ary_attr_scr_name);
                                    if (!empty($images)) {
                                        $images = collect($images)->flatten()->values()->unique()->all();
                                    }
                                }
                            }
                        }
                    }

                    // get tag
                    if (!empty($category->tag_selector)) {
                        $tag = [];
                        if (!empty($crawler->filter($category->tag_selector)->count())) {
                            $crawler->filter($category->tag_selector)->each(function (Crawler $node) use (&$tag) {
                                $tag[]['value'] = $node->text();
                            });
                            if (!empty($tag) && is_array($tag) && count($tag)) {
                                $tag = json_encode($tag);
                                $data['tag'] = $tag;
                            }
                        }
                    }
                    $request = new Request();
                    $request->replace($data);

                    $post = Post::create($data);

                    event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

                    $this->tagService->execute($request, $post);

                    $this->categoryService->execute($request, $post);

                    CrawlerPost::create([
                        'link' => $link,
                        'crawler_category_id' => $category->id,
                        'post_id' => $post->id,
                        'status' => CrawlStatusEnum::DONE,
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return false;
        }
        return true;
    }

    protected function checkDone()
    {
        DB::beginTransaction();
        try {
            $exist_data = CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)
                ->where('crawl_status', CrawlStatusEnum::NOT_RUNNING)
                ->exists();

            if (empty($exist_data)) {
                $data = CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)
                // ->where('crawl_status', CrawlStatusEnum::DONE)
                // ->where('crawl_status', '<>' ,CrawlStatusEnum::RUNNING)
                    ->update(['crawl_status' => CrawlStatusEnum::NOT_RUNNING]);
                $this->info('- UPDATE lại status_crawl');
            }
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
        }
    }

    protected function checkPostDir()
    {
        $name = 'Blog';
        $slug = 'blog';
        $parentId = 0;
        $check = app(MediaFolderInterface::class)->getModel()->where('slug', $slug)->first();
        // dd($check);
        if (!$check) {
            $name = 'Blogs';
            $folder = app(MediaFolderInterface::class)->getModel();
            $folder->user_id = 1;
            $folder->name = app(MediaFolderInterface::class)->createName($name, $parentId);
            $folder->slug = app(MediaFolderInterface::class)->createSlug($slug, $parentId);
            $folder->parent_id = $parentId;
            $folder = $folder->toArray();
            $a = app(MediaFolderInterface::class)->getModel()->firstOrCreate($folder);
            // dd($a);
            return $a;
        }
        return $check;
    }

    protected function getImgSrc($html)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $dom->preserveWhiteSpace = false;
        $images = $dom->getElementsByTagName('img');

        $data = [];
        foreach ($images as $image) {
            $data[] = $image->getAttribute('src');
        }
        if (count($data)) {
            return $data;
        }

        return false;
    }

    protected function stripAtag($html)
    {
        $stripper = new Stripper($html);
        $stripper->only(['a']);
        if (!empty($data = $stripper->strip())) {
            return $data;
        }

        return false;
    }
}
