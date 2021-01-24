<?php

if(!function_exists('getFeedbacks')) {
    function getFeedbacks($limit = 10)
    {
        return app(\Botble\Feedback\Repositories\Interfaces\FeedbackInterface::class)->getFeedbacks($limit);
    }
}