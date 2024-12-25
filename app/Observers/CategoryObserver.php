<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function creating(Category $category): void
    {
        $category->slug = $this->generateUniqueSlug($category->title);
    }

    /**
     * Handle the Post "updating" event.
     */
    public function updating(Category $category): void
    {
        $category->slug = $this->generateUniqueSlug($category->title);
    }

    /**
     * Generate a unique slug for a post title.
     */
    private function generateUniqueSlug($title, $count = 0): string
    {
        $slug = Str::slug($title);

        if ($count > 0) {
            $slug .= "-ID$count";
        }

        if (Category::where('slug', $slug)->exists()) {
            return $this->generateUniqueSlug($title, $count + 1);
        }

        return $slug;
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
