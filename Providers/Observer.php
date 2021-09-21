<?php

namespace Modules\Sms77\Providers;

use App\Models\Document\Document;
use Illuminate\Support\ServiceProvider as Provider;

class Observer extends Provider {
    /**
     * Boot the application events.
     * @return void
     */
    public function boot() {
        Document::observe(\Modules\Sms77\Observers\Document::class);
    }
}
