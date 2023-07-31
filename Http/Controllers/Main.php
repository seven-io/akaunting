<?php

namespace Modules\Seven\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Models\Common\Contact;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Modules\Seven\Traits\Message;
use Modules\Seven\Traits\Settings;
use Sms77\Api\Params\SmsParams;
use Sms77\Api\Params\VoiceParams;

class Main extends Controller {
    use Message, Settings;

    /**
     * Submit bulk messaging.
     * @throws Exception
     */
    public function submit(Request $request): Response|Redirector|RedirectResponse|Application {
        $type = $request->input('seven_msg_type');
        $isSMS = 'sms' === $type;
        $phones = $this->getContactPhones(
            (bool)$request->input('seven_filter_contact_disabled'),
            $request->input('seven_filter_contact_type'),
        );
        $apiKey = $request->input('seven_api_key');
        $params = [];
        $baseParams = ($isSMS ? (new SmsParams)
            ->setDelay($request->input('seven_delay'))
            ->setFlash($request->input('seven_flash'))
            ->setForeignId($request->input('seven_foreign_id'))
            ->setLabel($request->input('seven_label'))
            ->setNoReload($request->input('seven_no_reload'))
            ->setPerformanceTracking($request->input('seven_performance_tracking'))
            : (new VoiceParams)->setXml($request->input('seven_xml')))
            ->setDebug($request->input('seven_debug'))
            ->setFrom($request->input('seven_from'))
            ->setJson(true)
            ->setText($request->input('seven_text'));

        $pushParams = static function (string $to) use ($baseParams, &$params) {
            $params[] = clone $baseParams->setTo($to);
        };

        if ($isSMS) $pushParams($phones);
        else foreach (explode(',', $phones) as $phone) $pushParams($phone);

        foreach ($params as $param) $this->$type($apiKey, $param);

        return $this->index();
    }

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
     */
    public function index(): Response|Redirector|Application|RedirectResponse {
        if (empty($this->getSettings())) {
            flash(trans('seven::general.api_key_missing'));
            return redirect($this->getSettingsRoute());
        }

        return $this->response('seven::index', [
            'contactTypes' => Contact::query()
                ->select('type')->distinct()->get()->pluck('type')->toArray(),
            'settings' => $this->getSettings(),
        ]);
    }
}
