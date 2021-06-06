<?php

namespace App\Admin\Repositories;

use App\Models\ApprovalHistory as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ApprovalHistory extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
