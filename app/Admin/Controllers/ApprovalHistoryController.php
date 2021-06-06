<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\RowAction\ApprovalHistoryUpdateAction;
use App\Admin\Grid\Displayers\RowActions;
use App\Admin\Repositories\ApprovalHistory;
use App\Models\ApprovalTrack;
use App\Support\Data;
use App\Traits\ControllerHasTab;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;

/**
 * @property int item_id
 * @property string item
 * @property int status
 * @property int approval_id
 */
class ApprovalHistoryController extends AdminController
{
    use ControllerHasTab;

    /**
     * 标签布局.
     * @return Row
     */
    public function tab(): Row
    {
        $row = new Row();
        $tab = new Tab();
        $tab->addLink(Data::icon('record') . trans('main.approval_record'), admin_route('approval.records.index'));
        $tab->addLink(Data::icon('track') . trans('main.approval_track'), admin_route('approval.tracks.index'));
        $tab->add(Data::icon('history') . trans('main.approval_history'), $this->renderGrid(), true);
        $row->column(12, $tab);
        return $row;
    }

    /**
     * 列表页.
     * @return Grid
     */
    public function grid(): Grid
    {
        return Grid::make(new ApprovalHistory(['approval']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('approval.name');
            $grid->column('order_id')->display(function ($order_id) {
                return ApprovalTrack::where('approval_id', $this->approval_id)
                    ->where('order', $order_id)
                    ->value('name');
            });
            $grid->column('item')->using(Data::itemNameByModel());
            $grid->column('item_id');
            $grid->column('description');

            /**
             * 行操作按钮.
             */
            $grid->actions(function (RowActions $actions) {
                // @permissions
                $actions->append(new ApprovalHistoryUpdateAction());
            });

            $grid->toolsWithOutline(false);
            $grid->disableViewButton();
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
        });
    }
}
