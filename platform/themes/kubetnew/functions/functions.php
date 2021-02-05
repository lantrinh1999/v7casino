<?php
if (empty(app()->runningInConsole())) {
    Menu::addMenuLocation('bet-footer-1', 'Footer 1');
    Menu::addMenuLocation('bet-footer-2', 'Footer 2');
    Menu::addMenuLocation('bet-footer-3', 'Footer 3');
    Menu::addMenuLocation('bet-footer-4', 'Footer 4');
    Menu::addMenuLocation('bet-footer-5', 'Footer 5');
    Menu::removeMenuLocation('header-menu');
    Menu::removeMenuLocation('footer-menu');

    register_page_template([
        'default' => 'Default',
    ]);

    register_sidebar([
        'id' => 'second_sidebar',
        'name' => 'Second sidebar',
        'description' => 'This is a sample sidebar for bet theme',
    ]);

    theme_option()
        ->setField([
            'id' => 'copyright',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'text',
            'label' => __('Copyright'),
            'attributes' => [
                'name' => 'copyright',
                'value' => '© 2021 KUBET. All right reserved.',
                'options' => [
                    'class' => 'form-control',
                    'placeholder' => __('Change copyright'),
                    'data-counter' => 250,
                ],
            ],
            'helper' => __('Copyright on footer of site'),
        ])
        // ->setField([
        //     'id' => 'primary_font',
        //     'section_id' => 'opt-text-subsection-general',
        //     'type' => 'googleFonts',
        //     'label' => __('Primary font'),
        //     'attributes' => [
        //         'name' => 'primary_font',
        //         'value' => 'Roboto',
        //     ],
        // ])
        ->setField([
            'id' => 'primary_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => 'Màu chủ đạo',
            'attributes' => [
                'name' => 'primary_color',
                'value' => '#D88C46',
            ],
        ])
        ->setField([
            'id' => 'header_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => 'Màu header',
            'attributes' => [
                'name' => 'header_color',
                'value' => '#021F42',
            ],
        ])
        ->setField([
            'id' => 'header_color_2',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => 'Màu Menu',
            'attributes' => [
                'name' => 'header_color_2',
                'value' => '#021F42',
            ],
        ])
        ->setField([
            'id' => 'header_text_color_2',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => 'Màu Chữ Menu',
            'attributes' => [
                'name' => 'header_text_color_2',
                'value' => '#FFFFFF',
            ],
        ])
        ->setField([
            'id' => 'footer_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => 'Màu footer',
            'attributes' => [
                'name' => 'footer_color',
                'value' => '#353F4B',
            ],
        ])
        ->setField([
            'id' => 'background_color',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'customColor',
            'label' => 'Màu background',
            'attributes' => [
                'name' => 'background_color',
                'value' => '#021F42',
            ],
        ])
        ->setField([
            'id' => 'img_qr',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'mediaImage',
            'label' => 'QR',
            'attributes' => [
                'name' => 'img_qr',
                'value' => null,
            ],
        ])
        ->setField([ // Set field for section
            'id' => 'marquee',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'textarea',
            'label' => 'Marquee',
            'attributes' => [
                'name' => 'marquee',
                'value' => 'KUBE tiên phong giải trí online, KUBET chuyên trang cá cược trực truyến có thực lực nhất 2020, hàng nghàn giải thưởng cao cấp đang chờ quý khách đến nhận!', // Default value
                'options' => [ // Optional
                    'class' => 'form-control theme-option-textarea',
                    'row' => 2,
                ],
            ],
        ])
        ->setField([
            'id' => 'horizontal_banner',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'mediaImage',
            'label' => 'Banner ngang',
            'attributes' => [
                'name' => 'horizontal_banner',
                'value' => null,
            ],
        ])

        // ->setField([
        //     'id' => 'download_url',
        //     'section_id' => 'opt-text-subsection-general',
        //     'type' => 'url',
        //     'label' => "Đường dẫn download",
        //     'attributes' => [
        //         'name' => 'download_url',
        //         'value' => null,
        //         'options' => [
        //             'class' => 'form-control',
        //             'data-counter' => 250,
        //         ],
        //     ],
        // ])
    ;

// trang chủ
    theme_option()
        ->setSection([ // Set section with no field
            'title' => __('Trang chủ'),
            'desc' => __('Cài đặt trang chủ'),
            'id' => 'Home-setting',
            'subsection' => true,
            'icon' => 'fa fa-home',
        ])
        ->setField([
            'id' => 'home-category-title-1',
            'section_id' => 'Home-setting',
            'type' => 'text',
            'label' => 'Tiêu đề danh mục 1',
            'attributes' => [
                'name' => 'home-category-title-1',
                'value' => 'Ku bet new',
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 300,
                ],
            ],
        ]);
    if (!empty(\Botble\Blog\Repositories\Interfaces\CategoryInterface::class)) {
        theme_option()->setField([
            'id' => 'home-category-1',
            'section_id' => 'Home-setting',
            'type' => 'customSelect',
            'label' => 'Danh mục 1',
            'attributes' => [
                'name' => 'home-category-1',
                'values' => app(\Botble\Blog\Repositories\Interfaces\CategoryInterface::class)->getModel()->all()
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => $item['name']];
                    })->all(),
            ],
        ]);
    }

    theme_option()->setField([
        'id' => 'home-category-title-2',
        'section_id' => 'Home-setting',
        'type' => 'text',
        'label' => 'Tiêu đề danh mục 2',
        'attributes' => [
            'name' => 'home-category-title-2',
            'value' => 'Ku bet new',
            'options' => [
                'class' => 'form-control',
                'data-counter' => 300,
            ],
        ],
    ]);
    if (!empty(\Botble\Blog\Repositories\Interfaces\CategoryInterface::class)) {
        theme_option()->setField([
            'id' => 'home-category-2',
            'section_id' => 'Home-setting',
            'type' => 'customSelect',
            'label' => 'Danh mục 2',
            'attributes' => [
                'name' => 'home-category-2',
                'values' => app(\Botble\Blog\Repositories\Interfaces\CategoryInterface::class)->getModel()->all()
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => $item['name']];
                    })->all(),
            ],

        ]);
    }
    theme_option()->setField([ // Set field for section
        'id' => 'home-description',
        'section_id' => 'Home-setting',
        'type' => 'editor',
        'label' => 'Giới thiệu chung',
        'attributes' => [
            'name' => 'home-description',
            'value' => null, // Default value
            'options' => [ // Optional
                'class' => 'form-control theme-option-textarea',
                'row' => '10',
            ],
        ],
    ]);

