<?php

namespace Modules\Seven\Traits;

use Exception;
use Sms77\Api\Client;
use Sms77\Api\Exception\InvalidBooleanOptionException;
use Sms77\Api\Exception\InvalidOptionalArgumentException;
use Sms77\Api\Exception\InvalidRequiredArgumentException;
use Sms77\Api\Params\SmsParams;
use Sms77\Api\Params\VoiceParams;

trait Message {
    /**
     * @throws Exception
     */
    private function initClient(string $apiKey): Client {
        return new Client($apiKey, 'Akaunting');
    }

    /**
     * @throws InvalidBooleanOptionException
     * @throws InvalidOptionalArgumentException
     * @throws InvalidRequiredArgumentException
     */
    private function sms(string $apiKey, SmsParams $params): void {
        $this->flashPretty($this->initClient($apiKey)->smsJson($params));
    }

    /**
     * @throws InvalidBooleanOptionException
     * @throws InvalidRequiredArgumentException
     */
    private function voice(string $apiKey, VoiceParams $params): void {
        $this->flashPretty($this->initClient($apiKey)->voiceJson($params));
    }

    private function flashPretty(mixed $json): void {
        flash(json_encode($json, JSON_PRETTY_PRINT));
    }
}
