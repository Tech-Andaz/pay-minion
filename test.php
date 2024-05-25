<?php

require 'vendor/autoload.php';

use TechAndaz\SafePayEmbedded\SafePayEmbeddedClient;
use TechAndaz\SafePayEmbedded\SafePayEmbeddedAPI;

//Update Customer
function updateCustomer($SafePayEmbeddedAPI){
    try {
        $data = array(
            "token" => "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d",
            "first_name" => "Tech",
            "last_name" => "Andaz",
            "email" => "contact@techandaz.com",
            "phone_number" => "+924235113700",
            "country" => "PK"
        );
        $response = $SafePayEmbeddedAPI->updateCustomer($data);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Retrive Customer
function retrieveCustomer($SafePayEmbeddedAPI){
    try {
        $token = "cus_46f52953-a2fa-48b7-beaf-d3449ba860eb";
        $response = $SafePayEmbeddedAPI->retrieveCustomer($token);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Delete Customer
function deleteCustomer($SafePayEmbeddedAPI){
    try {
        $token = "cus_46f52953-a2fa-48b7-beaf-d3449ba860eb";
        $response = $SafePayEmbeddedAPI->deleteCustomer($token);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get All Payment Methods
function getAllPaymentMethods($SafePayEmbeddedAPI){
    try {
        $token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
        $response = $SafePayEmbeddedAPI->getAllPaymentMethods($token);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Payment Method
function getPaymentMethod($SafePayEmbeddedAPI){
    try {
        $token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
        $payment_token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
        $response = $SafePayEmbeddedAPI->getPaymentMethod($token, $payment_token);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Delete Payment Method
function deletePaymentMethod($SafePayEmbeddedAPI){
    try {
        $token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
        $payment_token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
        $response = $SafePayEmbeddedAPI->deletePaymentMethod($token, $payment_token);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Charge Customer
function chargeCustomer($SafePayEmbeddedAPI){
    try {
        $data = array(
            "token" => "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d",
            "payment_token" => "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d",
            "amount" => 5,
            "order_id" => "12345", // Optional - Defaults to unique ID
            "intent" => "CYBERSOURCE", // Optional - Defaults to value set in intialize stage
            "mode" => "unscheduled_cof", //Optional - Defaults to value set in intialize stage
            "currency" => "PKR", //Optional - Defaults to value set in intialize stage
            "source" => "Pay Minion" //Optional - Defaults to value set in intialize stage
        );
        $response = $SafePayEmbeddedAPI->chargeCustomer($data);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Verify Payment Webhook
function verifyPayment($SafePayEmbeddedAPI){
    try {
        $response = $SafePayEmbeddedAPI->verifyPayment();
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Verify Payment Webhook
function verifyPaymentSecured($SafePayEmbeddedAPI){
    try {
        $response = $SafePayEmbeddedAPI->verifyPaymentSecured();
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}



$SafePayEmbeddedClient = new SafePayEmbeddedClient(array(
    "environment" =>"development", // Optional - Defaults to production. Options are: sandbox / production
    "api_key" => "efdc1ee87797e955b0c3b709006027b227f42b7dec84f7e07b17c39b982ca193",
    "public_key" =>  "sec_d8139699-fa47-4bc2-92c9-941b02b94d73",
    "webhook_key" =>  "175f26b3c3fd27f4f18ac1048d9721794e1934481d83dd010e083590c4decc3e",
    "intent" => "CYBERSOURCE", // Optional - Defaults to CYBERSOURCE
    "mode" => "unscheduled_cof", // Optional - Defaults to unscheduled_cof
    "currency" => "PKR", // Optional - Defaults to PKR
    "source" => "My App", // Optional - Defaults to Pay Minion,
    "is_implicit" => 'false'
));
$SafePayEmbeddedAPI = new SafePayEmbeddedAPI($SafePayEmbeddedClient);

//Create Customer
function createCustomer($SafePayEmbeddedAPI){
    try {
        $data = array(
            "first_name" => "Tech",
            "last_name" => "Andaz",
            "email" => "contact@techandaz.com",
            "phone_number" => "+924235113700",
            "country" => "PK",
            "is_guest" => false // Optioanl - Defaults to false. Options are: true / false
        );
        $response = $SafePayEmbeddedAPI->createCustomer($data);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

function getCardVaultURL($SafePayEmbeddedAPI){
    try {
        $response = $SafePayEmbeddedAPI->getCardVaultURL("cus_815d0d88-e26d-41e9-b1fe-8bc116ce2910");
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// echo json_encode(createCustomer($SafePayEmbeddedAPI));
echo json_encode(getCardVaultURL($SafePayEmbeddedAPI));
// echo json_encode(getCardVaultURL($SafePayEmbeddedAPI));
// echo json_encode(updateCustomer($SafePayEmbeddedAPI));
// echo json_encode(retrieveCustomer($SafePayEmbeddedAPI));
// echo json_encode(deleteCustomer($SafePayEmbeddedAPI));
// echo json_encode(getAllPaymentMethods($SafePayEmbeddedAPI));
// echo json_encode(getPaymentMethod($SafePayEmbeddedAPI));
// echo json_encode(deletePaymentMethod($SafePayEmbeddedAPI));
// echo json_encode(chargeCustomer($SafePayEmbeddedAPI));
// echo json_encode(verifyPayment($SafePayEmbeddedAPI));
// echo json_encode(verifyPaymentSecured($SafePayEmbeddedAPI));
?>
