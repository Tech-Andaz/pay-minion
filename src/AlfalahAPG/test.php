<?php

require 'vendor/autoload.php';

use TechAndaz\AlfalahAPG\AlfalahAPGClient;
use TechAndaz\AlfalahAPG\AlfalahAPGAPI;

$AlfalahAPGClient = new AlfalahAPGClient(array(
    "environment" => "production", // Optional - Defaults to production. Options are: sandbox / production
    "key1" => "FYWym3Ucp9UWn4k8",
    "key2" => "6281369701080712",
    "channel_id" => "1001",
    "merchant_id" => "17759",
    "store_id" => "023231",
    "redirection_request" => "0", // Optional - Defaults to 0
    "merchant_hash" => "OUU362MB1uoCmYtYcqYYYsonir3Y1cLEFdW01UoXgtIMuhhg16sV85XZ7jH7NdFyN+iQC+zvvUpOVDEZZVusJ3iRl8GQuI7twXuiBdVS7jQ=",
    "merchant_username" => "yxibes",
    "merchant_password" => "dyla/gO9xSNvFzk4yqF7CA==",
    "transaction_type" => "3", // Optional - Defaults to 3
    "cipher" => "aes-128-cbc", // Optional - Defaults to aes-128-cbc
    "return_url" => "https://techandaz.com",
    "currency" => "PKR", // Optional - Defaults to PKR
));

$AlfalahAPGAPI = new AlfalahAPGAPI($AlfalahAPGClient);

//Create Checkout Link
function createCheckoutLink($AlfalahAPGAPI){
    try {
        $data = array(
            "amount" => 500,
            "currency" =>  "PKR", // Optional - Will use one set during initializing
            "order_id" => "", // Optional - Will generate unique ID if not provided
        );
        $response_type = "redirect"; // redirect / form / data - Defaults to redirect, Redirect will automatically redirect user to payment page, form will return html form with fields and values, data will return array with all values
        $response = $AlfalahAPGAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\AlfalahAPG\AlfalahAPGException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Dynamic Redirect
function dynamicRedirect($AlfalahAPGAPI){
    try {
        $data = array(
            "amount" => 500,
            "currency" =>  "PKR", // Optional - Will use one set during initializing
            "order_id" => "", // Optional - Will generate unique ID if not provided
        );
        $response_type = "data"; // redirect / data - Defaults to redirect, Redirect will automatically redirect user to payment page, data will return array with all values
        $response = $AlfalahAPGAPI->createCheckoutLink($data, $response_type);
        $AlfalahAPGAPI->dynamicRedirect($response);
        return;
    } catch (TechAndaz\AlfalahAPG\AlfalahAPGException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo (createCheckoutLink($AlfalahAPGAPI));
// echo (dynamicRedirect($AlfalahAPGAPI));
?>
