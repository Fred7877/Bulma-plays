<?php

namespace App\DataTables;

use App\Enums\Moderation;
use App\Models\CustomGame;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CustomGameDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'backend.custom-game.buttons-action')
            ->editColumn('moderated', function ($item) {

                if (optional($item->moderations->last())->status === null) {
                    return '<span class="badge badge-primary">&nbsp; - &nbsp;</span>';
                } else {
                    if ((int)$item->moderations->last()->status === Moderation::ModerationNOk) {

                        return '<span class="badge badge-danger">' . Moderation::getDescription((int)$item->moderations->last()->status) . '</span>';
                    }
                    return '<span class="badge badge-success">' . Moderation::getDescription((int)$item->moderations->last()->status) . '</span>';
                }
            })
            ->escapeColumns([])
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CustomGame $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CustomGame $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('custom_game-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('user_id'),
            Column::make('moderated')->title('Status moderation'),
            Column::make('action', 'custom-game.id'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'CustomGame_' . date('YmdHis');
    }
}
