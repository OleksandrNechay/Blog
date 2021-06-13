<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    const ROOT = 1;
    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description'
    ];
    public function parentCategory(){
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function getParentTitleAttribute(){
        $title = $this->parentCategory->title
            ?? ($this->isRoot()
                ? 'Корінь'
                : '???');

        return $title;
    }

    public function isRoot(){
        return $this->id === Category::ROOT;

    }

}
