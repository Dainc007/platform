<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use SMSApi\Api\SmsFactory;
use SMSApi\Client;
use SMSApi\Exception\SmsapiException;

class SmsService
{
    /**
     * https://github.com/smsapi/smsapi-php-client/tree/v1.8.7
     * Create a new class instance.
     */

    public Client $client;
    protected SmsFactory $factory;
    public function __construct()
    {
        $this->client = Client::createFromToken(config('smsapi.auth.credentials.token'));
        $this->factory = (new SmsFactory())->setClient($this->client);
    }

    public function sendSMS(string $to, string $message, string $sender = 'PRACA ŻURAW'): void
    {
        try {
            $actionSend = $this->factory->actionSend();
            $actionSend->setTo($to);
            $actionSend->setText($message);
            $actionSend->setSender($sender);
            $actionSend->execute();

        } catch (SmsapiException $exception) {
            Log::error($exception->getMessage());
        }
    }
}
