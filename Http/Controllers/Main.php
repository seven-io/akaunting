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
        $isSMS = 'sms' === $request->input('sms77_msg_type');

        $params = ($isSMS ? (new SmsParams)
            ->setDelay($request->input('sms77_delay'))
            ->setFlash($request->input('sms77_flash'))
            ->setForeignId($request->input('sms77_foreign_id'))
            ->setLabel($request->input('sms77_label'))
            ->setNoReload($request->input('sms77_no_reload'))
            ->setPerformanceTracking($request->input('sms77_performance_tracking'))
            : (new VoiceParams)->setXml($request->input('sms77_xml')))
            ->setDebug($request->input('sms77_debug'))
            ->setFrom($request->input('sms77_from'))
            ->setJson(true)
            ->setText($request->input('sms77_text'))
            ->setTo($this->getContactPhones());

        dump($params);

        $client = new Client($request->input('sms77_api_key'), 'Akaunting');
        $method = $isSMS ? 'smsJson' : 'voiceJson';
        $json = $client->$method($params);

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
