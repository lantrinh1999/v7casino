<?php

return [
    [
        'name' => 'Popups',
        'flag' => 'popup.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'popup.create',
        'parent_flag' => 'popup.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'popup.edit',
        'parent_flag' => 'popup.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'popup.destroy',
        'parent_flag' => 'popup.index',
    ],
];
