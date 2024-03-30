<?php

namespace TechAndaz\SafePayEmbedded;
use Safepay\SafepayClient;
class SafePayEmbeddedClient
{
    private $environment;
    private $api_url;
    private $api_key;
    private $public_key;
    private $webhook_key;
    private $intent;
    private $mode;
    private $currency;
    private $source;
    private $vault_source;


    /**
    * SafePayEmbeddedClient constructor.
    * @param array $config.
    */
    public function __construct($config)
    {
        //LIVE = production
        //TEST = sandbox
        $this->environment = (isset($config['environment']) && in_array($config['environment'], ['sandbox','production'])) ? $config['environment'] : "production";
        $this->api_url = ($this->environment == 'production') ? "https://api.getsafepay.com" : "https://sandbox.api.getsafepay.com";
        $this->api_key = (isset($config['api_key']) && $config['api_key'] != "") ? $config['api_key'] : throw new SafePayEmbeddedException("API Key is missing");
        $this->public_key = (isset($config['public_key']) && $config['public_key'] != "") ? $config['public_key'] : throw new SafePayEmbeddedException("Public Key is missing");
        $this->webhook_key = (isset($config['webhook_key']) && $config['webhook_key'] != "") ? $config['webhook_key'] : "";
        $this->intent = (isset($config['intent']) && $config['intent'] != "") ? $config['intent'] : "CYBERSOURCE";
        $this->mode = (isset($config['mode']) && $config['mode'] != "") ? $config['mode'] : "unscheduled_cof";
        $this->currency = (isset($config['currency']) && $config['currency'] != "") ? $config['currency'] : "PKR";
        $this->source = (isset($config['source']) && $config['source'] != "") ? $config['source'] : "Pay Minion";
        $this->vault_source = (isset($config['vault_source']) && $config['vault_source'] != "") ? $config['vault_source'] : "mobile";
        $this->Safepay = new SafepayClient(array(
            "api_key" => $this->api_key,
            "api_base" => $this->api_url,
        ));
    }

