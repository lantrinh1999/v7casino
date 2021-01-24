<?php

namespace Botble\Feedback\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\Feedback\Repositories\Interfaces\FeedbackInterface;

class FeedbackRepository extends RepositoriesAbstract implements FeedbackInterface
{
    public function getFeedbacks(int $limit = 10)
    {
        return $this->model->where([
            'status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
        ])->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'asc')
            ->limit($limit)->get();
    }
}
