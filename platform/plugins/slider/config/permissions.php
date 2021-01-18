<?php

return [
    [
        'name' => 'Sliders',
        'flag' => 'slider.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'slider.create',
        'parent_flag' => 'slider.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'slider.edit',
        'parent_flag' => 'slider.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'slider.destroy',
        'parent_flag' => 'slider.index',
    ],
];
