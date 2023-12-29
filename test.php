<?php

require 'vendor/autoload.php';

use TechAndaz\CallCourier\CallCourierClient;
use TechAndaz\CallCourier\CallCourierAPI;

$CallCourierClient = new CallCourierClient(array(
    "environment" => "production", // Optional - Defaults to production. Options are: sandbox / production. Call courier doesnt have a sandbox so in sandbox mode test credentials will be applied automatically unless specified otherwise.
    "loginId" => " test-0001", // Optional if sandbox
    "password" => "test0001new", // Optional if sandbox
    "return_url" => "https://techandaz.com",
    "currency" => "PKR", // Optional - Defaults to PKR
));

$CallCourierAPI = new CallCourierAPI($CallCourierClient);

//Create Checkout Link
function createCheckoutLink($CallCourierAPI){
    try {
        $data = array(
            "amount" => 500,
            "currency" =>  "PKR", // Optional - Will use one set during initializing
            "order_id" => "", // Optional - Will generate unique ID if not provided
        );
        $response_type = "redirect"; // redirect / form / data - Defaults to redirect, Redirect will automatically redirect user to payment page, form will return html form with fields and values, data will return array with all values
        $response = $CallCourierAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Dynamic Redirect
function dynamicRedirect($CallCourierAPI){
    try {
        $data = array(
            "amount" => 500,
            "currency" =>  "PKR", // Optional - Will use one set during initializing
            "order_id" => "", // Optional - Will generate unique ID if not provided
        );
        $response_type = "data"; // redirect / data - Defaults to redirect, Redirect will automatically redirect user to payment page, data will return array with all values
        $response = $CallCourierAPI->createCheckoutLink($data, $response_type);
        $CallCourierAPI->dynamicRedirect($response);
        return;
    } catch (TechAndaz\CallCourier\CallCourierException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo (createCheckoutLink($CallCourierAPI));
echo (dynamicRedirect($CallCourierAPI));
?>
