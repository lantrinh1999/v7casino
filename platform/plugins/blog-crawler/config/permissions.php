<?php

return [
    [
        'name' => 'Blog crawlers',
        'flag' => 'blog-crawler.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'blog-crawler.create',
        'parent_flag' => 'blog-crawler.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'blog-crawler.edit',
        'parent_flag' => 'blog-crawler.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'blog-crawler.destroy',
        'parent_flag' => 'blog-crawler.index',
    ],
];
