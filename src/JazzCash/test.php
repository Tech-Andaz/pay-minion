<?php

require 'vendor/autoload.php';

use TechAndaz\JazzCash\JazzCashClient;
use TechAndaz\JazzCash\JazzCashAPI;

$JazzCashClient = new JazzCashClient(array(
    "environment" => "sandbox", // Optional - Defaults to production. Options are: sandbox / production
    "merchant_id" => "MC108944",
    "password" => "5990v09a6d",
    "integerity_salt" => "zx82t8029e",
    "domain_code" => "TA", //max 3 character code to be appended for all Transaction Reference numbers 
    "return_url" => "https://techandaz.com/success",
));

$JazzCashAPI = new JazzCashAPI($JazzCashClient);

//Create Checkout Link
function createCheckoutLink($JazzCashAPI){
    try {
        $data = array(
            "amount" => 25.30,
            "bill_reference" =>  "billRef",
            "transaction_reference" => "", // Optional - max 17 character length - domain_code will be added in the beggining - leave empty for auto generated
            "description" => "description",
            "date_time" => date("YmdHis"), // Optional - will use current time if not provided
            "order_id" => "", // Optional - Will generate unique ID if not provided
            "metafield_1" => "", //Optional Metadata for order
            "metafield_2" => "", //Optional Metadata for order
            "metafield_3" => "", //Optional Metadata for order
            "metafield_4" => "", //Optional Metadata for order
            "metafield_5" => "", //Optional Metadata for order
        );
        $response_type = "redirect"; // redirect / form - Defaults to redirect, Redirect will automatically redirect user to payment page, form will return html form with fields and values
        $response = $JazzCashAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Process Response
function processResponse($JazzCashAPI){
    try {
        $response = $JazzCashAPI->processResponse();
        return $response;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Mobile Account Linking TOKENIZATION
function mobileAccountLinking($JazzCashAPI){
    try {
        $data = array(
            "account_number" => "03234896599",
        );
        $response_type = "redirect"; // redirect / form - Defaults to redirect, Redirect will automatically redirect user to payment page, form will return html form with fields and values
        $response = $JazzCashAPI->mobileAccountLinking($data, $response_type);
        return $response;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Mobile Account Transaction TOKENIZATION
function linkedMobileAccountTransaction($JazzCashAPI){
    try {
        $data = array(
            "amount" => 25.30,
            "payment_token" => "LI0yTger3EgcVsX1aEzSQpCaOUl8mN1w",
            "bill_reference" =>  "billRef",
            "transaction_reference" => "", // Optional - max 17 character length - domain_code will be added in the beggining - leave empty for auto generated
            "description" => "description",
            "date_time" => date("YmdHis"), // Optional - will use current time if not provided
            "order_id" => "", // Optional - Will generate unique ID if not provided
            "metafield_1" => "", //Optional Metadata for order
            "metafield_2" => "", //Optional Metadata for order
            "metafield_3" => "", //Optional Metadata for order
            "metafield_4" => "", //Optional Metadata for order
            "metafield_5" => "", //Optional Metadata for order
        );
        $response = $JazzCashAPI->linkedMobileAccountTransaction($data);
        return $response;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Transaction Status
function transactionStatus($JazzCashAPI){
    try {
        $transaction_reference = "T20220203110109";
        $response = $JazzCashAPI->transactionStatus($transaction_reference);
        return $response;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Card Transaction Refund
function refundCardTransaction($JazzCashAPI){
    try {
        $transaction_reference = "TREF2022051812564132";
        $amount = 100;
        $response = $JazzCashAPI->refundCardTransaction($transaction_reference, $amount);
        return $response;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Wallet Transaction Refund
function refundWalletTransaction($JazzCashAPI){
    try {
        $transaction_reference = "T20220518150213";
        $amount = 100;
        $mpin = "1234";
        $response = $JazzCashAPI->refundWalletTransaction($transaction_reference, $amount, $mpin);
        return $response;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(createCheckoutLink($JazzCashAPI));
// echo json_encode(processResponse($JazzCashAPI));
// echo json_encode(mobileAccountLinking($JazzCashAPI));
echo json_encode(linkedMobileAccountTransaction($JazzCashAPI));
// echo json_encode(transactionStatus($JazzCashAPI));
// echo json_encode(refundCardTransaction($JazzCashAPI));
// echo json_encode(refundWalletTransaction($JazzCashAPI));
?>
