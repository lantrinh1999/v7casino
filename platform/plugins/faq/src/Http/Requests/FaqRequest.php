<?php

namespace Botble\Faq\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FaqRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'   => 'required',
            'content'   => 'required',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
