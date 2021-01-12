<?php

namespace Botble\BlogCrawler\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Base\Traits\EnumCastable;

class CrawlerCategory extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'crawler_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'categories_id',
        'post_link_selector',
        'title_selector',
        'image_selector',
        'description_selector',
        'content_selector',
        'tag_selector',
        'crawl_status',
        'crawl_type',
        'status',
        'complete_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
