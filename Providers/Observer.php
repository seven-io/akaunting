<?php

namespace Modules\Seven\Providers;

use App\Models\Document\Document;
use Illuminate\Support\ServiceProvider as Provider;

class Observer extends Provider {
    /**
     * Boot the application events.
     * @return void
     */
    public function boot() {
        Document::observe(\Modules\Seven\Observers\Document::class);
    }
}
