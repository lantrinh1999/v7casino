<?php

namespace Botble\Feedback\Providers;

use Botble\Feedback\Models\Feedback;
use Illuminate\Support\ServiceProvider;
use Botble\Feedback\Repositories\Caches\FeedbackCacheDecorator;
use Botble\Feedback\Repositories\Eloquent\FeedbackRepository;
use Botble\Feedback\Repositories\Interfaces\FeedbackInterface;
use Botble\Base\Supports\Helper;
use Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class FeedbackServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(FeedbackInterface::class, function () {
            return new FeedbackCacheDecorator(new FeedbackRepository(new Feedback));
        });

        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/feedback')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {
            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                \Language::registerModule([Feedback::class]);
            }

            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-feedback',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/feedback::feedback.name',
                'icon'        => 'fa fa-list',
                'url'         => route('feedback.index'),
                'permissions' => ['feedback.index'],
            ]);
        });
    }
}
