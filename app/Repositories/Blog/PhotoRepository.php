<?php
namespace App\Repositories\Blog;

use App\Models\Photo As Model;

class PhotoRepository extends CoreRepository
{
    protected function getModelClass(){

        return Model::class;
    }
    public function getImg($id)
    {
   $img = $this->StartConditions()
         ->select('photo_path')
        ->where('post_id', $id)
        ->join('posts', 'posts.id', 'photos.id')
        ->first();
    return $img;
    }
}
