<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $key, string $value)
 * @method static whereBetween(string $string, array $array)
 * @method static count()
 * @property string item
 * @property int item_id
 * @property int approval_id
 * @property int order_id
 * @property string|null description
 */
class ApprovalHistory extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'approval_histories';

    /**
     * 历史有一个审核.
     *
     * @return HasOne
     */
    public function approval(): HasOne
    {
        return $this->hasOne(ApprovalRecord::class, 'id', 'approval_id');
    }
}