// button header
    theme_option()
        ->setSection([ // Set section with no field
            'title' => __('Nút trên Header'),
            'desc' => __('Nút trên Header'),
            'id' => 'header-button',
            'subsection' => true,
            'icon' => 'fa fa-list',
        ])
        ->setField([
            'id' => 'login-button',
            'section_id' => 'header-button',
            'type' => 'text',
            'label' => 'Nút đăng nhập',
            'attributes' => [
                'name' => 'login-button',
                'value' => 'https://google.com/',
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 300,
                ],
            ],
        ])
        ->setField([
            'id' => 'register-button',
            'section_id' => 'header-button',
            'type' => 'text',
            'label' => 'Nút đăng ký',
            'attributes' => [
                'name' => 'register-button',
                'value' => 'https://google.com/',
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 300,
                ],
            ],
        ])
        ->setField([
            'id' => 'tutorial-button',
            'section_id' => 'header-button',
            'type' => 'text',
            'label' => 'Nút hướng dẫn',
            'attributes' => [
                'name' => 'tutorial-button',
                'value' => 'https://google.com/',
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 300,
                ],
            ],
        ])
        ->setField([
            'id' => 'download-button',
            'section_id' => 'header-button',
            'type' => 'text',
            'label' => 'Nút download',
            'attributes' => [
                'name' => 'download-button',
                'value' => 'https://google.com/',
                'options' => [
                    'class' => 'form-control',
                    'data-counter' => 300,
                ],
            ],
        ])

    ;

    add_action('init', function () {
        config(['filesystems.disks.public.root' => public_path('storage')]);
    }, 124);

}
