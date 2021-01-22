<?php

namespace Botble\Slider\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Slider\Http\Requests\SliderRequest;
use Botble\Slider\Repositories\Interfaces\SliderInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Slider\Tables\SliderTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Slider\Forms\SliderForm;
use Botble\Base\Forms\FormBuilder;

class SliderController extends BaseController
{
    /**
     * @var SliderInterface
     */
    protected $sliderRepository;

    /**
     * @param SliderInterface $sliderRepository
     */
    public function __construct(SliderInterface $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }

    /**
     * @param SliderTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(SliderTable $table)
    {
        page_title()->setTitle(trans('plugins/slider::slider.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/slider::slider.create'));

        return $formBuilder->create(SliderForm::class)->renderForm();
    }

    /**
     * @param SliderRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(SliderRequest $request, BaseHttpResponse $response)
    {
        $slider = $this->sliderRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(SLIDER_MODULE_SCREEN_NAME, $request, $slider));

        return $response
            ->setPreviousUrl(route('slider.index'))
            ->setNextUrl(route('slider.edit', $slider->id))
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
        $slider = $this->sliderRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $slider));

        page_title()->setTitle(trans('plugins/slider::slider.edit') . ' "' . $slider->name . '"');

        return $formBuilder->create(SliderForm::class, ['model' => $slider])->renderForm();
    }

    /**
     * @param $id
     * @param SliderRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, SliderRequest $request, BaseHttpResponse $response)
    {
        $slider = $this->sliderRepository->findOrFail($id);

        $slider->fill($request->input());

        $this->sliderRepository->createOrUpdate($slider);

        event(new UpdatedContentEvent(SLIDER_MODULE_SCREEN_NAME, $request, $slider));

        return $response
            ->setPreviousUrl(route('slider.index'))
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
            $slider = $this->sliderRepository->findOrFail($id);

            $this->sliderRepository->delete($slider);

            event(new DeletedContentEvent(SLIDER_MODULE_SCREEN_NAME, $request, $slider));

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
            $slider = $this->sliderRepository->findOrFail($id);
            $this->sliderRepository->delete($slider);
            event(new DeletedContentEvent(SLIDER_MODULE_SCREEN_NAME, $request, $slider));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
