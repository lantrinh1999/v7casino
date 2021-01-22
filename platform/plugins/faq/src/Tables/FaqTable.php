<?php

namespace Botble\Faq\Tables;

use Auth;
use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Faq\Repositories\Interfaces\FaqInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Botble\Faq\Models\Faq;
use Html;

class FaqTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * FaqTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param FaqInterface $faqRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, FaqInterface $faqRepository)
    {
        $this->repository = $faqRepository;
        $this->setOption('id', 'plugins-faq-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['faq.edit', 'faq.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('title', function ($item) {
                if (!Auth::user()->hasPermission('faq.edit')) {
                    return $item->title;
                }
                return Html::link(route('faq.edit', $item->id), $item->title);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('faq.edit', 'faq.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'faqs.id',
            'faqs.title',
            'faqs.created_at',
            'faqs.status',
        ];

        $query = $model->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'faqs.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'title' => [
                'name'  => 'faqs.title',
                'title' => trans('core/base::tables.title'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'faqs.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'faqs.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('faq.create'), 'faq.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Faq::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('faq.deletes'), 'faq.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'faqs.title' => [
                'title'    => trans('core/base::tables.title'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'faqs.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'faqs.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->getBulkChanges();
    }
}
