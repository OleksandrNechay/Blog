<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    //const UNKNOWN_USER = 1;

    protected $fillable = [
        'title',
        'user_id',
        'slug',
        'category_id',
        'excerpt',
        'content_raw',
        'is_published',
        'published_at',
    ];
    /**
     * @var mixed
     */

    public function Category(){
        return $this->belongsTo(Category::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Photos(){
        return $this->belongsTo(Photo::class);
    }

    protected $dates = [
        'published_at'

    ];

    public function scopeLastPosts($query, $count){

        $posts = $query->orderBy('created_at','DESC')->take($count)->get();
        return $posts;
    }

}
