<?php

namespace Modules\Sms77\Listeners;

use App\Events\Menu\AdminCreated;

class AddToAdminMenu {
    /**
     * Handle the event.
     * @param AdminCreated $event
     * @return void
     */
    public function handle(AdminCreated $event) {
        $item = $event->menu->whereTitle(trans_choice('general.sales', 2));
        $item->route('sms77.index',
            trans('sms77::general.bulk_messaging') . ' - sms77', [], 4, ['icon' => '']);
    }
}
