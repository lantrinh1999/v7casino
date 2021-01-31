<?php

use Botble\Theme\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials" and "views"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function (Theme $theme)
        {
            // Partial composer.
            // $theme->partialComposer('header', function($view) {
            //     $view->with('auth', \Auth::user());
            // });

            // <link rel="stylesheet" href="vendor/bootstrap-5.0.0-beta1-dist/css/bootstrap.min.css">
            // <link rel="stylesheet" href="vendor/slick-1.8.1/slick/slick.css">
            // <link rel="stylesheet" href="vendor/slick-1.8.1/slick/slick-theme.css">
            // <link rel="stylesheet" href="vendor/fontawesome-free-5.15.1-web/css/all.min.css">
            // <link rel="stylesheet" href="vendor/mmenu-light/dist/mmenu-light.css">
            // <link rel="stylesheet" href="css/style.css">
            // You may use this event to set up your assets.

            // <script src="vendor/jQuery-3.5.1/jquery-3.5.1.min.js"></script>
            // <script src="vendor/bootstrap-5.0.0-beta1-dist/js/bootstrap.min.js"></script>
            // <script src="vendor/slick-1.8.1/slick/slick.min.js"></script>
            // <script src="vendor/mmenu-light/dist/mmenu-light.js"></script>
            // <script src="vendor/waypoints/lib/jquery.waypoints.min.js"></script>
            // <script src="vendor/waypoints/src/shortcuts/sticky.js"></script>
            // <script src="js/script.js"></script>

            $theme
                ->asset()
                ->container('footer')
                ->usePath()->add('jquery', 'js/jquery-3.5.1.min.js')
                // ->usePath()->add('bootstrap-js3', 'js/bootstrap3.min.js', ['jquery'])
                ->usePath()->add('bootstrap-js', 'js/bootstrap.min.js', ['jquery'])
                ->usePath()->add('slick-js', 'js/slick.min.js', ['jquery'], [], '5.11')
                ->usePath()->add('mmenu-light-js', 'js/mmenu-light.js', ['jquery'], [], '5.11')
                ->usePath()->add('jquery-waypoints-min-js', 'js/jquery.waypoints.min.js', ['jquery'], [], '5.11')
                ->usePath()->add('sticky-js', 'js/sticky.js', ['jquery'], [], '5.11')
                ->usePath()->add('script-js', 'js/script.js', ['jquery'], [], '5.11.1');

            $theme
                ->asset()
                ->usePath()->add('bootstrap-css', 'css/bootstrap.min.css')
                ->usePath()->add('font-awesome-css', 'css/all.min.css')
                ->usePath()->add('slick-css', 'css/slick.css')
                ->usePath()->add('slick-theme-css', 'css/slick-theme.css')
                ->usePath()->add('mmenu-light-css', 'css/mmenu-light.css')
                ->usePath()->add('custom', 'css/custom.css', [], [], '5.11.2')
                ->usePath()->add('style', 'css/style.css', [], [], '5.11.20011012311');

            if (function_exists('shortcode')) {
                $theme->composer(['index', 'page', 'post'], function (\Botble\Shortcode\View\View $view) {
                    $view->withShortcodes();
                });
            }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [

            'default' => function ($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            }
        ]
    ]
];
