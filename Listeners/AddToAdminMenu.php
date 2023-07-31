<?php

namespace Modules\Seven\Listeners;

use App\Events\Menu\AdminCreated;

class AddToAdminMenu {
    /**
     * Handle the event.
     */
    public function handle(AdminCreated $event): void {
        $item = $event->menu->whereTitle(trans_choice('general.sales', 2));
        $item->route('seven.index',
            trans('seven::general.bulk_messaging') . ' - seven', [], 4, ['icon' => '']);
    }
}
