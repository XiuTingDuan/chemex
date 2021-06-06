<?php

namespace App\Admin\Repositories;

use App\Models\ApprovalRecord as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ApprovalRecord extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
