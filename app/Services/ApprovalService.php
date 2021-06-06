<?php


namespace App\Services;


use App\Models\ApprovalHistory;
use App\Models\ApprovalRecord;
use Illuminate\Database\Eloquent\Model;

class ApprovalService
{
    protected int $approval_id;
    protected ?string $description = null;
    protected Model $model;

    /**
     * 构造函数.
     * ApprovalService constructor.
     * @param $approval_id
     * @param $model
     */
    public function __construct($approval_id, $model)
    {
        $this->approval_id = $approval_id;
        $this->model = $model;
    }

    /**
     * 删除流程.
     * @param $approval_id
     */
    public static function approvalDelete($approval_id)
    {
        $approval_record = ApprovalRecord::where('id', $approval_id)->first();
        if (!empty($approval_record)) {
            $approval_record->delete();
        }
    }

    /**
     * 写入审批原因.
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * 流程执行.
     */
    public function go()
    {
        $approval_record = $this->getApprovalRecord();
        $approval_history = ApprovalHistory::where('item', $this->getItem())
            ->where('item_id', $this->model->id)
            ->first();
        $order_id = $approval_record->track()->orderBy('order', 'ASC')->first();
        // 如果没有历史，说明这个审批是个新的
        if (empty($approval_history)) {
            $approval_history = new ApprovalHistory();
            $approval_history->item = $this->getItem();
            $approval_history->item_id = $this->model->id;
            $approval_history->approval_id = $approval_record->id;
            if (empty($order_id)) {
                $order_id = 0;
            }
            $approval_history->order_id = $order_id;
            $approval_history->description = $this->description;
            $approval_history->save();
        } else {
            $new_approval_history = $approval_history->replicate();
            $approval_track = $approval_record->track()->where('order', '>', $approval_history->order_id)
                ->orderBy('order', 'ASC')
                ->first();
            if (!empty($approval_track)) {
                $new_approval_history->order_id = $approval_track->order_id;
                $new_approval_history->description = $this->description;
                $new_approval_history->save();
                $approval_history->delete();
            }
        }
    }

    /**
     * 获取审批.
     * @return ApprovalRecord
     */
    public function getApprovalRecord(): ApprovalRecord
    {
        return ApprovalRecord::find($this->approval_id);
    }

    /**
     * 获取模型类名.
     * @return false|string
     */
    public function getItem(): bool|string
    {
        return get_class($this->model);
    }
}
