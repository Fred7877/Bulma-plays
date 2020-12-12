<?php

namespace App\DataTables;

use App\Enums\Moderation;
use App\Models\Comment;
use App\Models\Game;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CommentsDataTable extends DataTable
{
    /**
     * @return \Yajra\DataTables\DataTableAbstract|\Yajra\DataTables\EloquentDataTable
     */
    public function dataTable()
    {
        $model = Comment::with(['user', 'moderations'])->whereNull('parent_comment_id')->orderBy('id', 'desc');

        return datatables()
            ->eloquent($model)
            ->addColumn('action', 'backend.comment.buttons-action')
            ->addColumn('type', 'backend.comment.type-comments')
            ->addColumn('nb_replies', function ($item) {
                return Comment::where('parent_comment_id', $item->id)->count();
            })
            ->addColumn('language', 'backend.comment.language-comments')
            ->addColumn('game_title', function ($item) {
                $game = Game::where('game_id', $item->game_id)->first();

                return optional($game)->igdb['name'] ?? '-';
            })
            ->addColumn('created_at', function ($item) {
                return Carbon::createFromTimeString($item->created_at)->format('d/m/Y H:i');
            })
            ->editColumn('moderated', function ($item) {
                if ($item->moderations->first() === null) {
                    return '<span class="badge badge-primary">&nbsp; - &nbsp;</span>';
                } else {

                    if ($item->moderations->last()->status === Moderation::ModerationNOk) {

                        return '<span class="badge badge-danger">' . Moderation::getDescription($item->moderations->last()->status) . '</span>';
                    }

                    return '<span class="badge badge-success">' . Moderation::getDescription($item->moderations->last()->status) . '</span>';
                }
            })
            ->escapeColumns([])
            ->addColumn('author', function ($item) {

                return $item->user->name;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Comment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Comment $model)
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
            ->setTableId('comments-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('id')
                ->width(30)
                ->addClass('text-center'),
            Column::make('author')->addClass('text-center'),
            Column::make('game_title')->addClass('text-center'),
            Column::make('type')->addClass('text-center'),
            Column::make('nb_replies')->addClass('text-center')->searchable(false),
            Column::make('language')->addClass('text-center'),
            Column::make('moderated')->title('Status moderation')->addClass('text-center'),
            Column::make('created_at'),
            Column::make('action', 'comment.id'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Comments_' . date('YmdHis');
    }
}
