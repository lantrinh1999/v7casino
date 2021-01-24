<?php

namespace Botble\Faq\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\Faq\Repositories\Interfaces\FaqInterface;

class FaqRepository extends RepositoriesAbstract implements FaqInterface
{
    public function getFaqs($limit = 5)
    {
        return $this->model->where([
            'status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
        ])->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'asc')
            ->limit($limit)->get();
    }
}
