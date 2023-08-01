<?php

namespace Modules\Seven\Listeners;

use App\Events\Menu\AdminCreated;

/** @noinspection PhpUnused */
class AddToAdminMenu {
    /**
     * Handle the event.
     */
    public function handle(AdminCreated $event): void {
        $event->menu->add([
            'icon' => 'sms',
            'order' => 100,
            'route' => ['seven.index', []],
            'title' => trans('seven::general.bulk_messaging'),
        ]);
    }
}
