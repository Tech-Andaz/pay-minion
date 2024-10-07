<?php

require 'vendor/autoload.php';

use TechAndaz\EasyPaisa\EasyPaisaClient;
use TechAndaz\EasyPaisa\EasyPaisaAPI;

$EasyPaisaClient = new EasyPaisaClient(array(
    "environment" => "production", // Optional - Defaults to production. Options are: sandbox / production
    "store_id" => "581148",
    "hash_key" => "03OR1JW97JP19Q13",
    "return_url" => "https://techandaz.com/success", // Optional - Must be set here or during checkout link creation
    "private_key" => "easypaisa_private_key.pem",
    "username" => "TechAndaz",
    "password" => "a87a9efb0664c8a1f9076ad7d276696e"
));

$EasyPaisaAPI = new EasyPaisaAPI($EasyPaisaClient);

//Initiate Hosted Checkout
function initiateHostedCheckout($EasyPaisaAPI){
    try {
        $data = array(
            "amount" => 25.33,
            "order_id" => "asd1234", // Optional - Will generate unique ID if not provided
            "email" =>  "daium_ahsan@hotmail.com", // Optional
            "phone" =>  "03234896599", // Optional
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
            "auth_token" => "218981353504683204577836995429235849804",
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
            "order_id" => "asd1234", // Optional - Will generate unique ID if not provided
            "email" =>  "daium_ahsan@hotmail.com", // Optional
            "phone" =>  "03234896599", // Optional
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
//Link Mobile Wallet
function linkMobileWallet($EasyPaisaAPI){
    try {
        $data = array(
            "mobileAccountNo" =>  "03214109373",
        );
        $response = $EasyPaisaAPI->linkMobileWallet($data);
        print_r($response);
        exit;
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
// print_r(initiateHostedCheckout($EasyPaisaAPI));
// print_r(processHostedCheckout($EasyPaisaAPI));
// print_r(createHostedCheckout($EasyPaisaAPI));
print_r(linkMobileWallet($EasyPaisaAPI));
// echo json_encode(processResponse($EasyPaisaAPI));
// echo json_encode(mobileAccountLinking($EasyPaisaAPI));
// echo json_encode(linkedMobileAccountTransaction($EasyPaisaAPI));
// echo json_encode(transactionStatus($EasyPaisaAPI));
// echo json_encode(refundCardTransaction($EasyPaisaAPI));
// echo json_encode(refundWalletTransaction($EasyPaisaAPI));
?>
