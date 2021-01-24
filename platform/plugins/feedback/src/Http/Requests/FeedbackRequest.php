<?php

namespace Botble\Feedback\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class FeedbackRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required',
            'description'   => 'required',
            'image'   => 'required',
            'order'   => 'nullable|numeric',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
