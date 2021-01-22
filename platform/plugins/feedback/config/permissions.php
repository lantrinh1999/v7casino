<?php

return [
    [
        'name' => 'Feedback',
        'flag' => 'feedback.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'feedback.create',
        'parent_flag' => 'feedback.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'feedback.edit',
        'parent_flag' => 'feedback.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'feedback.destroy',
        'parent_flag' => 'feedback.index',
    ],
];
