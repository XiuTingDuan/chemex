<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ApprovalTrack;
use App\Form;
use App\Models\ApprovalRecord;
use App\Models\Role;
use App\Models\User;
use App\Support\Data;
use App\Support\Support;
use App\Traits\ControllerHasTab;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Tab;

/**
 * @property int item_id
 * @property string item
 * @property int status
 */
class ApprovalTrackController extends AdminController
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
        $tab->add(Data::icon('track') . trans('main.approval_track'), $this->renderGrid(), true);
        $tab->addLink(Data::icon('history') . trans('main.approval_history'), admin_route('approval.histories.index'));
        $row->column(12, $tab);
        return $row;
    }

    /**
     * 列表页.
     * @return Grid
     */
    public function grid(): Grid
    {
        return Grid::make(new ApprovalTrack(['role']), function (Grid $grid) {
            $grid->model()
                ->where('approval_id', request('approval_id'))
                ->orderBy('order', 'ASC');

            $grid->column('id');
            $grid->column('order')->orderable();
            $grid->column('name');
            $grid->column('role.name')->label();
            $grid->column('user.name')->label();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->expand();
                $filter->equal('approval_id')
                    ->select(ApprovalRecord::pluck('name', 'id'));
            });

            $grid->toolsWithOutline(false);
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->enableDialogCreate();
            $grid->showQuickEditButton();
        });
    }

    /**
     * 表单页.
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make(new ApprovalTrack(), function (Form $form) {
            $form->display('id');
            $form->select('approval_id')
                ->options(ApprovalRecord::pluck('name', 'id'))
                ->required();
            $form->text('name')->required();
            $form->radio('type')
                ->options([
                    'department_user_id' => '上级（默认）',
                    'role' => '指定角色',
                    'user' => '用户'
                ])
                ->when('role', function (Form $form) {
                    if (Support::ifSelectCreate()) {
                        $form->selectCreate('role_id')
                            ->options(Role::class)
                            ->ajax(admin_route('selection.organization.roles'))
                            ->url(admin_route('organization.roles.create'));
                    } else {
                        $form->select('role_id')
                            ->options(Role::pluck('name', 'id'));
                    }
                })
                ->when('user', function (Form $form) {
                    if (Support::ifSelectCreate()) {
                        $form->selectCreate('user_id')
                            ->options(User::class)
                            ->ajax(admin_route('selection.organization.users'))
                            ->url(admin_route('organization.users.create'));
                    } else {
                        $form->select('user_id')
                            ->options(User::pluck('name', 'id'));
                    }
                })
                ->default('department_user_id');

            $form->submitted(function (Form $form) {
                $form->deleteInput('type');
            });

            $form->saving(function (Form $form) {
                $approval_track = \App\Models\ApprovalTrack::find($this->id);
                if (!empty($approval_track)) {
                    $approval_track->role_id = null;
                    $approval_track->user_id = null;
                    $approval_track->save();
                }
            });
        });
    }
}
