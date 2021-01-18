<?php

namespace Botble\Feedback\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Feedback\Http\Requests\FeedbackRequest;
use Botble\Feedback\Repositories\Interfaces\FeedbackInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Feedback\Tables\FeedbackTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Feedback\Forms\FeedbackForm;
use Botble\Base\Forms\FormBuilder;

class FeedbackController extends BaseController
{
    /**
     * @var FeedbackInterface
     */
    protected $feedbackRepository;

    /**
     * @param FeedbackInterface $feedbackRepository
     */
    public function __construct(FeedbackInterface $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @param FeedbackTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(FeedbackTable $table)
    {
        page_title()->setTitle(trans('plugins/feedback::feedback.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/feedback::feedback.create'));

        return $formBuilder->create(FeedbackForm::class)->renderForm();
    }

    /**
     * @param FeedbackRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(FeedbackRequest $request, BaseHttpResponse $response)
    {
        $feedback = $this->feedbackRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(FEEDBACK_MODULE_SCREEN_NAME, $request, $feedback));

        return $response
            ->setPreviousUrl(route('feedback.index'))
            ->setNextUrl(route('feedback.edit', $feedback->id))
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
        $feedback = $this->feedbackRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $feedback));

        page_title()->setTitle(trans('plugins/feedback::feedback.edit') . ' "' . $feedback->name . '"');

        return $formBuilder->create(FeedbackForm::class, ['model' => $feedback])->renderForm();
    }

    /**
     * @param $id
     * @param FeedbackRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, FeedbackRequest $request, BaseHttpResponse $response)
    {
        $feedback = $this->feedbackRepository->findOrFail($id);

        $feedback->fill($request->input());

        $this->feedbackRepository->createOrUpdate($feedback);

        event(new UpdatedContentEvent(FEEDBACK_MODULE_SCREEN_NAME, $request, $feedback));

        return $response
            ->setPreviousUrl(route('feedback.index'))
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
            $feedback = $this->feedbackRepository->findOrFail($id);

            $this->feedbackRepository->delete($feedback);

            event(new DeletedContentEvent(FEEDBACK_MODULE_SCREEN_NAME, $request, $feedback));

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
            $feedback = $this->feedbackRepository->findOrFail($id);
            $this->feedbackRepository->delete($feedback);
            event(new DeletedContentEvent(FEEDBACK_MODULE_SCREEN_NAME, $request, $feedback));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
