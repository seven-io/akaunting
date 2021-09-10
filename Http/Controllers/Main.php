<?php

namespace Modules\Sms77\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Models\Common\Contact;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Plank\Mediable\MediableCollection;
use Sms77\Api\Client;
use Sms77\Api\Params\SmsParams;
use Sms77\Api\Params\VoiceParams;

class Main extends Controller {
    /**
     * Submit bulk messaging.
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function submit(Request $request) {
        $apiKey = $request->input('sms77_api_key');
        $from = $request->input('sms77_from');
        $text = $request->input('sms77_text');
        $type = $request->input('sms77_msg_type');
        $isSMS = 'sms' === $type;
        $method = $isSMS ? 'smsJson' : 'voiceJson';
        $to = $this->getContactPhones();

        $params = $isSMS ? new SmsParams : new VoiceParams;
        $params->setFrom($from)->setJson(true)->setText($text)->setTo($to);

        $json = (new Client($apiKey, 'Akaunting'))->$method($params);

        flash($json);

        return $this->index();
    }

    /**
     * @param array|null $contacts
     * @return string
     */
    private function getContactPhones(array $contacts = null): string {
        $phones = [];
        foreach ($contacts ?: $this->getContacts() as $contact) {
            /** @var Contact $contact */
            $phones[] = $contact->getAttribute('phone');
        }
        return implode(',', $phones);
    }

    /**
     * @param array|string[] $select
     * @return Contact[]|Builder[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|MediableCollection
     */
    private function getContacts(array $select = ['*']) {
        return Contact::query()
            ->select($select)
            ->whereNotNull(['company_id', 'phone'])
            ->get();
    }

    /**
     * Display bulk messaging.
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function index() {
        if (empty($this->getSettings())) {
            flash(trans('sms77::general.api_key_missing'));
            return redirect($this->getSettingsRoute());
        }

        return $this->response('sms77::index', [
            'settings' => $this->getSettings(),
        ]);
    }

    private function getSettings(): array {
        $settings = setting($this->getModuleAlias());
        return $settings ?: [];

    }

    private function getModuleAlias(): string {
        return $this->getModule()->alias;
    }

    private function getModule() {
        return module('sms77');
    }

    private function getSettingsRoute(): string {
        return route('settings.module.edit', ['alias' => $this->getModuleAlias()]);
    }
}
