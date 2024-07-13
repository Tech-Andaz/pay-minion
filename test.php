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
    "return_url" => "https://portal.techandaz.com/payments/jazzcash/response",
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
echo (createCheckoutLink($JazzCashAPI));
// echo (processResponse($JazzCashAPI));
?>
