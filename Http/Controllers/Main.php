<?php

namespace Modules\Sms77\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Models\Common\Contact;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Modules\Sms77\Traits\Message;
use Modules\Sms77\Traits\Settings;
use Sms77\Api\Params\SmsParams;
use Sms77\Api\Params\VoiceParams;

class Main extends Controller {
    use Message, Settings;

    /**
     * Submit bulk messaging.
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function submit(Request $request) {
        $type = $request->input('sms77_msg_type');
        $isSMS = 'sms' === $type;
        $phones = $this->getContactPhones(
            (bool)$request->input('sms77_filter_contact_disabled'),
            $request->input('sms77_filter_contact_type'),
        );
        $apiKey = $request->input('sms77_api_key');
        $params = [];
        $baseParams = ($isSMS ? (new SmsParams)
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
            ->setText($request->input('sms77_text'));

        $pushParams = static function (string $to) use ($baseParams, &$params) {
            $params[] = clone $baseParams->setTo($to);
        };

        if ($isSMS) $pushParams($phones);
        else foreach (explode(',', $phones) as $phone) $pushParams($phone);

        foreach ($params as $param) $this->$type($apiKey, $param);

        return $this->index();
    }

    /**
     * @param bool $disabled
     * @param string|null $type
     * @return string
     */
    private function getContactPhones(bool $disabled, ?string $type): string {
        $query = Contact::query()
            ->select(['phone'])
            ->whereNotNull(['company_id', 'phone']);

        if (!$disabled) $query->where('enabled', '=', 1);
        if ($type) $query->where('type', '=', $type);

        return implode(',', $query->pluck('phone')->toArray());
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
            'contactTypes' => Contact::query()
                ->select('type')->distinct()->get()->pluck('type')->toArray(),
            'settings' => $this->getSettings(),
        ]);
    }
}
