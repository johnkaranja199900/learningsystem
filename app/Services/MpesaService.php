<?php

namespace App\Services;

use GuzzleHttp\Client;

class MpesaService
{
    protected $client;
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortCode;
    protected $passKey;
    protected $callbackUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->shortCode = config('services.mpesa.shortcode');
        $this->passKey = config('services.mpesa.passkey');
        $this->callbackUrl = config('services.mpesa.callback_url');
    }

    public function getToken()
    {
        $credentials = base64_encode("{$this->consumerKey}:{$this->consumerSecret}");
        $response = $this->client->request('GET', 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ],
            'verify' => false,
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        return $body['access_token'] ?? null;
    }

   public function makePaymentRequest($amount, $phoneNumber, $accountReference, $transactionDesc)
{
    $token = $this->getToken();

    if (!$token) {
        return ['error' => 'Failed to retrieve access token'];
    }

    $timestamp = date('YmdHis');
    $password = base64_encode($this->shortCode . $this->passKey . $timestamp);

    try {
        $response = $this->client->request('POST', 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'BusinessShortCode' => $this->shortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int)$amount,
                'PartyA' =>preg_replace('/^\+/', '', $phoneNumber),
                'PartyB' =>$this->shortCode,
                'PhoneNumber' => preg_replace('/^\+/', '', $phoneNumber),
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => $accountReference,
                'TransactionDesc' => $transactionDesc,
            ],
            'verify' => false,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    } catch (ClientException $e) {
        if ($e->hasResponse()) {
            $response = $e->getResponse();
            $errorBody = json_decode($response->getBody()->getContents(), true);
            // Log or handle the error response
            return $errorBody;
        }
        // Handle other errors or rethrow for general exception handling
        throw $e;
    } catch (\Exception $e) {
        // Handle general exceptions
        return ['error' => $e->getMessage()];
    }
}


}
