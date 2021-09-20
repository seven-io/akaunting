<?php

namespace Modules\Sms77\Listeners;

use App\Events\Module\Installed as Event;
use App\Traits\Permissions;
use Modules\Sms77\Database\Seeds\Sms77DatabaseSeeder;

class FinishInstallation {
    use Permissions;

    public $alias = 'sms77';

    /**
     * Handle the event.
     * @param Event $event
     * @return void
     */
    public function handle(Event $event) {
        if ($event->alias !== $this->alias) return;

        $this->updatePermissions();
    }

    protected function updatePermissions() {
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-main' => 'c,r,u,d',
        ]);
    }
}
