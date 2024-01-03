<?php

namespace TechAndaz\SafePayEmbedded;

class SafePayEmbeddedAPI
{
    private $SafePayEmbeddedClient;

    public function __construct(SafePayEmbeddedClient $SafePayEmbeddedClient)
    {
        $this->SafePayEmbeddedClient = $SafePayEmbeddedClient;
    }

    /**
    * Create Customer
    *
    * @return array
    *   Decoded response data.
    */
    public function createCustomer($data)
    {
        return $this->SafePayEmbeddedClient->createCustomer($data);
    }

    /**
    * Update Customer
    *
    * @return array
    *   Decoded response data.
    */
    public function updateCustomer($data)
    {
        return $this->SafePayEmbeddedClient->updateCustomer($data);
    }

    /**
    * Retrieve Customer
    *
    * @return array
    *   Decoded response data.
    */
    public function retrieveCustomer($token)
    {
        return $this->SafePayEmbeddedClient->retrieveCustomer($token);
    }

    /**
    * Delete Customer
    *
    * @return array
    *   Decoded response data.
    */
    public function deleteCustomer($token)
    {
        return $this->SafePayEmbeddedClient->deleteCustomer($token);
    }

    /**
    * Get All Payment Methods
    *
    * @return array
    *   Decoded response data.
    */
    public function getAllPaymentMethods($token)
    {
        return $this->SafePayEmbeddedClient->getAllPaymentMethods($token);
    }

    /**
    * Get Payment Method
    *
    * @return array
    *   Decoded response data.
    */
    public function getPaymentMethod($token, $payment_token)
    {
        return $this->SafePayEmbeddedClient->getPaymentMethod($token, $payment_token);
    }
    

    /**
    * Delete Payment Method
    *
    * @return array
    *   Decoded response data.
    */
    public function deletePaymentMethod($token, $payment_token)
    {
        return $this->SafePayEmbeddedClient->deletePaymentMethod($token, $payment_token);
    }

    /**
    * Charge Customer
    *
    * @return array
    *   Decoded response data.
    */
    public function chargeCustomer($data)
    {
        return $this->SafePayEmbeddedClient->chargeCustomer($data);
    }
    
    /**
    * Verify Payment Webhook
    *
    * @return array
    *   Decoded response data.
    */
    public function verifyPayment()
    {
        return $this->SafePayEmbeddedClient->verifyPayment();
    }

    
    /**
    * Verify Payment Secured Webhook
    *
    * @return array
    *   Decoded response data.
    */
    public function verifyPaymentSecured()
    {
        return $this->SafePayEmbeddedClient->verifyPaymentSecured();
    }
}
