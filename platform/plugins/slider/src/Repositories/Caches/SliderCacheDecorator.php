<?php

namespace Botble\Slider\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Slider\Repositories\Interfaces\SliderInterface;

class SliderCacheDecorator extends CacheAbstractDecorator implements SliderInterface
{
    public function getSliders(int $limit = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
