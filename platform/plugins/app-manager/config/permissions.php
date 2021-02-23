<?php

return [
    [
        'name' => 'App managers',
        'flag' => 'app-manager.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'app-manager.create',
        'parent_flag' => 'app-manager.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'app-manager.edit',
        'parent_flag' => 'app-manager.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'app-manager.destroy',
        'parent_flag' => 'app-manager.index',
    ],
];
