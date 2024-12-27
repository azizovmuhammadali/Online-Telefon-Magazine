<?php

namespace App\Observers;

use App\Models\Phone;
use Illuminate\Support\Str;

class PhoneObserver
{
    /**
     * Handle the Phone "created" event.
     */
    public function creating(Phone $phone): void
    {
        $phone->slug = $this->generateUniqueSlug($phone->name);
    }

    /**
     * Handle the Post "updating" event.
     */
    public function updating(Phone $phone): void
    {
        $phone->slug = $this->generateUniqueSlug($phone->name);
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

        if (Phone::where('slug', $slug)->exists()) {
            return $this->generateUniqueSlug($title, $count + 1);
        }

        return $slug;
    }

    /**
     * Handle the Phone "deleted" event.
     */
    public function deleted(Phone $phone): void
    {
        //
    }

    /**
     * Handle the Phone "restored" event.
     */
    public function restored(Phone $phone): void
    {
        //
    }

    /**
     * Handle the Phone "force deleted" event.
     */
    public function forceDeleted(Phone $phone): void
    {
        //
    }
}
