<?php

require 'vendor/autoload.php';

use TechAndaz\AlfalahIPG\AlfalahIPGClient;
use TechAndaz\AlfalahIPG\AlfalahIPGAPI;

$AlfalahIPGClient = new AlfalahIPGClient(array(
    "environment" =>"sandbox", // Optional - Defaults to production. Options are: sandbox / production
    "merchant_id" => "TESTBAFL_TEST58",
    "merchant_name" =>  "Pay Minion",
    "password" =>  "3b347fee72a340f88601a9423bb2b898",
    "operator_id" =>  "TESTALFATAH",  // Optional
    "api_key" =>  "Bafl&2143", // Optional 
    "return_url" =>  "https://techandaz.com/success", // Required/Optional - Must be provided either during initialize or during checkout link creation.
    "transaction_type" =>"PURCHASE", // Optional - Defaults to PURCHASE. Options are: PURCHASE / AUTHORIZE / VERIFY / NONE
    "currency_code" =>  "PKR",
));

$AlfalahIPGAPI = new AlfalahIPGAPI($AlfalahIPGClient);

//Create Checkout Link
function createCheckoutLink($AlfalahIPGAPI){
    try {
        $data = array(
            "amount" => 500,
            "order_id" => "", // Optional - Will generate unique ID if not provided
            "currency_code" =>  "PKR", // Optional - Will use one set during initializing
            "description" => "Test Order",
            "return_url" =>  "https://techandaz.com/success", // Optional - Will use one set during initializing
            "transaction_type" => "PURCHASE", // Optional - will use one set during initializing
            // Use this to provide more data into the checkout intiation. Details can be found on official documentation
            "data" => array(
                "billing" => array(
                    "address" => array(
                        "city" => 'Lahore',
                        "company" => 'Tech Andaz',
                        "country" => 'PAK',
                        "postcodeZip" => '54000',
                        "stateProvince" => 'Punjab',
                        "street" => '119/2 M Quaid-e-Azam Industrial Estate',
                        "street2" => 'Kot Lakhpat, Township',
                    )
                ),
                "customer" => array(
                    "account" => array(
                        "id" => '12345',
                    ),
                    "email" => 'test@test.com',
                    "firstName" => 'Tech',
                    "lastName" => 'Andaz',
                    "mobilePhone" => '+924235113700',
                    "phone" => '+924235113700',
                    "taxRegistrationId" => '123456',
                ),
                "interaction" => array(
                    "cancelUrl" => "https://techandaz.com/cancel",
                    "merchant" => array(
                        "logo" => "https://techandaz.com/images/logo.png",
                        "name" => "Tech Andaz",
                        "url" => "https://techandaz.com"
                    ),
                    "timeout" => 1800
                ),
                "order" => array(
                    "notificationUrl" => "https://techandaz.com/webhook",
                    "item" => array(
                        array(
                            "name" => "Test Product",
                            "quantity" => 1,
                            "unitPrice" => 100,
                        ),
                        array(
                            "name" => "Test Product2",
                            "quantity" => 4,
                            "unitPrice" => 100,
                        ),
                    )
                )
            ), // Use this to provide more data into the checkout intiation. Details can be found on official documentation
        );
        $response_type = "data"; // redirect / data - Defaults to redirect, Redirect will automatically redirect user to payment page, data will return array with all values
        $response = $AlfalahIPGAPI->createCheckoutLink($data, $response_type);
        return $response;
    } catch (TechAndaz\AlfalahIPG\AlfalahIPGException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Dynamic Redirect
function dynamicRedirect($AlfalahIPGAPI){
    try {
        $data = array(
            "amount" => 500,
            "description" => "Test Order",
        );
        $response_type = "data"; // redirect / data - Defaults to redirect, Redirect will automatically redirect user to payment page, data will return array with all values
        $response = $AlfalahIPGAPI->createCheckoutLink($data, $response_type);
        $access_token = $response['access_token'];
        $success_indicator = $response['success_indicator'];
        $AlfalahIPGAPI->dynamicRedirect($access_token);
        return;
    } catch (TechAndaz\AlfalahIPG\AlfalahIPGException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

//Get Form Fields
function getFormFields($AlfalahIPGAPI){
    try { 
        $config = array(
            "response" => "form",
            "label_class" => "form-label",
            "input_class" => "form-control",
            "wrappers" => array(
                "CUSTOMER_EMAIL_ADDRESS" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "CUSTOMER_MOBILE_NO" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "TXNAMT" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "BASKET_ID" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
                "ORDER_DATE" => array(
                    "input_wrapper_start" => '<div class="mb-3 col-md-6">',
                    "input_wrapper_end" => "</div>"
                ),
            ),
            "optional" => false,
            "optional_selective" => array(
            ),
        );
        $response = $AlfalahIPGAPI->getFormFields($config);
        return $response;
    } catch (TechAndaz\AlfalahIPG\AlfalahIPGException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
// echo json_encode(createCheckoutLink($AlfalahIPGAPI));
echo (dynamicRedirect($AlfalahIPGAPI));
// echo (getFormFields($AlfalahIPGAPI));
?>
