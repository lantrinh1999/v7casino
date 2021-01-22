<?php

namespace Botble\Slider\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Slider\Repositories\Interfaces\SliderInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class SliderRepository extends RepositoriesAbstract implements SliderInterface
{
    public function getSliders(int $limit = 10)
    {
        return $this->model->where([
            'status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
        ])->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'asc')
            ->limit($limit)->get();
    }
}
