<?php

namespace TechAndaz\JazzCash;
class JazzCashClient
{
    public $environment;
    public $currency;
    public $return_url;
    public $api_url;
    public $merchant_id;
    public $password;
    public $integerity_salt;
    public $hash_request;
    public $domain_code;

    /**
    * JazzCashClient constructor.
    * @param array $config.
    */
    public function __construct($config)
    {
        //LIVE = https://payments.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/
        //TEST = https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/
        $this->environment = (isset($config['environment']) && in_array($config['environment'], ['sandbox','production'])) ? $config['environment'] : "production";
        $this->api_url = ($this->environment == 'production') ? "https://payments.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/" : "https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/";
        $this->currency = (isset($config['currency']) && $config['currency'] != "") ? $config['currency'] : "PKR";
        $this->merchant_id = (isset($config['merchant_id']) && $config['merchant_id'] != "") ? $config['merchant_id'] : throw new JazzCashException("Merchant ID is missing");
        $this->password = (isset($config['password']) && $config['password'] != "") ? $config['password'] : throw new JazzCashException("Password is missing");
        $this->integerity_salt = (isset($config['integerity_salt']) && $config['integerity_salt'] != "") ? $config['integerity_salt'] : throw new JazzCashException("Integerity Salt is missing");
        $this->return_url = (isset($config['return_url']) && $config['return_url'] != "") ? $config['return_url'] : throw new JazzCashException("Return URL is missing");
        $this->domain_code = (isset($config['domain_code']) && $config['domain_code'] != "") ? $config['domain_code'] : throw new JazzCashException("Domain Code is missing");
        if(strlen($this->domain_code) > 3){
            throw new JazzCashException("Domain Code can not be more than 3 character long");
        }
    }

    /**
    * Make a request to the JazzCash API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws JazzCashException    If the request or response encounters an error.
    */
    public function makeRequest($endpoint, $method = 'GET', $data = [], $queryParams = [])
    {
        $url = rtrim($this->api_url, "/") . '/' . ltrim($endpoint, '/');
        $headers = ["Content-Type: application/json"];
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
            throw new JazzCashException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }
}
