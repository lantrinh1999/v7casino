<?php

namespace Botble\Faq\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Faq\Http\Requests\FaqRequest;
use Botble\Faq\Models\Faq;

class FaqForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Faq)
            ->setValidatorClass(FaqRequest::class)
            ->withCustomFields()
            ->add('title', 'text', [
                'label' => trans('core/base::forms.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 120,
                ],
            ])
            ->add('content', 'editor', [
                'label' => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 5,
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
            ->add('order', 'number', [
                'label' => 'Vị trí',
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'min' => 0,
                    'max' => 99999,
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
