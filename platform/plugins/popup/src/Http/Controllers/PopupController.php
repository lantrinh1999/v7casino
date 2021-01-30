<?php

namespace Botble\Popup\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Popup\Http\Requests\PopupRequest;
use Botble\Popup\Repositories\Interfaces\PopupInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Popup\Tables\PopupTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Popup\Forms\PopupForm;
use Botble\Base\Forms\FormBuilder;

class PopupController extends BaseController
{
    /**
     * @var PopupInterface
     */
    protected $popupRepository;

    /**
     * @param PopupInterface $popupRepository
     */
    public function __construct(PopupInterface $popupRepository)
    {
        $this->popupRepository = $popupRepository;
    }

    /**
     * @param PopupTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(PopupTable $table)
    {
        page_title()->setTitle(trans('plugins/popup::popup.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/popup::popup.create'));

        return $formBuilder->create(PopupForm::class)->renderForm();
    }

    /**
     * @param PopupRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(PopupRequest $request, BaseHttpResponse $response)
    {
        $popup = $this->popupRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(POPUP_MODULE_SCREEN_NAME, $request, $popup));

        return $response
            ->setPreviousUrl(route('popup.index'))
            ->setNextUrl(route('popup.edit', $popup->id))
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
        return;
        $popup = $this->popupRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $popup));

        page_title()->setTitle(trans('plugins/popup::popup.edit') . ' "' . $popup->name . '"');

        return $formBuilder->create(PopupForm::class, ['model' => $popup])->renderForm();
    }

    /**
     * @param $id
     * @param PopupRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, PopupRequest $request, BaseHttpResponse $response)
    {
        return;
        $popup = $this->popupRepository->findOrFail($id);

        $popup->fill($request->input());

        $this->popupRepository->createOrUpdate($popup);

        event(new UpdatedContentEvent(POPUP_MODULE_SCREEN_NAME, $request, $popup));

        return $response
            ->setPreviousUrl(route('popup.index'))
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
            $popup = $this->popupRepository->findOrFail($id);

            $this->popupRepository->delete($popup);

            event(new DeletedContentEvent(POPUP_MODULE_SCREEN_NAME, $request, $popup));

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
            $popup = $this->popupRepository->findOrFail($id);
            $this->popupRepository->delete($popup);
            event(new DeletedContentEvent(POPUP_MODULE_SCREEN_NAME, $request, $popup));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function apiSendInfo(PopupRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input();
        $data['ip'] = $request->ip();
        $data['agent'] = $request->server('HTTP_USER_AGENT');
        foreach($data as $a) {
            $a = \clean($a);
        }
        $popup = $this->popupRepository->createOrUpdate($data);
        \Session::put('dont_show_popup', '1234');
    }
}
