<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;

/**
 * @method static where(string $key, string $value)
 * @method static whereBetween(string $string, array $array)
 * @method static count()
 */
class ApprovalTrack extends Model implements Sortable
{
    use HasDateTimeFormatter;
    use SoftDeletes;
    use ModelTree;

    protected $table = 'approval_tracks';

    /**
     * 流程属于一个审核.
     *
     * @return BelongsTo
     */
    public function approval(): BelongsTo
    {
        return $this->belongsTo(ApprovalRecord::class, 'approval_id', 'id');
    }

    /**
     * 流程有一个角色.
     *
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    /**
     * 流程有一个用户.
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
