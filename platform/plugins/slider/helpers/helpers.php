<?php
use Botble\Slider\Repositories\Interfaces\SliderInterface;

if(!function_exists('getSliders')) {
    function getSliders($limit = 10)
    {
        return app(\Botble\Slider\Repositories\Interfaces\SliderInterface::class)->getSliders($limit);
    }
}