<?php

namespace Botble\Slider\Providers;

use Botble\Slider\Models\Slider;
use Illuminate\Support\ServiceProvider;
use Botble\Slider\Repositories\Caches\SliderCacheDecorator;
use Botble\Slider\Repositories\Eloquent\SliderRepository;
use Botble\Slider\Repositories\Interfaces\SliderInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class SliderServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(SliderInterface::class, function () {
            return new SliderCacheDecorator(new SliderRepository(new Slider));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/slider')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Slider::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-slider',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/slider::slider.name',
                'icon'        => 'fa fa-list',
                'url'         => route('slider.index'),
                'permissions' => ['slider.index'],
            ]);
        });
    }
}
