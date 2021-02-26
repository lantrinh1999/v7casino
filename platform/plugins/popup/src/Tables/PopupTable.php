<?php

namespace Botble\Popup\Tables;

use Auth;
use BaseHelper;
use Botble\Popup\Models\Popup;
use Botble\Popup\Repositories\Interfaces\PopupInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;

class PopupTable extends TableAbstract
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
     * PopupTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param PopupInterface $popupRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, PopupInterface $popupRepository)
    {
        $this->repository = $popupRepository;
        $this->setOption('id', 'plugins-popup-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['popup.edit', 'popup.destroy'])) {
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
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('popup.edit', '', $item);
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
            'popups.id',
            'popups.name',
            'popups.phone',
            'popups.email',

            'popups.created_at',
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
                'name' => 'popups.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name' => 'popups.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'phone' => [
                'name' => 'popups.phone',
                'title' => "SĐT",
                'class' => 'text-left',
            ],
            'email' => [
                'name' => 'popups.email',
                'title' => "Email",
                'class' => 'text-left',
            ],
            'created_at' => [
                'name' => 'popups.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],

        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return [];
        return $this->addDeleteAction(route('popup.deletes'), '', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [];
        return [
            'popups.name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'popups.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'date',
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
