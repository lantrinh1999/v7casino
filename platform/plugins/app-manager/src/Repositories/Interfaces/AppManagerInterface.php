<?php

namespace Botble\AppManager\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface AppManagerInterface extends RepositoryInterface
{
    public function getApp($slug);
}
