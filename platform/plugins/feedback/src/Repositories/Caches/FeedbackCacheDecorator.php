<?php

namespace Botble\Feedback\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Feedback\Repositories\Interfaces\FeedbackInterface;

class FeedbackCacheDecorator extends CacheAbstractDecorator implements FeedbackInterface
{
    public function getFeedbacks(int $limit = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

}
