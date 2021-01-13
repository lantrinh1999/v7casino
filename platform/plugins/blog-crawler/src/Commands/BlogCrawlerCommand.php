<?php

namespace Botble\BlogCrawler\Commands;

use Illuminate\Console\Command;
use Botble\BlogCrawler\Enums\CrawlStatusEnum;
use Botble\Base\Enums\BaseStatusEnum;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Botble\BlogCrawler\Models\CrawlerCategory;
use Illuminate\Support\Facades\DB;

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

    protected $category_link;
    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mix
     */
    public function handle()
    {
        $this->scraper();
    }

    protected function scraper()
    {
        DB::beginTransaction();

        try {
            $this->checkDone();

            $category = CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)->where('crawl_status', CrawlStatusEnum::NOT_RUNNING)->inRandomOrder()->first();

            $crawler_name = $category->name;
            $this->info("+ Crawl $crawler_name");

            $crawler = $this->client->request('GET', $category->link);
            $post_link_selectors = explode('|', $category->post_link_selector);

            $links = [];
            foreach($post_link_selectors as $selector) {
                $ary_links = $crawler->filter(trim($selector))->extract(['href']);
                if(!empty($ary_links) && is_array($ary_links) && count($ary_links) > 0) {
                    $links = [...$links, ...$ary_links];
                }
            }

            $links = array_reverse($links);

            if(!empty($links) && is_array($links) && count($links) > 0) {
                foreach($links as $link) {
                    if(filter_var($link, FILTER_VALIDATE_URL)) {
                        $crawler = $this->client->request('GET', $link);
                        // get title
                        if(!empty($category->title_selector)) {
                            $title = $crawler->filter($category->title_selector)->text();
                        }
                        // get description
                        if(!empty($category->description_selector)) {
                            $description = $crawler->filter($category->description_selector)->text();
                        }
                        // get content
                        if(!empty($category->content_selector)) {
                            $content = $crawler->filter($category->content_selector);
                            $content_html = $content->html();
                            // get image
                            if(!empty($category->content_image_attr_selector)) {
                                $ary_attr_scr_name = explode(',', $category->content_image_attr_selector);
                                if(!empty($ary_attr_scr_name) && is_array($ary_attr_scr_name) && count($ary_attr_scr_name) > 0) {
                                    $ary_attr_scr_name = collect($ary_attr_scr_name)->map(function ($item, $key) {
                                        return trim($item);
                                    })->all();
                                    $images = $content->filter('img')->extract($ary_attr_scr_name);
                                    if(!empty($image)) {
                                        $images = collect($images)->flatten()->values()->unique()->all();
                                    }
                                }
                            }
                        }

                    } else {
                        \Log::error("$crawler_name: $link không đúng định dạng url");
                    }
                }
            }



            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
        }
    }

    protected function checkDone()
    {
        DB::beginTransaction();
        try {
            $exist_data = CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)
                ->where('crawl_status', CrawlStatusEnum::NOT_RUNNING)
                ->exists();
            if(empty($exist_data)) {
                CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)
                ->where('crawl_status', CrawlStatusEnum::DONE)
                ->update(['crawl_status' => CrawlStatusEnum::NOT_RUNNING]);
                $this->info('- UPDATE lại status_crawl');
            }
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
        }
    }
}
