<?php

require 'vendor/autoload.php';

use TechAndaz\JazzCash\JazzCashClient;
use TechAndaz\JazzCash\JazzCashAPI;

$JazzCashClient = new JazzCashClient(array(
    "environment" => "production", // Optional - Defaults to production. Options are: sandbox / production
    "merchant_id" => "MC108944",
    "password" => "5990v09a6d",
    "integerity_salt" => "zx82t8029e",
    "return_url" => "https://portal.techandaz.com/payments/jazzcash/response",
));

$JazzCashAPI = new JazzCashAPI($JazzCashClient);

//Create Checkout Link
function createCheckoutLink($JazzCashAPI){
    try {
        $data = array(
            "amount" => 500,
            "bill_reference" =>  "billRef",
            "description" => "description",
            "date_time" => date("YmdHis"), // Optional - will use current time if not provided
            "order_id" => "", // Optional - Will generate unique ID if not provided
            "transaction_reference" => "", // Optional
            "metafield_1" => "", //Optional Metadata for order
            "metafield_2" => "", //Optional Metadata for order
            "metafield_3" => "", //Optional Metadata for order
            "metafield_4" => "", //Optional Metadata for order
            "metafield_5" => "", //Optional Metadata for order
        );
        $response_type = "redirect"; // redirect / form / data - Defaults to redirect, Redirect will automatically redirect user to payment page, form will return html form with fields and values, data will return array with all values
        $response = $JazzCashAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Dynamic Redirect
function dynamicRedirect($JazzCashAPI){
    try {
        $data = array(
            "amount" => 500,
            "currency" =>  "PKR", // Optional - Will use one set during initializing
            "order_id" => "", // Optional - Will generate unique ID if not provided
        );
        $response_type = "data"; // redirect / data - Defaults to redirect, Redirect will automatically redirect user to payment page, data will return array with all values
        $response = $JazzCashAPI->createCheckoutLink($data, $response_type);
        $JazzCashAPI->dynamicRedirect($response);
        return;
    } catch (TechAndaz\JazzCash\JazzCashException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
echo (createCheckoutLink($JazzCashAPI));
// echo (dynamicRedirect($JazzCashAPI));
?>
