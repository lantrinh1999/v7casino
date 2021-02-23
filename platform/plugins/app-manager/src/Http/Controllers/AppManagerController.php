<?php

namespace Botble\AppManager\Http\Controllers;

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

    /**
     * @param AppManagerTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(AppManagerTable $table)
    {
        page_title()->setTitle(trans('plugins/app-manager::app-manager.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/app-manager::app-manager.create'));

        return $formBuilder->create(AppManagerForm::class)->renderForm();
    }

    /**
     * @param AppManagerRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(AppManagerRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input();
        $slug = \Illuminate\Support\Str::of($request->input('name'))->slug('-');
        $check = $this->appManagerRepository->getModel()->where('slug', $slug)->orderBy('id', 'desc')->first();
        if(!empty($check)) {
            $l = explode('-', $check->slug);
            if(!empty(end($l))) {
                $n = (int) end($l);
            }
            if(!empty($n)) {
                $slug .= '-' . $n++;
            } else {
                $slug .= '-' . 1;
            }
        }
        $data['slug'] = $slug;
        $request->replace($data);
        // dd($request->input());
        $appManager = $this->appManagerRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(APP_MANAGER_MODULE_SCREEN_NAME, $request, $appManager));

        return $response
            ->setPreviousUrl(route('app-manager.index'))
            ->setNextUrl(route('app-manager.edit', $appManager->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $appManager = $this->appManagerRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $appManager));

        page_title()->setTitle(trans('plugins/app-manager::app-manager.edit') . ' "' . $appManager->name . '"');

        return $formBuilder->create(AppManagerForm::class, ['model' => $appManager])->renderForm();
    }

    /**
     * @param $id
     * @param AppManagerRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, AppManagerRequest $request, BaseHttpResponse $response)
    {
        $appManager = $this->appManagerRepository->findOrFail($id);

        $appManager->fill($request->input());

        $this->appManagerRepository->createOrUpdate($appManager);

        event(new UpdatedContentEvent(APP_MANAGER_MODULE_SCREEN_NAME, $request, $appManager));

        return $response
            ->setPreviousUrl(route('app-manager.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $appManager = $this->appManagerRepository->findOrFail($id);

            $this->appManagerRepository->delete($appManager);

            event(new DeletedContentEvent(APP_MANAGER_MODULE_SCREEN_NAME, $request, $appManager));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $appManager = $this->appManagerRepository->findOrFail($id);
            $this->appManagerRepository->delete($appManager);
            event(new DeletedContentEvent(APP_MANAGER_MODULE_SCREEN_NAME, $request, $appManager));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
