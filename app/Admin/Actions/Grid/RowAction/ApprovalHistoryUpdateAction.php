<?php

namespace App\Admin\Actions\Grid\RowAction;

use App\Admin\Forms\ApprovalHistoryUpdateForm;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Widgets\Modal;

class ApprovalHistoryUpdateAction extends RowAction
{
    public function __construct()
    {
        parent::__construct();
        $this->title = admin_trans_label('Update');
    }

    /**
     * 渲染模态框.
     *
     * @return Modal|string
     */
    public function render()
    {
        $form = ApprovalHistoryUpdateForm::make()->payload([
            'id' => $this->getKey(),
            'approval_id' => $this->getRow()->approval_id,
            'item' => $this->getRow()->item
        ]);

        return Modal::make()
            ->lg()
            ->title(admin_trans_label('Update'))
            ->body($form)
            ->button($this->title);
    }
}
