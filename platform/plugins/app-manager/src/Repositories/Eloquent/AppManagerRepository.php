<?php

namespace Botble\AppManager\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\AppManager\Repositories\Interfaces\AppManagerInterface;

class AppManagerRepository extends RepositoriesAbstract implements AppManagerInterface
{
    public function getApp($slug)
    {
        $data = $this->getModel()->where('slug', $slug)->select(['name', 'urlLogin', 'urlRegister', 'mode'])->first()->toArray();
        if(isset($data['mode'])) {
            $data['mode'] = (bool) $data['mode'];
        }
        return $data;
    }
}
