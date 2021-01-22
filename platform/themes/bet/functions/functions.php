<?php

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
            'value' => '© 2021 Kubet. All right reserved.',
            'options' => [
                'class' => 'form-control',
                'placeholder' => __('Change copyright'),
                'data-counter' => 250,
            ],
        ],
        'helper' => __('Copyright on footer of site'),
    ])
    ->setField([
        'id' => 'primary_font',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'googleFonts',
        'label' => __('Primary font'),
        'attributes' => [
            'name' => 'primary_font',
            'value' => 'Roboto',
        ],
    ])
    ->setField([
        'id' => 'header_color',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'customColor',
        'label' => 'Màu header',
        'attributes' => [
            'name' => 'header_color',
            'value' => '#ff2b4a',
        ],
    ])
    ->setField([
        'id' => 'background_color',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'customColor',
        'label' => 'Màu background',
        'attributes' => [
            'name' => 'background_color',
            'value' => '#00305661',
        ],
    ])
    ->setField([
        'id' => 'primary_color',
        'section_id' => 'opt-text-subsection-general',
        'type' => 'customColor',
        'label' => __('Primary color'),
        'attributes' => [
            'name' => 'primary_color',
            'value' => '#ff2b4a',
        ],
    ]);
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
    ])
    ->setField([
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

    ])
    ->setField([
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
    ])
    ->setField([
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

    ])
    ->setField([ // Set field for section
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

;

add_action('init', function () {
    config(['filesystems.disks.public.root' => public_path('storage')]);
}, 124);
