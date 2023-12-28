<?php

require 'vendor/autoload.php';

use TechAndaz\PayFast\PayFastClient;
use TechAndaz\PayFast\PayFastAPI;

$PayFastClient = new PayFastClient(array(
    "api_url" =>"https://ipguat.apps.net.pk/", // Optional - Defaults to Production URL
    "merchant_id" => "12755",
    "api_password" =>  "EPxDB03HcU7yzIgstwwj",
    "merchant_name" =>  "Pay Minion",
    "success_url" =>  "https://techandaz.com/success", // Required/Optional - Must be provided either during initialize or during checkout link creation.
    "cancel_url" =>  "https://techandaz.com/cancel", // Optional - Defaults to success url
    "checkout_url" =>  "https://techandaz.com/checkout", // Optional - Defaults to success url
    "currency_code" =>  "PKR", // Optional - Defaults to PKR. If provided will default for all transactions except when explicitly mentioned
    "proccode" =>  "00", // Optional - Defaults to 00. If provided will default for all transactions except when explicitly mentioned
    "tran_type" =>  "ECOMM_PURCHASE", // Optional - Defaults to ECOMM_PURCHASE. If provided will default for all transactions except when explicitly mentioned
));

$PayFastAPI = new PayFastAPI($PayFastClient);

//Create Checkout Link
function createCheckoutLink($PayFastAPI){
    try {
        $data = array(
            "TXNAMT" => 5000,
            "BASKET_ID" => "", // Optional - Will generate unique ID if not provided
            "currency_code" =>  "PKR", // Optional - Will use one set during initializing
            "success_url" =>  "https://techandaz.com/success", // Optional - Will use one set during initializing
            "cancel_url" =>  "https://techandaz.com/success", // Optional - Will use one set during initializing
            "checkout_url" =>  "https://techandaz.com/success", // Optional - Will use one set during initializing
            "customer_email" => "test@test.com",
            "customer_phone" => "+921234567899",
            "order_date" => "2023-12-01 12:00:00", // Optional - Will use date(Y-m-d H:i:s) if not provided
            "proccode" => "00", // Optional - will use one set during initializing
            "tran_type" => "ECOMM_PURCHASE", // Optional - will use one set during initializing
        );
        $response_type = "redirect"; // form / redirect / data - Defaults to redirect, Redirect will automatically redirect user to payment page, form will return an HTML form ready for submission, data will return array with all values
        $response = $PayFastAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\PayFast\PayFastException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Dynamic Redirect
function dynamicRedirect($PayFastAPI){
    try {
        $data = array(
            "TXNAMT" => 5000,
            "BASKET_ID" => "", // Optional - Will generate unique ID if not provided
            "currency_code" =>  "PKR", // Optional - Will use one set during initializing
            "success_url" =>  "https://techandaz.com/success", // Optional - Will use one set during initializing
            "cancel_url" =>  "https://techandaz.com/success", // Optional - Will use one set during initializing
            "checkout_url" =>  "https://techandaz.com/success", // Optional - Will use one set during initializing
            "customer_email" => "test@test.com",
            "customer_phone" => "+921234567899",
            "order_date" => "2023-12-01 12:00:00", // Optional - Will use date(Y-m-d H:i:s) if not provided
            "proccode" => "00", // Optional - will use one set during initializing
            "tran_type" => "ECOMM_PURCHASE", // Optional - will use one set during initializing
        );
        $response_type = "data"; // form / redirect / data - Defaults to redirect, Redirect will automatically redirect user to payment page, form will return an HTML form ready for submission, data will return array with all values
        $response = $PayFastAPI->createCheckoutLink($data, $response_type);
        $PayFastAPI->dynamicRedirect($response);
        return;
    } catch (TechAndaz\PayFast\PayFastException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Form Fields
function getFormFields($PayFastAPI){
    try { 
        $config = array(
            "response" => "form",
            "label_class" => "form-label",
            "input_class" => "form-control",
            "wrappers" => array(
                "CUSTOMER_EMAIL_ADDRESS" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "CUSTOMER_MOBILE_NO" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "TXNAMT" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "BASKET_ID" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "ORDER_DATE" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
            ),
            "optional" => false,
            "optional_selective" => array(
            ),
        );
        $response = $PayFastAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\PayFast\PayFastException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(createCheckoutLink($PayFastAPI));
echo (dynamicRedirect($PayFastAPI));
// echo (getFormFields($PayFastAPI));
?>
