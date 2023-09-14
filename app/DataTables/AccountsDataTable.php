<?php

namespace App\DataTables;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AccountsDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('variation', 'accounts.variation')
            ->editColumn('updated_at', 'accounts.updated_at')
            ->editColumn('expire_at', function(Account $account) {
                return $account->expire_at->format('Y-m-d H:i:s');
            })
            ->editColumn('date', function(Account $account) {
                return $account->date->format('Y-m-d H:i:s');
            })
            ->editColumn('guarantee', 'accounts.guarantee')
            ->rawColumns(['variation', 'updated_at', 'guarantee'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Account $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Account $model): QueryBuilder {
        return $model->newQuery()->with(["order", "order.customer"]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId('accounts-table')
            ->pageLength(50)
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ])
            ->parameters([
                'initComplete' => 'function() { initalize_datatable(this); }',
                'drawCallback' => 'function() { draw_popovers(); }',
                'order' => [
                    0, 'desc'
                ],
                'responsive' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array {
        return [
            Column::make("id"),
            Column::make("title"),
            Column::make("email"),
            Column::make("username"),
            Column::make("password"),
            Column::make("code"),
            Column::make("guarantee"),
            Column::make("variation")->title("Order Variation"),
            Column::make("order.wc_order_id")->title("WooCommerce Order ID"),
            Column::make("order.customer.email")->title("Customer Email"),
            Column::make("order.customer.phone")->title("Customer Phone"),
            Column::make("date")->title("Date created at WooCommerce"),
            Column::make("expire_at"),
            Column::make("updated_at"),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string {
        return 'Accounts_' . date('YmdHis');
    }
}
