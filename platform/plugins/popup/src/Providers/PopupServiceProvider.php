<?php

namespace Botble\Popup\Providers;

use Botble\Popup\Models\Popup;
use Illuminate\Support\ServiceProvider;
use Botble\Popup\Repositories\Caches\PopupCacheDecorator;
use Botble\Popup\Repositories\Eloquent\PopupRepository;
use Botble\Popup\Repositories\Interfaces\PopupInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class PopupServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(PopupInterface::class, function () {
            return new PopupCacheDecorator(new PopupRepository(new Popup));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/popup')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web', 'api']);

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-popup',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/popup::popup.name',
                'icon'        => 'fa fa-list',
                'url'         => route('popup.index'),
                'permissions' => ['popup.index'],
            ]);
        });
    }
}
