<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'photos_name',
        'photo_path',
        'photo_url'];

    public function Post(){
        return $this->hasOne(Post::class);
    }

    protected $table = 'photos.photos';
}
