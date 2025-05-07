<?php

require 'vendor/autoload.php';

use TechAndaz\EasyPaisa\EasyPaisaClient;
use TechAndaz\EasyPaisa\EasyPaisaAPI;

$EasyPaisaClient = new EasyPaisaClient(array(
    "environment" => "production", // Optional - Defaults to production. Options are: sandbox / production
    "store_id" => "",
    "return_url" => "", // Optional - Must be set here or during checkout link creation
    "ewp_account_number" => "",
    "username" => "",
    "password" => "",
    "hash_key" => ""
));

$EasyPaisaAPI = new EasyPaisaAPI($EasyPaisaClient);

//Initiate Hosted Checkout
function initiateHostedCheckout($EasyPaisaAPI){
    try {
        $data = array(
            "amount" => 25.33,
            "order_id" => "12345", // Optional - Will generate unique ID if not provided
            "email" =>  "contact@test.com", // Optional
            "phone" =>  "1234567897988", // Optional
            "bank_id" =>  "", // Optional
            "expiry_datetime" =>  "", // Optional - Format: Ymd His
            "return_url" =>  "", // Optional - Has to be provided either during initializing or here
            "payment_method" =>  "", // Optional - Options are: OTC_PAYMENT_METHOD / MA_PAYMENT_METHOD / CC_PAYMENT_METHOD / QR_PAYMENT_METHOD / DD_PAYMENT_METHOD
        );
        $response_type = "follow"; // form / follow / redirect - Defaults to redirect, form will print form - redirect will print and execute form - follow will execute curl and return auth token 
        $response = $EasyPaisaAPI->initiateHostedCheckout($data, $response_type);
        return $response;
    } catch (TechAndaz\EasyPaisa\EasyPaisaException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Process Hosted Checkout
function processHostedCheckout($EasyPaisaAPI){
    try {
        $data = array(
            "auth_token" => "123455667777778888",
            "return_url" => ""
        );
        $response_type = "redirect"; // form / redirect - Defaults to redirect, form will print form - redirect will print and execute form
        $response = $EasyPaisaAPI->processHostedCheckout($data, $response_type);
        return $response;
    } catch (TechAndaz\EasyPaisa\EasyPaisaException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Create Hosted Checkout
function createHostedCheckout($EasyPaisaAPI){
    try {
        $data = array(
            "amount" => 25.33,
            "order_id" => "12345", // Optional - Will generate unique ID if not provided
            "email" =>  "contact@test.com", // Optional
            "phone" =>  "1234567897988", // Optional
            "bank_id" =>  "", // Optional
            "expiry_datetime" =>  "", // Optional - Format: Ymd His
            "return_url" =>  "", // Optional - Has to be provided either during initializing or here
            "payment_method" =>  "", // Optional - Options are: OTC_PAYMENT_METHOD / MA_PAYMENT_METHOD / CC_PAYMENT_METHOD / QR_PAYMENT_METHOD / DD_PAYMENT_METHOD
        );
        $response_type = "follow"; // form / follow / redirect - Defaults to redirect, form will print form - redirect will print and execute form - follow will execute curl and return auth token 
        $response = $EasyPaisaAPI->initiateHostedCheckout($data, $response_type);
        if($response['status'] == 1){
            try {
                $data = array(
                    "auth_token" => $response['auth_token'],
                    "return_url" => ""
                );
                $response_type = "form"; // form / redirect - Defaults to redirect, form will print form - redirect will print and execute form
                $response = $EasyPaisaAPI->processHostedCheckout($data, $response_type);
                return $response;
            } catch (TechAndaz\EasyPaisa\EasyPaisaException $e) {
                echo "Error: " . $e->getMessage() . "\n";
            }
        } else {
            return $response;
        }
    } catch (TechAndaz\EasyPaisa\EasyPaisaException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Verify Transaction
function verifyTransaction($EasyPaisaAPI){
    try {
        $response = $EasyPaisaAPI->transactionStatus("681b91387ce11");
        return $response;
    } catch (TechAndaz\EasyPaisa\EasyPaisaException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Perform Wallet Transaction
function performWalletTransaction($EasyPaisaAPI){
    try {
        $requestData = array(
            "order_id" => "",
            "amount" => 2,
            "account_number" => "",
            "email_address" => "",
        );
        $response = $EasyPaisaAPI->performWalletTransaction($requestData);
        return $response;
    } catch (TechAndaz\EasyPaisa\EasyPaisaException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// print_r(initiateHostedCheckout($EasyPaisaAPI));
// print_r(processHostedCheckout($EasyPaisaAPI));
// print_r(createHostedCheckout($EasyPaisaAPI));
// print_r(verifyTransaction($EasyPaisaAPI));
// print_r(performWalletTransaction($EasyPaisaAPI));
