<?php

namespace Modules\Sms77\Observers;

use App\Abstracts\Observer;
use App\Models\Document\Document as Model;
use Modules\Sms77\Traits\Message;
use Modules\Sms77\Traits\Settings;
use Sms77\Api\Exception\InvalidBooleanOptionException;
use Sms77\Api\Exception\InvalidOptionalArgumentException;
use Sms77\Api\Exception\InvalidRequiredArgumentException;
use Sms77\Api\Params\SmsParams;

class Document extends Observer {
    use Message, Settings;

    /**
     * Listen to the created event.
     * @param Model $document
     * @return void
     * @throws InvalidBooleanOptionException
     * @throws InvalidOptionalArgumentException
     * @throws InvalidRequiredArgumentException
     */
    public function created(Model $document): void {
        if (Model::INVOICE_TYPE !== $document->type) return;

        $apiKey = $this->getApiKey();
        if (!$apiKey) return;

        $text = $this->getOnInvoiceCreationText();
        if (!$text) return;

        $params = (new SmsParams())
            ->setFrom($this->getCompanyName())
            ->setJson(true)
            ->setText($text)
            ->setTo($document->contact_phone);

        $this->sms($apiKey, $params);
    }
}
