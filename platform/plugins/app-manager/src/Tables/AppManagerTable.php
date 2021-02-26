<?php

namespace Botble\AppManager\Tables;

use Auth;
use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\AppManager\Repositories\Interfaces\AppManagerInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Botble\AppManager\Models\AppManager;
use Html;

class AppManagerTable extends TableAbstract
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
     * AppManagerTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param AppManagerInterface $appManagerRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, AppManagerInterface $appManagerRepository)
    {
        $this->repository = $appManagerRepository;
        $this->setOption('id', 'plugins-app-manager-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['app-manager.edit', 'app-manager.destroy'])) {
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
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('app-manager.edit')) {
                    return $item->name;
                }
                return 'API: ' . Html::link(route('get_app', $item->slug), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('urlLogin', function ($item) {
                return Html::link($item->urlLogin, $item->urlLogin);
            })
            ->editColumn('urlRegister', function ($item) {
                return Html::link($item->urlRegister, $item->urlRegister);
            })
            ->editColumn('mode', function ($item) {
                return !empty($item->mode) ? 'TRUE' : 'FALSE';
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('app-manager.edit', 'app-manager.destroy', $item);
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
            'app_managers.id',
            'app_managers.name',
            'app_managers.urlLogin',
            'app_managers.urlRegister',
            'app_managers.mode',
            'app_managers.created_at',
            'app_managers.status',
            'app_managers.slug',
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
                'name'  => 'app_managers.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'app_managers.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
                'width' => '100px',
            ],
            'urlLogin' => [
                'name'  => 'app_managers.urlLogin',
                'title' => 'URL LOGIN',
                'class' => 'text-left',
            ],
            'urlRegister' => [
                'name'  => 'app_managers.urlRegister',
                'title' => 'URL REGISTER',
                'class' => 'text-left',
            ],
            'mode' => [
                'name'  => 'app_managers.mode',
                'title' => 'MODE',
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'app_managers.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'app_managers.status',
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
        $buttons = $this->addCreateButton(route('app-manager.create'), 'app-manager.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, AppManager::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('app-manager.deletes'), 'app-manager.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'app_managers.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'app_managers.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'app_managers.created_at' => [
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
