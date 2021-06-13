<?php

namespace App\Repositories\Blog;

use Illuminate\Database\Eloquent\Model;

abstract class CoreRepository
{
    protected $model;

    public function __construct(){

        $this->model = app($this->getModelClass());
    }

    abstract protected function getModelClass();


    protected function StartConditions(){

        return clone $this->model;
    }

}
