<?php

namespace Botble\AppManager\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\AppManager\Http\Requests\AppManagerRequest;
use Botble\AppManager\Models\AppManager;

class AppManagerForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $this
            ->setupModel(new AppManager)
            ->setValidatorClass(AppManagerRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('urlLogin', 'text', [
                'label'      => "URL LOGIN",
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    // 'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 255,
                ],
            ])
            ->add('urlRegister', 'text', [
                'label'      => "URL REGISTER",
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    // 'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 255,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('mode', 'onOff', [
                'label'      => 'MODE',
                'label_attr'    => ['class' => 'control-label required'],
                'default_value' => true,
            ])
            ->setBreakFieldPoint('status');
    }
}
