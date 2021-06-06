<?php

namespace App\Admin\Actions\Tree\ToolAction;

use App\Admin\Forms\ApprovalRecordCreateTrackForm;
use Dcat\Admin\Tree\AbstractTool;
use Dcat\Admin\Widgets\Modal;

class ApprovalRecordCreateTrackAction extends AbstractTool
{
    protected int $id;

    public function __construct($id)
    {
        parent::__construct();
        $this->title = admin_trans_label('Track Create');
        $this->id = $id;
    }

    /**
     * 渲染模态框.
     *
     * @return Modal
     */
    public function render(): Modal
    {
        $form = ApprovalRecordCreateTrackForm::make()->payload(['id' => $this->id]);
        return Modal::make()
            ->lg()
            ->body($form)
            ->button("<a class='btn btn-sm btn-success' style='color: white;'><i class='feather icon-package'></i>&nbsp;$this->title</a>");
    }
}
