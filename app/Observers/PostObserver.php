<?php

namespace App\Observers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PostObserver
{
    /**
     * Handle the blog post "created" event.
     *
     * @param Post $blogPost
     * @return void
     */

    // Обробка ПЕРЕД створенням запису

    public function creating(Post $blogPost)
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->setHtml($blogPost);
       // $this->setUser($blogPost);

    }

    public function updating(Post $blogPost)
    {

        /* $test[] = $blogPost->isDirty();
         $test[] = $blogPost->isDirty('is_published');
         $test[] = $blogPost->isDirty('user_id');
         $test[] = $blogPost->getAttribute('is_published');
         $test[] = $blogPost->is_published;
         $test[] = $blogPost->getOriginal('is_published');
         */

        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);

    }




    public function created(Post $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "updated" event.
     *
     * @param Post $blogPost
     * @return void
     */
    public function updated(Post $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "deleted" event.
     *
     * @param Post $blogPost
     * @return void
     */
    public function deleted(Post $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param Post $blogPost
     * @return void
     */
    public function restored(Post $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param Post $blogPost
     * @return void
     */
    public function forceDeleted(Post $blogPost)
    {
        //
    }


    protected function setPublishedAt(Post $blogPost){

        if(empty($blogPost->published_at) && $blogPost->is_published){
            $blogPost->published_at = Carbon::now();
        }
    }
    protected function setSlug(Post $blogPost){
        if(empty($blogPost->slug)){
            $blogPost->slug = Str::slug($blogPost->title);
        }
    }
    protected function setHtml(Post $blogPost){
        if($blogPost->isDirty('content_raw')){
            $blogPost->content_html = $blogPost->content_raw;
        }
    }
    /*
    protected function setUser(Post $blogPost){
        $blogPost->user_id = auth()->id() ?? Post::UNKNOWN_USER;
    }
*/
}
