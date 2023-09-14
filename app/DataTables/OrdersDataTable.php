<?php

namespace App\DataTables;

use Carbon\Carbon;
use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class OrdersDataTable extends DataTable {
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'orders.action')
            ->addColumn('variation', 'orders.variation')
            ->addColumn('notes', 'orders.support_note')
            ->editColumn('updated_at', 'orders.updated_at')
            ->rawColumns(['action', 'variation', 'notes', 'updated_at'])
            ->setRowId('wc_order_id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model): QueryBuilder {
        $query = $model->newQuery()->with(["notes", "customer"]);

        if (isset($this->attributes['datepicker'])) {
            $query->whereBetween('created_at', [
                Carbon::createFromFormat('Y-m-d', $this->attributes['datepicker'][0]),
                Carbon::createFromFormat('Y-m-d', $this->attributes['datepicker'][1])
            ]);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId('orders-table')
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
            ])
            ->ajaxWithForm('', '#form-orders-table');
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array {
        return [
            Column::make('wc_order_id')->title("WooCoomerce Order ID"),
            Column::make("variation"),
            Column::make("price"),
            Column::make("status"),
            Column::make("customer.first_name")->title("First name"),
            Column::make("customer.last_name")->title("Last name"),
            Column::computed('notes'),
            Column::make('updated_at'),
            Column::computed('action')->printable(false)->exportable(false)->searchPanes(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string {
        return 'Orders_' . date('YmdHis');
    }
}
