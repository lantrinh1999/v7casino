<?php

namespace Botble\Slider\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface SliderInterface extends RepositoryInterface
{
    public function getSliders(int $limit = 10);
}
