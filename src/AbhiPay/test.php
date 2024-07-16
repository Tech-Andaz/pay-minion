<?php

require 'vendor/autoload.php';

use TechAndaz\AbhiPay\AbhiPayClient;
use TechAndaz\AbhiPay\AbhiPayAPI;

$AbhiPayClient = new AbhiPayClient(array(
    "secret_key" => "C93788BC7BF04345A253B3A6CD3563EA",
    "merchant_id" => "ES1091665",
    "return_url" => "https://techandaz.com/success", //Optional - Set here or during order
));

$AbhiPayAPI = new AbhiPayAPI($AbhiPayClient);

//Create Checkout Link
function createCheckoutLink($AbhiPayAPI){
    try {
        $data = array(
            "amount" => 25.30,
            "description" =>  "", // Optional
            "transaction_reference" => "", // Optional - leave empty for auto generated
            "return_url" => "", // Optional if set during client initialization
            "cardSave" => false, // Optional - will default to false
            "operation" => "PURCHASE", // Optional - Will default to PURCHASE. Options are: PURCHASE, PREUTH, COMPLETE, REFUND
        );
        $response_type = "redirect"; // redirect / response - Defaults to redirect, Redirect will automatically redirect user to payment page, response will return response
        $response = $AbhiPayAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\AbhiPay\AbhiPayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Get Order
function getOrder($AbhiPayAPI){
    try {
        $order_id = "5b5c9720-6ed5-40c9-b677-e66c9591b39c";
        $response = $AbhiPayAPI->getOrder($order_id);
        return $response;
    } catch (TechAndaz\AbhiPay\AbhiPayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Get Order by Transaction Reference
function getOrderByTransactionReference($AbhiPayAPI){
    try {
        $transaction_reference = "5b5c9720-6ed5-40c9-b677-e66c9591b39c";
        $response = $AbhiPayAPI->getOrderByTransactionReference($transaction_reference);
        return $response;
    } catch (TechAndaz\AbhiPay\AbhiPayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Auto Pay
function autoPay($AbhiPayAPI){
    try {
        $data = array(
            "payment_token" => "57068db6-c879-4cb4-bf4e-cc90804d253e",
            "amount" => 25.30,
            "description" =>  "", // Optional
            "transaction_reference" => "", // Optional - leave empty for auto generated
            "return_url" => "", // Optional if set during client initialization
            "cardSave" => false, // Optional - will default to false
            "operation" => "PURCHASE", // Optional - Will default to PURCHASE. Options are: PURCHASE, PREUTH, COMPLETE, REFUND
        );
        $response = $AbhiPayAPI->autoPay($data);
        return $response;
    } catch (TechAndaz\AbhiPay\AbhiPayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(createCheckoutLink($AbhiPayAPI));
// echo json_encode(getOrder($AbhiPayAPI));
// echo json_encode(getOrderByTransactionReference($AbhiPayAPI));
// echo json_encode(autoPay($AbhiPayAPI));
?>
