<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\RowAction\ApprovalRecordDeleteAction;
use App\Admin\Grid\Displayers\RowActions;
use App\Admin\Repositories\ApprovalRecord;
use App\Aspect\DcatMethodPermission;
use App\Form;
use App\Support\Data;
use App\Traits\ControllerHasTab;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Tools\Selector;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;

/**
 * @property int item_id
 * @property string item
 * @property int status
 */
class ApprovalRecordController extends AdminController
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
        $tab->add(Data::icon('record') . trans('main.approval_record'), $this->renderGrid(), true);
        $tab->addLink(Data::icon('track') . trans('main.approval_track'), admin_route('approval.tracks.index'));
        $tab->addLink(Data::icon('history') . trans('main.approval_history'), admin_route('approval.histories.index'));
        $row->column(12, $tab);
        return $row;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */

    #[DcatMethodPermission('test')]
    protected function grid(): Grid
    {
        return Grid::make(new ApprovalRecord(), function (Grid $grid) {
            $grid->column('id');
            $grid->column('name');
            $grid->column('description');
            $grid->column('created_at');
            $grid->column('updated_at');

            /**
             * 行操作按钮.
             */
            $grid->actions(function (RowActions $actions) {
                // @permissions
                $actions->append(new ApprovalRecordDeleteAction());
            });

            /**
             * 快速搜索
             */
            $grid->quickSearch('id', 'name', 'description')
                ->placeholder(trans('main.quick_search'))
                ->auto(false);

            /**
             * 字段过滤
             */
            $grid->selector(function (Selector $selector) {

            });

            /**
             * 按钮控制.
             */
            $grid->disableBatchActions();
            $grid->disableRowSelector();
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
            $grid->toolsWithOutline(false);

        });
    }

    /**
     * 表单.
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make(new ApprovalRecord(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('description');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
