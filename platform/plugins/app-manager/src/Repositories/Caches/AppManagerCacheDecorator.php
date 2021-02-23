<?php

namespace Botble\AppManager\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\AppManager\Repositories\Interfaces\AppManagerInterface;

class AppManagerCacheDecorator extends CacheAbstractDecorator implements AppManagerInterface
{
    public function getApp($slug)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
