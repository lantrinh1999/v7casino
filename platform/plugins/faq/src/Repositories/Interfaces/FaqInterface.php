<?php

namespace Botble\Faq\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface FaqInterface extends RepositoryInterface
{
    public function getFaqs($limit = 5);
}
