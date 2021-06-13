<?php
namespace App\Repositories\Blog;

use App\Models\Post As Model;


class PostRepository extends CoreRepository
{

    protected function getModelClass(){

        return Model::class;
    }

    public function getAllWithPaginate()
    {
        $fields = ['id', 'title', 'slug', 'is_published', 'published_at', 'user_id', 'category_id'];

        $result = $this->StartConditions()
            ->select($fields)
            ->orderBy('id', 'DESC')
            //->with(['category', 'user'])
            ->with(['category' => function($query){
                $query->select(['id', 'title']);
            },
                'user:id,name'
            ])

            ->paginate(25);

        return $result;

    }
    public function getEdit($id){

        return $this->StartConditions()->find($id);
    }

}
