<?php

namespace Botble\AppManager\Providers;

use Botble\AppManager\Models\AppManager;
use Illuminate\Support\ServiceProvider;
use Botble\AppManager\Repositories\Caches\AppManagerCacheDecorator;
use Botble\AppManager\Repositories\Eloquent\AppManagerRepository;
use Botble\AppManager\Repositories\Interfaces\AppManagerInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class AppManagerServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(AppManagerInterface::class, function () {
            return new AppManagerCacheDecorator(new AppManagerRepository(new AppManager));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/app-manager')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web', 'api']);

        Event::listen(RouteMatched::class, function () {
            // if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            //     \Language::registerModule([AppManager::class]);
            // }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-app-manager',
                'priority'    => 9,
                'parent_id'   => null,
                'name'        => 'Quản lý APP',
                'icon'        => 'fa fa-list',
                'url'         => route('app-manager.index'),
                'permissions' => ['app-manager.index'],
            ]);
        });
    }
}
