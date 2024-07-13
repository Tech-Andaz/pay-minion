<?php

namespace TechAndaz\PayFast;
class PayFastClient
{
    public $api_url;
    public $merchant_id;
    public $api_password;
    public $currency_code;
    public $merchant_name;
    public $success_url;
    public $cancel_url;
    public $checkout_url;
    public $proccode;
    public $tran_type;
    public $base_url;
    public $verify_url;


    /**
    * PayFastClient constructor.
    * @param array $config.
    */
    public function __construct($config)
    {
        //LIVE = https://ipg1.apps.net.pk/Ecommerce/api/
        //TEST = https://ipguat.apps.net.pk/Ecommerce/api/
        $this->api_url = (isset($config['api_url']) && $config['api_url'] != "") ? $config['api_url'] . "Ecommerce/api/" : "https://ipg1.apps.net.pk/Ecommerce/api/";
        $this->merchant_id = (isset($config['merchant_id']) && $config['merchant_id'] != "") ? $config['merchant_id'] : throw new PayFastException("Merchant ID is missing");
        $this->api_password = (isset($config['api_password']) && $config['api_password'] != "") ? $config['api_password'] : throw new PayFastException("API Password is missing");
        $this->currency_code = (isset($config['currency_code']) && $config['currency_code'] != "") ? $config['currency_code'] : "PKR";
        $this->merchant_name = (isset($config['merchant_name']) && $config['merchant_name'] != "") ? $config['merchant_name'] : "Pay Minion";
        $this->success_url = (isset($config['success_url']) && $config['success_url'] != "") ? $config['success_url'] : "";
        $this->cancel_url = (isset($config['cancel_url']) && $config['cancel_url'] != "") ? $config['cancel_url'] : $this->success_url;
        $this->checkout_url = (isset($config['checkout_url']) && $config['checkout_url'] != "") ? $config['checkout_url'] : $this->success_url;
        $this->proccode = (isset($config['proccode']) && $config['proccode'] != "") ? $config['proccode'] : "00";
        $this->tran_type = (isset($config['tran_type']) && $config['tran_type'] != "") ? $config['tran_type'] : "ECOMM_PURCHASE";


        //API Based Transaction
        //LIVE = https://apipxyuat.apps.net.pk:8443/api/
        //TEST = https://apipxyuat.apps.net.pk:8443/api/
        $this->base_url = $config['api_url'] ==  "https://ipg1.apps.net.pk/Ecommerce/api/" ? "https://apipxyuat.apps.net.pk:8443/api/" : "https://apipxyuat.apps.net.pk:8443/api/";
        $this->verify_url = $config['api_url'] ==  "https://ipg1.apps.net.pk/Ecommerce/api/" ? "https://payfast-portal.apps.net.pk:5557/api/" : "https://payfast-portal.apps.net.pk:5557/api/";
    }

    /**
    * Make a request to the PayFast API.
    * @param string $endpoint   API endpoint.
    * @param string $method     HTTP method (GET, POST, PUT, DELETE).
    * @param array $data        Data to send with the request (for POST, PUT, DELETE).
    * @return array            Decoded response data.
    * @throws PayFastException    If the request or response encounters an error.
    */
    public function makeRequest($endpoint, $method = 'GET', $data = [], $queryParams = []){
        $url = rtrim($this->api_url, "/") . '/' . ltrim($endpoint, '/');
        $headers = ["Content-Type: application/json"];
        $response = $this->sendRequest($url, $method, $headers, $data, $queryParams);
        $responseData = json_decode($response, true);
        return $responseData;
    }

    private function sendRequest($url, $method, $headers, $data, $queryParams = []){
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
            throw new PayFastException('cURL request failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

    public function getAPIToken(){
        $data = array(
            "grant_type" => "client_credentials",
            "secured_key" => $this->api_password,
            "merchant_id" => $this->merchant_id,
        );
        $endpoint = 'token';
        $method = 'POST';
        $url = rtrim($this->base_url, "/") . '/' . ltrim($endpoint, '/');
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $payload = json_decode($response, true);
        if(isset($payload['token']) && $payload['token'] != ""){
            return array(
                "status" => 1,
                "token" => $payload['token']
            );
        } else {
            return array(
                "status" => 0,
                "error" => "Error when issuing token",
                "data" => $payload
            );
        }
    }
    public function makeAPIRequest($endpoint, $method = 'GET', $data = [], $queryParams = []){
        $token = $this->getAPIToken();
        if($token['status'] == 0){
            return $token;
        }
        $url = rtrim($this->base_url, "/") . '/' . ltrim($endpoint, '/');
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token['token']
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            if($method == "POST"){
                curl_setopt($ch, CURLOPT_POST, true);
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        $responseData = json_decode($response, true);
        return $responseData;
    }
    public function makeVerifyRequest($endpoint, $method = 'GET', $data = [], $queryParams = []){
        $url = rtrim($this->verify_url, "/") . '/' . ltrim($endpoint, '/');
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_USERPWD, $this->merchant_id . ":" . $this->api_password);
        if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            if($method == "POST"){
                curl_setopt($ch, CURLOPT_POST, true);
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        $responseData = json_decode($response, true);
        return $responseData;
    }
}