    /**
    * SafePayEmbedded Create Customer.
    * @param array $config.
    */
    public function createCustomer($customer)
    {
        if(!is_array($customer)){
            throw new SafePayEmbeddedException("Data must be an associative array");
        }
        $first_name = (isset($customer['first_name']) && $customer['first_name'] != "") ? $customer['first_name'] : throw new SafePayEmbeddedException("First Name is missing");
        $last_name = (isset($customer['last_name']) && $customer['last_name'] != "") ? $customer['last_name'] : throw new SafePayEmbeddedException("Last Name is missing");
        $email = (isset($customer['email']) && $customer['email'] != "") ? $customer['email'] : throw new SafePayEmbeddedException("Email is missing");
        $phone_number = (isset($customer['phone_number']) && $customer['phone_number'] != "") ? $customer['phone_number'] : throw new SafePayEmbeddedException("Phone Number is missing");
        $country = (isset($customer['country']) && $customer['country'] != "") ? $customer['country'] : throw new SafePayEmbeddedException("Country is missing");
        $is_guest = (isset($customer['is_guest']) && $customer['is_guest'] != "" && ($customer['is_guest'] === true || $customer['is_guest'] === false)) ? $customer['is_guest'] : false;
        try {
            $customer = $this->Safepay->customer->create([
                "first_name" => $customer['first_name'],
                "last_name" => $customer['last_name'],
                "email" => $customer['email'],
                "phone_number" => $customer['phone_number'],
                "country" => $customer['country'],
                "is_guest" => $is_guest,
            ]);
            return array(
                "status" => 1,
                "token" => $customer->token
            );
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error creating customer.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Update Customer.
    * @param array $config.
    */
    public function updateCustomer($customer)
    {
        if(!is_array($customer)){
            throw new SafePayEmbeddedException("Data must be an associative array");
        }
        $token = (isset($customer['token']) && $customer['token'] != "") ? $customer['token'] : throw new SafePayEmbeddedException("Customer Token is missing");
        $first_name = (isset($customer['first_name']) && $customer['first_name'] != "") ? $customer['first_name'] : throw new SafePayEmbeddedException("First Name is missing");
        $last_name = (isset($customer['last_name']) && $customer['last_name'] != "") ? $customer['last_name'] : throw new SafePayEmbeddedException("Last Name is missing");
        $email = (isset($customer['email']) && $customer['email'] != "") ? $customer['email'] : throw new SafePayEmbeddedException("Email is missing");
        $phone_number = (isset($customer['phone_number']) && $customer['phone_number'] != "") ? $customer['phone_number'] : throw new SafePayEmbeddedException("Phone Number is missing");
        $country = (isset($customer['country']) && $customer['country'] != "") ? $customer['country'] : throw new SafePayEmbeddedException("Country is missing");
        try {
            $customer = $this->Safepay->customer->update($token, [
                "first_name" => $customer['first_name'],
                "last_name" => $customer['last_name'],
                "email" => $customer['email'],
                "phone_number" => $customer['phone_number'],
                "country" => $customer['country'],
            ]);
            return array(
                "status" => 1,
                "message" => "Customer Updated successfully",
                "token" => $customer->token
            );
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error updating customer.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Get Customer.
    * @param array $config.
    */
    public function retrieveCustomer($customer_token = "")
    {
        $token = (isset($customer_token) && $customer_token != "") ? $customer_token : throw new SafePayEmbeddedException("Customer Token is missing");
        try {
            $customer = $this->Safepay->customer->retrieve($token);
            return array(
                "status" => 1,
                "token" => $customer->token,
                "customer" => array(
                    "first_name" => $customer->first_name,
                    "last_name" => $customer->last_name,
                    "phone_number" => $customer->phone_number,
                    "email" => $customer->email,
                    "country" => $customer->country,
                    "is_guest" => $customer->is_guest,
                )
            );
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error retrieving customer.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Delete Customer.
    * @param array $config.
    */
    public function deleteCustomer($customer_token = "")
    {
        $token = (isset($customer_token) && $customer_token != "") ? $customer_token : throw new SafePayEmbeddedException("Customer Token is missing");
        try {
            $customer = $this->Safepay->customer->delete($token);
            return array(
                "status" => 1
            );
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error deleting customer.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Get All Payment Methods.
    * @param array $config.
    */
    public function getAllPaymentMethods($customer_token = "")
    {
        $token = (isset($customer_token) && $customer_token != "") ? $customer_token : throw new SafePayEmbeddedException("Customer Token is missing");
        try {
            $paymentMethods = json_decode(json_encode($this->Safepay->paymentMethod->all($token)), true);
            $payment_methods = array();
            if(isset($paymentMethods["count"]) && $paymentMethods['count'] > 0){
                foreach($paymentMethods['wallet'] as $wallet){
                    $cybersource = array();
                    if(isset($wallet['cybersource'])) {
                       $cybersource = array(
                            "token" => $wallet['cybersource']['token'],
                            "customer_payment_method" => $wallet['cybersource']['customer_payment_method'],
                            "bin" => $wallet['cybersource']['bin'],
                        );
                    }
                    array_push($payment_methods, array(
                        "token" => $wallet['token'],
                        "kind" => $wallet['kind'],
                        "scheme" => $wallet['cybersource']['scheme'],
                        "max_usage" => $wallet['max_usage'],
                        "usage_count" => $wallet['usage_count'],
                        "usage_interval" => $wallet['usage_interval'],
                        "is_deleted" => $wallet['is_deleted'],
                        "last_four" => $wallet['cybersource']['last_four'],
                        "expiry_month" => $wallet['cybersource']['expiry_month'],
                        "expiry_year" => $wallet['cybersource']['expiry_year'],
                        "expires_at" => date("Y-m-d H:i:s", $wallet['expires_at']['seconds']),
                        "cybersource" => $cybersource,
                    ));
                }
            }
            return array(
                "status" => 1,
                "payment_methods" => $payment_methods
            );
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error getting payment methods.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Get Payment Method.
    * @param array $config.
    */
    public function getPaymentMethod($customer_token = "", $payment_token = "")
    {
        $token = (isset($customer_token) && $customer_token != "") ? $customer_token : throw new SafePayEmbeddedException("Customer Token is missing");
        $payment_token = (isset($payment_token) && $payment_token != "") ? $payment_token : throw new SafePayEmbeddedException("Payment Token is missing");
        try {
            $wallet = json_decode(json_encode($this->Safepay->paymentMethod->retrieve($token, $payment_token)), true);
            $payment_methods = array();
            if(isset($wallet["token"]) && $wallet['token'] != ""){
                $payment_methods = array(
                    "token" => $wallet['token'],
                    "kind" => $wallet['kind'],
                    "scheme" => $wallet['cybersource']['scheme'],
                    "max_usage" => $wallet['max_usage'],
                    "usage_count" => $wallet['usage_count'],
                    "usage_interval" => $wallet['usage_interval'],
                    "is_deleted" => $wallet['is_deleted'],
                    "last_four" => $wallet['cybersource']['last_four'],
                    "expiry_month" => $wallet['cybersource']['expiry_month'],
                    "expiry_year" => $wallet['cybersource']['expiry_year'],
                    "expires_at" => date("Y-m-d H:i:s", $wallet['expires_at']['seconds']),
                    "cybersource" => array(
                        "token" => $wallet['cybersource']['token'],
                        "customer_payment_method" => $wallet['cybersource']['customer_payment_method'],
                        "bin" => $wallet['cybersource']['bin'],
                    ),
                );
            }
            return array(
                "status" => 1,
                "payment_methods" => $payment_methods
            );
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error getting payment method.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Delete Payment Method.
    * @param array $config.
    */
    public function deletePaymentMethod($customer_token = "", $payment_token = "")
    {
        $token = (isset($customer_token) && $customer_token != "") ? $customer_token : throw new SafePayEmbeddedException("Customer Token is missing");
        $payment_token = (isset($payment_token) && $payment_token != "") ? $payment_token : throw new SafePayEmbeddedException("Payment Token is missing");
        try {
            $paymentMethod = $this->Safepay->paymentMethod->delete($token, $payment_token);
            return array(
                "status" => 1
            );
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error deleting payment method.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Charge Customer.
    * @param array $config.
    */
    public function chargeCustomer($order)
    {
        if(!is_array($order)){
            throw new SafePayEmbeddedException("Data must be an associative array");
        }
        if (!is_numeric($order['amount']) || filter_var($order['amount'], FILTER_VALIDATE_FLOAT) === false) {
            throw new AlfalahAPGException("Transaction Amount must be a number or float.");
        }
        $token = (isset($order['token']) && $order['token'] != "") ? $order['token'] : throw new SafePayEmbeddedException("Customer Token is missing");
        $payment_token = (isset($order['payment_token']) && $order['payment_token'] != "") ? $order['payment_token'] : throw new SafePayEmbeddedException("Payment Token is missing");
        $amount = (isset($order['amount']) && $order['amount'] != "") ? $order['amount'] : throw new SafePayEmbeddedException("Amount is missing");
        $order_id = (isset($order['order_id']) && $order['order_id'] != "") ? $order['order_id'] : uniqid();
        $intent = (isset($order['intent']) && $order['intent'] != "") ? $order['intent'] : $this->intent;
        $mode = (isset($order['mode']) && $order['mode'] != "") ? $order['mode'] : $this->mode;
        $currency = (isset($order['currency']) && $order['currency'] != "") ? $order['currency'] : $this->currency;
        $source = (isset($order['source']) && $order['source'] != "") ? $order['source'] : $this->source;
        try {
            $session = $this->Safepay->order->setup([
                "user" => $token,
                "merchant_api_key" => $this->public_key,
                "intent" => $intent,
                "mode" => $mode,
                "currency" => $currency,
                "amount" => (float)$amount * 100
            ]);
            $tracking_token = $session->tracker->token;
            $session = $this->Safepay->order->metadata($tracking_token, [
                "data" => [
                    "source" => $source,
                    "order_id" => $order_id
                ]
            ]);
            $tracker = json_decode(json_encode($this->Safepay->order->charge($tracking_token, [
                "payload" => [
                    "payment_method" => [
                        "tokenized_card" => [
                            "token" => $payment_token
                        ],
                    ],
                ]
            ])),true);
            if(isset($tracker['tracker']) && isset($tracker['tracker']['state']) && $tracker['tracker']['state'] == 'TRACKER_ENDED') {
                return array(
                    "status" => 1,
                    "tracker" => $tracker['tracker']
                );
            } else {
                return array(
                    "status" => 0,
                    "message" => "There was an error charging customer.",
                    "error" => $e->getError()
                );
            }
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error charging customer.",
                "error" => $e->getError()
            );
        }
    }

    
    /**
    * SafePayEmbedded Charge Customer.
    * @param array $config.
    */
    public function getCardVaultURL($customer_token = "", $type = "redirect")
    {
        $token = (isset($customer_token) && $customer_token != "") ? $customer_token : throw new SafePayEmbeddedException("Customer Token is missing");
        try {
            $session = $this->Safepay->order->setup([
                "merchant_api_key" => $this->public_key,
                "intent" => $this->intent,
                "mode" => "instrument",
                "currency" => $this->currency
            ]);
            $tbt = $this->Safepay->passport->create();
            $params = array(
                "environment" => $this->environment,
                "tracker" => $session->tracker->token,
                "source" => $this->vault_source,
                "tbt" => $tbt->token,
                "user_id" => $customer_token
            );
            $encoded = \http_build_query($params);
            $url = $this->api_url . "/embedded?" . $encoded;
            if($type == "url"){
                return array(
                    "status" => 1,
                    "vault_url" => $url
                );
            } else if($type == "redirect"){
                header("Location: " . $url);
                die();
            }
        } catch (\Exception $e) {
            return array(
                "status" => 0,
                "message" => "There was an error getting card vault url.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Verify Payment.
    * @param array $config.
    */
    public function verifyPayment()
    {
        $payload = @file_get_contents('php://input');
        if(empty($payload)){
            $payload = json_encode(array());
        }
        $event = null;
        try {
            $event = \Safepay\Event::constructFrom(json_decode($payload, true));
            http_response_code(200);
            switch ($event->type) {
                case 'payment.succeeded':
                    $payment = $event->data;
                    return array(
                        "status" => 1,
                        "data" => $event->data
                    );
                case 'payment.failed':
                    return array(
                        "status" => 0,
                        "message" => "Payment Failed.",
                        "error" => $event->data
                    );
                default:
                    return array(
                        "status" => 0,
                        "message" => "Recevied Unknown event type.",
                        "error" => $event->type
                    );
            }
        } catch (\Exception $e) {
            http_response_code(400);
            return array(
                "status" => 0,
                "message" => "Unauthorized Request.",
                "error" => $e->getError()
            );
        }
    }

    /**
    * SafePayEmbedded Secured Verify Payment.
    * @param array $config.
    */
    public function verifyPaymentSecured()
    {
        if($this->webhook_key == ""){
            throw new SafePayEmbeddedException("Webhook Key not set during initialization");
        }
        $payload = @file_get_contents('php://input');
        if(empty($payload)){
            $payload = json_encode(array());
        }
        $sig_header = isset($_SERVER['HTTP_X_SFPY_SIGNATURE']) ? $_SERVER['HTTP_X_SFPY_SIGNATURE'] : throw new SafePayEmbeddedException("Unauthenticated Request");;
        $webhook_secret = $this->webhook_key;
        $event = null;
        try {
            $event = \Safepay\Webhook::constructEvent($payload, $sig_header, $webhook_secret);
            http_response_code(200);
            switch ($event->type) {
                case 'payment.succeeded':
                    $payment = $event->data;
                    return array(
                        "status" => 1,
                        "data" => $event->data
                    );
                case 'payment.failed':
                    return array(
                        "status" => 0,
                        "message" => "Payment Failed.",
                        "error" => $event->data
                    );
                default:
                    return array(
                        "status" => 0,
                        "message" => "Recevied Unknown event type.",
                        "error" => $event->type
                    );
            }
        } catch (\Exception $e) {
            http_response_code(400);
            return array(
                "status" => 0,
                "message" => "Unauthorized Request.",
                "error" => $e->getError()
            );
        }
    }
}
