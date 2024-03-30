<?php

require 'vendor/autoload.php';

use TechAndaz\UBL\UBLClient;
use TechAndaz\UBL\UBLAPI;

$UBLClient = new UBLClient(array(
    "api_url" =>"https://demo-ipg.ctdev.comtrust.ae:2443/", // Optional - Defaults to Production URL
    "customer" => "Demo Merchant", // Optional - Defaults to Pay Minion
    "store" =>  "0000", // Optional - Defaults to 0000
    "terminal" =>  "0000", // Optional - Defaults to 0000
    "channel" =>  "Web", // Optional - Defaults to Web
    "currency" =>  "PKR", // Optional - Defaults to PKR
    "transaction_hint" =>  "CPT:Y", // Optional - Defaults to CPT:Y. Options are: CPT:N (Authorize, capture to be called seperate). CPT:Y (Capture)
    "callback_url" =>  "https://techandaz.com/success", // Required/Optional - Must be provided either during initialize or during checkout link creation.
    "username" => "Demo_fY9c",
    "password" => "Comtrust@20182018",
));
$UBLAPI = new UBLAPI($UBLClient);

//Create Checkout Link
function createCheckoutLink($UBLAPI){
    try {
        $data = array(
            "Customer" => "", // Optional - Will use default or value set during initialize. Will override if provided
            "Store" => "", // Optional - Will use default or value set during initialize. Will override if provided
            "Terminal" => "", // Optional - Will use default or value set during initialize. Will override if provided
            "Channel" => "", // Optional - Will use default or value set during initialize. Will override if provided
            "Currency" => "", // Optional - Will use default or value set during initialize. Will override if provided
            "OrderID" => "", // Optional - Will generate unique ID if not provided
            "OrderInfo" => "", // Optional
            "TransactionHint" => "", // Optional - Will use default or value set during initialize. Will override if provided
            "ReturnPath" => "", // Required / Optional - Will use value set during initialize if not provided. If both not provided will throw error
            "UserName" => "", // Optional - Will use value provided during initialize or over ride if provided
            "Password" => "", // Optional - Will use value provided during initialize or over ride if provided
            "Amount" => 5000,
            "OrderName" => "Order from Tech Andaz",
        );
        $response = $UBLAPI->createCheckoutLink($data, "redirect"); //Optional - Will use "data" as type if nothing provided. Options are: "data" or "redirect"
        return $response;
    } catch (TechAndaz\UBL\UBLException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Form Fields
function getFormFields($UBLAPI){
    try { 
        $config = array(
            "response" => "form",
            "label_class" => "form-label",
            "input_class" => "form-control",
            "wrappers" => array(
                "Amount" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "OrderName" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
            ),
            "optional" => false,
            "optional_selective" => array(
            ),
        );
        $response = $UBLAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\UBL\UBLException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
echo json_encode(createCheckoutLink($UBLAPI));
// echo (getFormFields($UBLAPI));
?>
