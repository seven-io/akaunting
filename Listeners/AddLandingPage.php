<?php

namespace Modules\Sms77\Listeners;

use App\Events\Auth\LandingPageShowing as Event;

class AddLandingPage {
    /**
     * Handle the event.
     * @param Event $event
     * @return void
     */
    public function handle(Event $event) {
        $event->user->landing_pages['sms77.settings.edit'] = trans('sms77::general.name');
    }
}
