<?php

namespace Botble\Feedback\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface FeedbackInterface extends RepositoryInterface
{
    public function getFeedbacks(int $limit = 10);
}
