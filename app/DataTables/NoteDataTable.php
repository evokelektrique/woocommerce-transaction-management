<?php

namespace App\DataTables;

use App\Models\Note;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NoteDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('variation', 'accounts.variation')
            ->editColumn('updated_at', 'notes.updated_at')
            ->rawColumns(['variation', 'updated_at'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Note $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Note $model): QueryBuilder {
        return $model->newQuery()->with(["order", "order.customer"]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId('notes-table')
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
            Column::make("order.wc_order_id")->title("WooCommerce Order ID"),
            Column::make("variation")->title("Order Variation"),
            Column::make("order.customer.email")->title("Customer Email"),
            Column::make("order.customer.phone")->title("Customer Phone"),
            Column::make("order.customer.first_name")->title("Customer First Name"),
            Column::make("order.customer.last_name")->title("Customer Last Name"),
            Column::make("content"),
            Column::make("updated_at"),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string {
        return 'Notes_' . date('YmdHis');
    }
}
