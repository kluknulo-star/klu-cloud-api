<?php

namespace App\Common\Presenters;

use Illuminate\Database\Eloquent\Model;
use App\Common\ResourceModels\ShortResource;

class ShortPresenter
{
    public function present(Model $model): ?ShortResource
    {
        return new ShortResource($model->id, $model->name);
    }
}
