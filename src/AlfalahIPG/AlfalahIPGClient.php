<?php

namespace TechAndaz\AlfalahIPG;
class AlfalahIPGClient
{
    public $api_version = "77";
    public $environment;
    public $api_url;
    public $checkout_url;
    public $merchant_id;
    public $operator_id;
    public $merchant_name;
    public $password;
    public $api_key;
    public $success_url;
    public $transaction_type;
    public $currency;
    private $api_auth;


    /**
    * AlfalahIPGClient constructor.
    * @param array $config.
    */
    public function __construct($config)
    {
        //LIVE = https://bankalfalah.gateway.mastercard.com/
        //TEST = https://test-bankalfalah.gateway.mastercard.com/
        $this->environment = (isset($config['environment']) && in_array($config['environment'], ['sandbox','production'])) ? $config['environment'] : "production";
        $this->api_url = ($this->environment == 'production') ? "https://bankalfalah.gateway.mastercard.com/" : "https://test-bankalfalah.gateway.mastercard.com/";
        $this->checkout_url = $this->api_url . "static/checkout/checkout.min.js";
        $this->merchant_id = (isset($config['merchant_id']) && $config['merchant_id'] != "") ? $config['merchant_id'] : throw new AlfalahIPGException("Merchant ID is missing");
        $this->operator_id = (isset($config['operator_id']) && $config['operator_id'] != "") ? $config['operator_id'] : "";
        $this->merchant_name = (isset($config['merchant_name']) && $config['merchant_name'] != "") ? $config['merchant_name'] : "Pay Minion";
        $this->password = (isset($config['password']) && $config['password'] != "") ? $config['password'] : throw new AlfalahIPGException("Password is missing");
        $this->api_key = (isset($config['api_key']) && $config['api_key'] != "") ? $config['api_key'] : "";
        $this->success_url = (isset($config['return_url']) && $config['return_url'] != "") ? $config['return_url'] : "";
        $this->transaction_type = (isset($config['transaction_type']) && in_array($config['transaction_type'], ['AUTHORIZE','PURCHASE', 'VERIFY', 'NONE'])) ? $config['transaction_type'] : "PURCHASE";
        $this->currency = (isset($config['currency']) && $config['currency'] != "") ? $config['currency'] : "PKR";
        $this->api_auth = base64_encode("merchant.".$this->merchant_id.":".$this->password);
    }

    /**
    * Make a request to the AlfalahIPG API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws AlfalahIPGException    If the request or response encounters an error.
    */
    public function makeRequest($endpoint, $method = 'GET', $data = [], $queryParams = [])
    {
        $url = rtrim($this->api_url, "/") . '/' . ltrim($endpoint, '/');
        $headers = ["Authorization: Basic " . $this->api_auth, "Content-Type: application/json"];
        $response = $this->sendRequest($url, $method, $headers, $data, $queryParams);
        $responseData = json_decode($response, true);
        return $responseData;
    }

    private function sendRequest($url, $method, $headers, $data, $queryParams = [])
    {
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, 'CURL/PHP Pay Minion');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            if($method == "POST"){
                curl_setopt($ch, CURLOPT_POST, true);
            }
        }
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new AlfalahIPGException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }
}
