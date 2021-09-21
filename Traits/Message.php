<?php

namespace Modules\Sms77\Traits;

use Exception;
use Sms77\Api\Client;
use Sms77\Api\Exception\InvalidBooleanOptionException;
use Sms77\Api\Exception\InvalidOptionalArgumentException;
use Sms77\Api\Exception\InvalidRequiredArgumentException;
use Sms77\Api\Params\SmsParams;
use Sms77\Api\Params\VoiceParams;

trait Message {
    /**
     * @param string $apiKey
     * @return Client
     * @throws Exception
     */
    private function initClient(string $apiKey): Client {
        return new Client($apiKey, 'Akaunting');
    }

    /**
     * @param Client $client
     * @param SmsParams $params
     * @return void
     * @throws InvalidBooleanOptionException
     * @throws InvalidOptionalArgumentException
     * @throws InvalidRequiredArgumentException
     */
    private function sms(string $apiKey, SmsParams $params): void {
        $this->flashPretty($this->initClient($apiKey)->smsJson($params));
    }

    /**
     * @param string $apiKey
     * @param VoiceParams $params
     * @return void
     * @throws InvalidBooleanOptionException
     * @throws InvalidRequiredArgumentException
     */
    private function voice(string $apiKey, VoiceParams $params): void {
        $this->flashPretty($this->initClient($apiKey)->voiceJson($params));
    }

    private function flashPretty($json) {
        flash(json_encode($json, JSON_PRETTY_PRINT));
    }
}
