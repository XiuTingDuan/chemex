<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $key, string $value)
 * @method static whereBetween(string $string, array $array)
 * @method static count()
 */
class ApprovalHistory extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'approval_histories';
}
