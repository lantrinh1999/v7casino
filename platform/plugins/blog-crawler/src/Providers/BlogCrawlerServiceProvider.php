<?php

namespace Botble\BlogCrawler\Providers;

use Botble\Base\Supports\Helper;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\BlogCrawler\Models\CrawlerCategory;
use Botble\BlogCrawler\Models\CrawlerPost;
use Botble\BlogCrawler\Repositories\Caches\CrawlerCategoryCacheDecorator;
use Botble\BlogCrawler\Repositories\Caches\CrawlerPostCacheDecorator;
use Botble\BlogCrawler\Repositories\Eloquent\CrawlerCategoryRepository;
use Botble\BlogCrawler\Repositories\Eloquent\CrawlerPostRepository;
use Botble\BlogCrawler\Repositories\Interfaces\CrawlerCategoryInterface;
use Botble\BlogCrawler\Repositories\Interfaces\CrawlerPostInterface;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;

class BlogCrawlerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(CrawlerPostInterface::class, function () {
            return new CrawlerPostCacheDecorator(new CrawlerPostRepository(new CrawlerPost));
        });
        $this->app->bind(CrawlerCategoryInterface::class, function () {
            return new CrawlerCategoryCacheDecorator(new CrawlerCategoryRepository(new CrawlerCategory));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/blog-crawler')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([BlogCrawler::class]);
            }

            dashboard_menu()->registerItem([
                'id' => 'cms-plugins-blog-crawler',
                'priority' => 5,
                'parent_id' => null,
                'name' => 'plugins/blog-crawler::blog-crawler.name',
                'icon' => 'fa fa-list',
                'url' => route('blog-crawler.index'),
                'permissions' => ['blog-crawler.index'],
            ]);
        });
    }
}
