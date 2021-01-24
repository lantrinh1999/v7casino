<?php

namespace Botble\BlogCrawler\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\BlogCrawler\Forms\CrawlerCategoryForm;
use Botble\BlogCrawler\Http\Requests\CrawlerCategoryRequest;
use Botble\BlogCrawler\Repositories\Interfaces\CrawlerCategoryInterface;
use Botble\BlogCrawler\Tables\CrawlerCategoryTable;
use Exception;
use Illuminate\Http\Request;

class CrawlerCategoryController extends BaseController
{
    /**
     * @var CrawlerCategoryInterface
     */
    protected $blogCrawlerRepository;

    /**
     * @param CrawlerCategoryInterface $blogCrawlerRepository
     */
    public function __construct(CrawlerCategoryInterface $blogCrawlerRepository)
    {
        $this->blogCrawlerRepository = $blogCrawlerRepository;
    }

    /**
     * @param CrawlerCategoryTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(CrawlerCategoryTable $table)
    {
        page_title()->setTitle(trans('plugins/blog-crawler::blog-crawler.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/blog-crawler::blog-crawler.create'));

        return $formBuilder->create(CrawlerCategoryForm::class)->renderForm();
    }

    /**
     * @param CrawlerCategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CrawlerCategoryRequest $request, BaseHttpResponse $response)
    {
        $data = $request->all();

        $data['categories_id'] = json_encode($request->categories_id);
        $blogCrawler = $this->blogCrawlerRepository->createOrUpdate($data);

        event(new CreatedContentEvent(BLOG_CRAWLER_MODULE_SCREEN_NAME, $request, $blogCrawler));

        return $response
            ->setPreviousUrl(route('blog-crawler.index'))
            ->setNextUrl(route('blog-crawler.edit', $blogCrawler->id))
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
        $blogCrawler = $this->blogCrawlerRepository->findOrFail($id);
        $blogCrawler->categories_id = json_decode($blogCrawler->categories_id, true);
        event(new BeforeEditContentEvent($request, $blogCrawler));

        page_title()->setTitle(trans('plugins/blog-crawler::blog-crawler.edit') . ' "' . $blogCrawler->name . '"');

        return $formBuilder->create(CrawlerCategoryForm::class, ['model' => $blogCrawler])->renderForm();
    }

    /**
     * @param $id
     * @param CrawlerCategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, CrawlerCategoryRequest $request, BaseHttpResponse $response)
    {
        $blogCrawler = $this->blogCrawlerRepository->findOrFail($id);

        $data = $request->all();
        $data['categories_id'] = json_encode($request->categories_id);
        $blogCrawler->fill($data);

        $this->blogCrawlerRepository->createOrUpdate($blogCrawler);

        event(new UpdatedContentEvent(BLOG_CRAWLER_MODULE_SCREEN_NAME, $request, $blogCrawler));

        return $response
            ->setPreviousUrl(route('blog-crawler.index'))
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
            $blogCrawler = $this->blogCrawlerRepository->findOrFail($id);

            $this->blogCrawlerRepository->delete($blogCrawler);

            event(new DeletedContentEvent(BLOG_CRAWLER_MODULE_SCREEN_NAME, $request, $blogCrawler));

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
            $blogCrawler = $this->blogCrawlerRepository->findOrFail($id);
            $this->blogCrawlerRepository->delete($blogCrawler);
            event(new DeletedContentEvent(BLOG_CRAWLER_MODULE_SCREEN_NAME, $request, $blogCrawler));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
