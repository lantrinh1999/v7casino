<?php

namespace Botble\BlogCrawler\Models;

use Botble\Base\Models\BaseModel;

class CrawlerPost extends BaseModel
{
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
        'crawler_category_id',
        'post_id',
        'link',
        'crawl_status',
    ];
}
