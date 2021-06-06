<?php

namespace App\Admin\Repositories;

use App\Models\ApprovalTrack as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ApprovalTrack extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function toTree()
    {
        $return = [];
        $approval_tracks = \App\Models\ApprovalTrack::where('approval_id', 1)
            ->orderBy('order', 'ASC')
            ->get()
            ->toArray();
        foreach ($approval_tracks as $approval_track) {
            $model = new $this->model();
            $model->title = $approval_track['id'];
            array_push($return, $model);
        }
        return $return;
    }
}
