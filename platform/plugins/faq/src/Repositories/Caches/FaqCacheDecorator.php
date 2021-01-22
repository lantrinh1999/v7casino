<?php

namespace Botble\Faq\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Faq\Repositories\Interfaces\FaqInterface;

class FaqCacheDecorator extends CacheAbstractDecorator implements FaqInterface
{
    public function getFaqs($limit = 5)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
