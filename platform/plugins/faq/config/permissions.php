<?php

return [
    [
        'name' => 'Faqs',
        'flag' => 'faq.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'faq.create',
        'parent_flag' => 'faq.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'faq.edit',
        'parent_flag' => 'faq.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'faq.destroy',
        'parent_flag' => 'faq.index',
    ],
];
