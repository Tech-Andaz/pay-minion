<?php

require 'vendor/autoload.php';

use TechAndaz\SafePayEmbedded\SafePayEmbeddedClient;
use TechAndaz\SafePayEmbedded\SafePayEmbeddedAPI;

$SafePayEmbeddedClient = new SafePayEmbeddedClient(array(
    "environment" =>"sandbox", // Optional - Defaults to production. Options are: sandbox / production
    "api_key" => "d11bf1408f381b8048d23d57bf628924b63e58f57fd4f72e622fa8623382a9aa",
    "public_key" =>  "sec_14243867-4988-424b-a2f8-d138d38deb3e",
    "webhook_key" =>  "175f26b3c3fd27f4f18ac1048d9721794e1934481d83dd010e083590c4decc3e",
    "intent" => "CYBERSOURCE", // Optional - Defaults to CYBERSOURCE
    "mode" => "unscheduled_cof", // Optional - Defaults to unscheduled_cof
    "currency" => "PKR", // Optional - Defaults to PKR
    "source" => "My App", // Optional - Defaults to Pay Minion
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
            "is_guest" => true // Optioanl - Defaults to false. Options are: true / false
        );
        $response = $SafePayEmbeddedAPI->createCustomer($data);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

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
        $token = "cus_dbcd2765-85c6-46dd-b3c4-b933d26db49b";
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
        //Set to 0 or don't parse for NON 3DS transactions
        $threeDS = 1;
        $data = array(
            "token" => "cus_0010b01b-5ca9-42d6-aa9f-db94732b563d",
            "payment_token" => "pm_96d0683d-93b2-4085-a151-acf9289915e9",
            "amount" => 5,
            "3ds_verification_success_url" => "http://localhost/payminion/test.php?3dsresponse=1", //required if 3DS is true
            "3ds_verification_fail_url" => "http://localhost/payminion/test.php?3dsfail=1", //required if 3DS is true
            "3ds_verification_verification_url" => "http://localhost/payminion/test.php?3dsverify=1", //required if 3DS is true
            "3ds_not_entrolled_charge" => 1, //Optional. Will charge customer even if not enrolled in 3DS
            "order_id" => "12345", // Optional - Defaults to unique ID
            "intent" => "CYBERSOURCE", // Optional - Defaults to value set in intialize stage
            "mode" => "unscheduled_cof", //Optional - Defaults to value set in intialize stage
            "currency" => "PKR", //Optional - Defaults to value set in intialize stage
            "source" => "Pay Minion" //Optional - Defaults to value set in intialize stage
        );
        $response = $SafePayEmbeddedAPI->chargeCustomer($data, $threeDS);
        if($response['status'] == 2){
            echo initiate3DSSecure($SafePayEmbeddedAPI, $response);
            exit;
        }
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Initiate 3DS
function initiate3DSSecure($SafePayEmbeddedAPI, $data){
    try {
        $response = $SafePayEmbeddedAPI->initiate3DSSecure($data);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Verify 3DS
function process3DSRequest($SafePayEmbeddedAPI, $data){
    try {
        $response = $SafePayEmbeddedAPI->process3DSRequest($data);
        if($response['status'] == 1){
            //Card Charged Successfully - No OTP requried
            return $response;
        } else if($response['status'] == 2){
            //3DS OTP required
            print_r($response);
            exit;
            echo $SafePayEmbeddedAPI->requestOTPCode3DS($response);
            return;
        } else {
            //Error
            return $response;
        }
        return;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Charge Customer
function getCardVaultURL($SafePayEmbeddedAPI){
    try {
        $response = $SafePayEmbeddedAPI->getCardVaultURL("cus_dbcd2765-85c6-46dd-b3c4-b933d26db49b");
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

if(isset($_GET['3dsverify']) && $_GET['3dsverify'] == 1){
    //Verify 3DS
    process3DSRequest($SafePayEmbeddedAPI, $_POST);
} else if(isset($_GET['3dsresponse']) && $_GET['3dsresponse'] == 1){
    //Successful 3DS
    try {
        print_r($_GET);
        exit;
        $response = $SafePayEmbeddedAPI->charge3DS($_GET);
        print_r($response);
        return $response;
    } catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
} else if(isset($_GET['3dsfail']) && $_GET['3dsfail'] == 1){
    //Verify 3DS
    print_r($_GET);
} else {
    // echo json_encode(createCustomer($SafePayEmbeddedAPI));
    // echo json_encode(getCardVaultURL($SafePayEmbeddedAPI));
    // echo json_encode(updateCustomer($SafePayEmbeddedAPI));
    // echo json_encode(retrieveCustomer($SafePayEmbeddedAPI));
    // echo json_encode(deleteCustomer($SafePayEmbeddedAPI));
    // echo json_encode(getAllPaymentMethods($SafePayEmbeddedAPI));
    // echo json_encode(getPaymentMethod($SafePayEmbeddedAPI));
    // echo json_encode(deletePaymentMethod($SafePayEmbeddedAPI));
    echo json_encode(chargeCustomer($SafePayEmbeddedAPI));
    // echo json_encode(verifyPayment($SafePayEmbeddedAPI));
    // echo json_encode(verifyPaymentSecured($SafePayEmbeddedAPI));
}

//pm_8e1d173f-9a5b-45e8-84dd-fed85187ff77 - NO OTP Required
?>

