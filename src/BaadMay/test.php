<?php

require 'vendor/autoload.php';

use TechAndaz\BaadMay\BaadMayClient;
use TechAndaz\BaadMay\BaadMayAPI;

$BaadMayClient = new BaadMayClient(array(
    "environment" => "sandbox", //Optional - Defaults to production. Options are sandbox/production
    "api_key" => "6ae4a3ee-3dc5-4da1-97cf-329c9b9b804d",
    "success_url" => "", // Optional either set here or during checkout
    "failure_url" => "", // Optional either set here or during checkout
));

$BaadMayAPI = new BaadMayAPI($BaadMayClient);

//Create Checkout Link
function createCheckoutLink($BaadMayAPI){
    try {
        $data = array(
            "amount" => 25.30,
            "order_id" => "", // Optional - leave empty for auto generated
            "items" => array(
                array(
                    "item_id" => "1234",
                    "sku" => "1234",
                    "name" => "Test Product",
                    "qty" => 1,
                    "price" => 100
                )
            ),
            "customer" => array(
                "first_name" => "Tech",
                "last_name" => "Andaz",
                "address" => array(
                    "Street 1",
                    "Street 2"
                ),
                "city" => "Lahore",
                "state" => "Punjab",
                "postcode" => "54000",
                "phone" => "04235113700",
                "email" => "contact@techandaz.com",
            ),
            "billing" => array(
                "first_name" => "Tech",
                "last_name" => "Andaz",
                "address" => array(
                    "Street 1",
                    "Street 2"
                ),
                "city" => "Lahore",
                "state" => "Punjab",
                "postcode" => "54000",
                "phone" => "04235113700",
                "email" => "contact@techandaz.com",
            ),
            "shipping" => array(
                "method" => "Standard Shipping",
                "cost" => 50,
                "first_name" => "Tech",
                "last_name" => "Andaz",
                "address" => array(
                    "Street 1",
                    "Street 2"
                ),
                "city" => "Lahore",
                "state" => "Punjab",
                "postcode" => "54000",
                "phone" => "04235113700",
                "email" => "contact@techandaz.com",
            ),
            "success_url" => "https://techandaz.com/success", // Optional if set during client initialization
            "failure_url" => "https://techandaz.com/failure", // Optional if set during client initialization
        );
        $response_type = "redirect"; // redirect / response - Defaults to redirect, Redirect will automatically redirect user to payment page, response will return response
        $response = $BaadMayAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\BaadMay\BaadMayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
//Get Order Status
function getOrderStatus($BaadMayAPI){
    try {
        $order_id = "123456789";
        $response = $BaadMayAPI->getOrderStatus($order_id);
        return $response;
    } catch (TechAndaz\BaadMay\BaadMayException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(createCheckoutLink($BaadMayAPI));
// echo json_encode(getOrderStatus($BaadMayAPI));
?>
