<?php

namespace Modules\Seven\Listeners;

use App\Events\Module\Installed as Event;
use App\Traits\Permissions;

class FinishInstallation {
    use Permissions;

    public string $alias = 'seven';

    /**
     * Handle the event.
     */
    public function handle(Event $event): void {
        if ($event->alias !== $this->alias) return;

        $this->updatePermissions();
    }

    protected function updatePermissions(): void {
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-main' => 'c,r,u,d',
        ]);
    }
}
