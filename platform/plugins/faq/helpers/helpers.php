<?php
use Botble\Faq\Repositories\Interfaces\FaqInterface;

if(!function_exists('getFaqs')) {
    function getFaqs($limit = 5)
    {
        return app(FaqInterface::class)->getFaqs($limit);
    }
}