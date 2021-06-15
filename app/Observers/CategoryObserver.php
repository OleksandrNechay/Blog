<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    /**
     * Handle the blog category "created" event.
     *
     * @param Category $blogCategory
     * @return void
     */
    public function created(Category $blogCategory)
    {
        //
    }

    public function creating(Category $blogCategory)
    {
        $this->setSlug($blogCategory);
    }

    /**
     * Handle the blog category "updated" event.
     *
     * @param Category $blogCategory
     * @return void
     */
    public function updated(Category $blogCategory)
    {

    }

    public function updating(Category $blogCategory)
    {
        $this->setSlug($blogCategory);
    }
    protected function setSlug(Category $blogCategory){
        if(empty($blogCategory->slug)){
            $blogCategory->slug = Str::slug($blogCategory->title);
        }
    }

    /**
     * Handle the blog category "deleted" event.
     *
     * @param Category $blogCategory
     * @return void
     */
    public function deleted(Category $blogCategory)
    {
        //
    }

    /**
     * Handle the blog category "restored" event.
     *
     * @param Category $blogCategory
     * @return void
     */
    public function restored(Category $blogCategory)
    {
        //
    }

    /**
     * Handle the blog category "force deleted" event.
     *
     * @param Category $blogCategory
     * @return void
     */
    public function forceDeleted(Category $blogCategory)
    {
        //
    }
}
