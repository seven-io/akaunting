<?php

namespace Modules\Seven\Listeners;

use App\Events\Auth\LandingPageShowing as Event;

class AddLandingPage {
    /**
     * Handle the event.
     */
    public function handle(Event $event): void {
        $event->user->landing_pages['seven.settings.edit'] = trans('seven::general.name');
    }
}
