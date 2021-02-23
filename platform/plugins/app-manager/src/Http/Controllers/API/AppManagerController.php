<?php

namespace Botble\AppManager\Http\Controllers\API;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\AppManager\Http\Requests\AppManagerRequest;
use Botble\AppManager\Repositories\Interfaces\AppManagerInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\AppManager\Tables\AppManagerTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\AppManager\Forms\AppManagerForm;
use Botble\Base\Forms\FormBuilder;

class AppManagerController extends BaseController
{
    /**
     * @var AppManagerInterface
     */
    protected $appManagerRepository;

    /**
     * @param AppManagerInterface $appManagerRepository
     */
    public function __construct(AppManagerInterface $appManagerRepository)
    {
        $this->appManagerRepository = $appManagerRepository;
    }

    public function getApp($slug) {
        return $this->appManagerRepository->getApp($slug);
    }

    public function getAllApp() {
        $apps = $this->appManagerRepository->allBy(['status' => 'published'], [], ['name', 'slug', 'urlLogin', 'urlRegister', 'mode'])->toArray();
        // dd($apps);
        return array_map(function($value){
            $value['api'] = route('get_app', $value['slug']);

            return $value;
        }, $apps);
    }

}
