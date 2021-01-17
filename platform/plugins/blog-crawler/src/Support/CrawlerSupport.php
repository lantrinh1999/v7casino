<?php
namespace Botble\BlogCrawler\Support;

use Botble\BlogCrawler\Enums\CrawlStatusEnum;
use Botble\Base\Enums\BaseStatusEnum;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Botble\BlogCrawler\Models\CrawlerCategory;
use Illuminate\Support\Facades\DB;

class CrawlerSupport {

    protected $category_link;
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getPostLinks()
    {
        DB::beginTransaction();

        try {
            $this->checkDone();
            $category = CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)
                ->where('crawl_status', CrawlStatusEnum::NOT_RUNNING)
                ->inRandomOrder()->first();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
        }
    }

    protected function checkDone()
    {
        try {
            $exist_data = CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)
                ->where('crawl_status', CrawlStatusEnum::NOT_RUNNING)
                ->exists();
            if(empty($exist_data)) {
                CrawlerCategory::where('status', BaseStatusEnum::PUBLISHED)
                ->where('crawl_status', CrawlStatusEnum::DONE)
                ->update(['crawl_status' => CrawlStatusEnum::NOT_RUNNING]);
            }
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
        }
    }


}