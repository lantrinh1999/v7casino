<?php

namespace Botble\AppManager\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class AppManager extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_managers';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'urlLogin',
        'urlRegister',
        'mode',
        'slug',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
