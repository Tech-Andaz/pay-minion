
## Usage Guide - Safe Pay Embedded
## Table of Contents
- [Initialize Safe Pay Embedded Client](#initialize)
- [Create Customer](#create-customer)
- [Update Customer](#update-customer)
- [Retrieve Customer](#retrieve-customer)
- [Delete Customer](#delete-customer)
- [Add Card](#add-card)
- [Get All Payment Methods](#get-all-payment-methods)
- [Get Payment Method](#get-payment-method)
- [Delete Payment Method](#delete-payment-method)
- [Charge Customer](#charge-customer)
- [Verify Payment Webhook](#verify-payment-webhook)
- [Verify Payment Webhook Secured](#verify-payment-webhook-secured)
## Initialize
```php
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
?>
```
## Create Customer
```php
<?php
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
?>
```
## Update Customer
```php
<?php
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
?>
```
## Retrieve Customer
```php
<?php
try {
    $token = "cus_46f52953-a2fa-48b7-beaf-d3449ba860eb";
    $response = $SafePayEmbeddedAPI->retrieveCustomer($token);
    return $response;
} catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Delete Customer
```php
<?php
try {
    $token = "cus_46f52953-a2fa-48b7-beaf-d3449ba860eb";
    $response = $SafePayEmbeddedAPI->deleteCustomer($token);
    return $response;
} catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Add Card
```php
<?php
try {
    $token = "cus_ef212de4-7b68-43ab-8fd6-2e9de8e2c0b3";
    $type = "redirect"; // Optional - Defaults to redirect. options are: url / redirect
    $response = $SafePayEmbeddedAPI->getCardVaultURL($token, $type);
    return $response;
} catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get All Payment Methods
```php
<?php
try {
    $token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
    $response = $SafePayEmbeddedAPI->getAllPaymentMethods($token);
    return $response;
} catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Get Payment Method
```php
<?php
try {
    $token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
    $payment_token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
    $response = $SafePayEmbeddedAPI->getPaymentMethod($token, $payment_token);
    return $response;
} catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Delete Payment Method
```php
<?php
try {
    $token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
    $payment_token = "cus_6d5f1748-1961-4bea-86e7-c19b0223f07d";
    $response = $SafePayEmbeddedAPI->deletePaymentMethod($token, $payment_token);
    return $response;
} catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Charge Customer
```php
<?php
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
?>
```
## Verify Payment Webhook
```php
<?php
try {
    $response = $SafePayEmbeddedAPI->verifyPayment();
    return $response;
} catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```
## Verify Payment Webhook Secured
```php
<?php
try {
    $response = $SafePayEmbeddedAPI->verifyPaymentSecured();
    return $response;
} catch (TechAndaz\SafePayEmbedded\SafePayEmbeddedException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
```