<?php

require 'vendor/autoload.php';

use TechAndaz\SafePay\SafePayClient;
use TechAndaz\SafePay\SafePayAPI;

$SafePayClient = new SafePayClient(array(
    "environment" =>"sandbox",
    "apiKey" => "sec_14243867-4988-424b-a2f8-d138d38deb3e",
    "v1Secret" =>  "d11bf1408f381b8048d23d57bf628924b63e58f57fd4f72e622fa8623382a9aa",
    "webhookSecret" =>  "175f26b3c3fd27f4f18ac1048d9721794e1934481d83dd010e083590c4decc3e",
    "success_url" => "https://techandaz.com/success",
    "cancel_url" => "https://techandaz.com/cancel",
));
$SafePayAPI = new SafePayAPI($SafePayClient);

//Create Checkout Link
function createCheckoutLink($SafePayAPI){
    try {
        $data = array(
            "amount" => 5000,
            "order_id" => "TA-001",
            "source" => "Tech Andaz",
            "webhooks" => "true",
        );
        $response = $SafePayAPI->createCheckoutLink($data);
        return $response;
    } catch (TechAndaz\SafePay\SafePayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Verify Signature Success
function verifySuccessSignature($SafePayAPI){
    try {
        $tracker = $_POST['tracker'];
        $signature = $_POST['sig'];
        $response = $SafePayAPI->verifySuccessSignature($tracker, $signature);
        return $response;
    } catch (TechAndaz\SafePay\SafePayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Verify Signature Webhooks
function verifyWebhookSignature($SafePayAPI){
    try {
        $response = $SafePayAPI->verifyWebhookSignature();
        return $response;
    } catch (TechAndaz\SafePay\SafePayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Form Fields
function getFormFields($SafePayAPI){
    try { 
        $config = array(
            "response" => "form",
            "label_class" => "form-label",
            "input_class" => "form-control",
            "wrappers" => array(
                "amount" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "order_id" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "source" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "webhooks" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
            ),
            "optional" => true,
            "optional_selective" => array(
            ),
        );
        $response = $SafePayAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\SafePay\SafePayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(createCheckoutLink($SafePayAPI));
// echo json_encode(verifySuccessSignature($SafePayAPI));
// echo json_encode(verifyWebhookSignature($SafePayAPI));
echo (getFormFields($SafePayAPI));
?>
