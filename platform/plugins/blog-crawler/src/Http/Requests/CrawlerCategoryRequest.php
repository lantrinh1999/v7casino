<?php

namespace Botble\BlogCrawler\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;
use Botble\BlogCrawler\Enums\CrawlTypeEnum;
class CrawlerCategoryRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'link' => 'required',
            'categories_id' => 'required',
            'post_link_selector' => 'required',
            'title_selector' => 'required',
            // 'image_selector' => 'nullable',
            // 'description_selector' => 'required',
            'content_selector' => 'required',
            // 'content_image_attr_selector' => 'nullable',
            // 'tag_selector' => 'nullable',
            // 'crawl_status' => 'required',
            'crawl_type' => Rule::in(CrawlTypeEnum::values()),
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
