<?php

namespace Botble\Faq\Providers;

use Botble\Faq\Models\Faq;
use Illuminate\Support\ServiceProvider;
use Botble\Faq\Repositories\Caches\FaqCacheDecorator;
use Botble\Faq\Repositories\Eloquent\FaqRepository;
use Botble\Faq\Repositories\Interfaces\FaqInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class FaqServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(FaqInterface::class, function () {
            return new FaqCacheDecorator(new FaqRepository(new Faq));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/faq')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Faq::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-faq',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/faq::faq.name',
                'icon'        => 'fa fa-list',
                'url'         => route('faq.index'),
                'permissions' => ['faq.index'],
            ]);
        });
    }
}
