<?php
namespace App\Repositories\Blog;

use App\Models\Photo As Model;
use Illuminate\Database\Eloquent\Collection;

class PhotoRepository extends CoreRepository
{
    protected function getModelClass(){

        return Model::class;
    }


}
