<?php

namespace Botble\BlogCrawler\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\BlogCrawler\Http\Requests\CrawlerCategoryRequest;
use Botble\BlogCrawler\Models\CrawlerCategory;
use Botble\BlogCrawler\Enums\CrawlTypeEnum;
use Botble\Blog\Repositories\Interfaces\CategoryInterface;

class CrawlerCategoryForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        // dd(app(CategoryInterface::class)->getAllCategories()->mapWithKeys(function ($item) {
        //     return [$item['name'] => $item['id']];
        // })->all());
        $this
            ->setupModel(new CrawlerCategory)
            ->setValidatorClass(CrawlerCategoryRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('link', 'text', [
                'label' => trans('core/base::forms.link'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 200,
                    'placeholder' => 'Đường dẫn danh mục muốn lấy bài viết về',
                ],
            ])
            ->add('categories_id', 'customSelect', [
                'label' => 'Categories',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                    'multiple' => true
                ],
                'choices' => app(CategoryInterface::class)->getAllCategories()->mapWithKeys(function ($item) {
                    return [$item['id'] => $item['name']];
                })->all(),
            ])
            ->add('post_link_selector', 'text', [
                'label' => 'Post Link Selector',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 200,
                    'placeholder' => 'VD: div a.url',
                ],
            ])
            ->add('title_selector', 'text', [
                'label' => 'Post Title Selector',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 100,
                    'placeholder' => 'VD: #main div.title',
                ],
            ])
            ->add('image_selector', 'text', [
                'label' => 'Post Image Selector',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 100,
                    'placeholder' => 'VD: #main img.thumb',
                ],
            ])
            ->add('description_selector', 'text', [
                'label' => 'Post Description Selector',
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'data-counter' => 100,
                    'placeholder' => 'VD: div.cotent',
                ],
            ])
            ->add('content_selector', 'text', [
                'label' => 'Post Content Selector',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 100,
                    'placeholder' => 'VD: div.content',
                ],
            ])
            ->add('tag_selector', 'text', [
                'label' => 'Post Tags Selector',
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'data-counter' => 100,
                    'placeholder' => 'VD: div.tags|tag.name',
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->add('crawl_type', 'customSelect', [
                'label' => 'Loại',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',

                ],
                'choices' => CrawlTypeEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
