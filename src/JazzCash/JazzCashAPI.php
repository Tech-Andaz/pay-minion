<?php

namespace TechAndaz\JazzCash;

class JazzCashAPI
{
    private $JazzCashClient;
    private $callback_url;

    public function __construct(JazzCashClient $JazzCashClient)
    {
        $this->JazzCashClient = $JazzCashClient;
    }
    /**
    * Create Checkout Link
    *
    * @return array
    *   Decoded response data.
    */
    public function createCheckoutLink($order, $response_type = "redirect"){
        if((!isset($order['amount']) || $order['amount'] == "")){
            throw new JazzCashException("Transaction Amount is missing.");
        }
        if (!is_numeric($order['amount']) || filter_var($order['amount'], FILTER_VALIDATE_FLOAT) === false) {
            throw new JazzCashException("Transaction Amount must be a number or float.");
        }
        $order['amount'] = $order['amount'] * 100;
        $order['transaction_reference'] = (isset($order['transaction_reference']) && $order['transaction_reference'] != "") ? $this->JazzCashClient->domain_code . $order['transaction_reference'] : $this->JazzCashClient->domain_code . date('YmdHis') . mt_rand(10, 100);;
        if(strlen($order['transaction_reference']) > 20 || strlen($order['transaction_reference']) <= 0){
            throw new JazzCashException("Transaction Reference must be a maximum of 20 characters, can not be empty & must be unique");
        }
        $order['order_id'] = (isset($order['order_id']) && $order['order_id'] != "") ? $order['order_id'] : uniqid();
        $order['date_time'] = (isset($order['date_time']) && $order['date_time'] != "") ? $order['date_time'] : date("Ymdhis");
        $order['expiry_time'] = date('Ymdhis', strtotime($order['date_time'] . ' +1 day'));
        $order['bill_reference'] = (isset($order['bill_reference']) && $order['bill_reference'] != "") ? $order['bill_reference'] : "";
        
        $order['description'] = (isset($order['description']) && $order['description'] != "") ? $order['description'] : "";
        $order['metafield_1'] = (isset($order['metafield_1']) && $order['metafield_1'] != "") ? $order['metafield_1'] : "";
        $order['metafield_2'] = (isset($order['metafield_2']) && $order['metafield_2'] != "") ? $order['metafield_2'] : "";
        $order['metafield_3'] = (isset($order['metafield_3']) && $order['metafield_3'] != "") ? $order['metafield_3'] : "";
        $order['metafield_4'] = (isset($order['metafield_4']) && $order['metafield_4'] != "") ? $order['metafield_4'] : "";
        $order['metafield_5'] = (isset($order['metafield_5']) && $order['metafield_5'] != "") ? $order['metafield_5'] : "";
        $order['bank_id'] =  "";
        $order['registered_user'] =  "No";
        $order['language'] =  "EN";
        $order['currency'] =  "PKR";
        $order['product_id'] =  "";
        $order['transaction_type'] =  "";
        $order['version'] =  "2.0";
        $order['sub_merchant_id'] =  "";

        $hash_data = array(
            $order['amount'],
            $order['bank_id'],
            $order['bill_reference'],
            $order['description'],
            $order['registered_user'],
            $order['language'],
            $this->JazzCashClient->merchant_id,
            $this->JazzCashClient->password,
            $order['product_id'],
            $this->JazzCashClient->return_url,
            $order['currency'],
            $order['date_time'],
            $order['expiry_time'],
            $order['transaction_reference'],
            $order['transaction_type'],
            $order['version'],
            $order['metafield_1'],
            $order['metafield_2'],
            $order['metafield_3'],
            $order['metafield_4'],
            $order['metafield_5'],
        );
        $sorted_hash = $this->JazzCashClient->integerity_salt;
        for ($i = 0; $i < count($hash_data); $i++) {
            if ($hash_data[$i] != 'undefined' and $hash_data[$i] != null and $hash_data[$i] != "") {
                $sorted_hash .= "&" . $hash_data[$i];
            }
        }
        $secure_hash = hash_hmac('sha256', $sorted_hash, $this->JazzCashClient->integerity_salt);
        if($response_type == "form"){
            return $this->generateForm($order, $secure_hash);
        } else if($response_type == "redirect"){
            $form = $this->generateForm($order, $secure_hash);
            $form .= '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("payment_form_jazzcash").submit();
                });
            </script>';
            echo $form;
            return;
        }
    }
    public function generateForm($order, $secure_hash){
        $form = '<form action="' . $this->JazzCashClient->api_url . '" id="payment_form_jazzcash" method="post" novalidate="novalidate" style = "display:none;">                                                              
            <input id="pp_Version" name="pp_Version" type="hidden" value="' . $order['version'] . '">                                                                                                                                
            <input id="pp_TxnType" name="pp_TxnType" type="hidden" value="' . $order['transaction_type'] . '">                                                                                                                            
            <input id="pp_Language" name="pp_Language" type="hidden" value="' . $order['language'] . '">                                                                                                                            
            <input id="pp_MerchantID" name="pp_MerchantID" type="hidden" value="' . $this->JazzCashClient->merchant_id . '">                                                                                                                               
            <input id="pp_SubMerchantID" name="pp_SubMerchantID" type="hidden" value="' . $order['sub_merchant_id'] . '">                                                                                     
            <input id="pp_Password" name="pp_Password" type="hidden" value="' . $this->JazzCashClient->password . '">                                                                            
            <input id="pp_TxnRefNo" name="pp_TxnRefNo" type="hidden" value="' . $order['transaction_reference'] . '">                                                                                                                           
            <input id="pp_Amount" name="pp_Amount" type="hidden" value="' . $order['amount'] . '">                                                                                                                     
            <input id="pp_TxnCurrency" name="pp_TxnCurrency" type="hidden" value="' . $order['currency'] . '">                                  
            <input id="pp_TxnDateTime" name="pp_TxnDateTime" type="hidden" value="' . $order['date_time'] . '">                                                                                                            
            <input id="pp_BillReference" name="pp_BillReference" type="hidden" value="' . $order['bill_reference'] . '">  
            <input id="pp_Description" name="pp_Description" type="hidden" value="' . $order['description'] . '">           
            <input id="pp_IsRegisteredCustomer" name="pp_IsRegisteredCustomer" type="hidden" value="' . $order['registered_user'] . '">      
            <input id="pp_BankID" name="pp_BankID" type="hidden" value="' . $order['bank_id'] . '">      
            <input id="pp_ProductID" name="pp_ProductID" type="hidden" value="' . $order['product_id'] . '">      
            <input id="pp_TxnExpiryDateTime" name="pp_TxnExpiryDateTime" type="hidden" value="' . $order['expiry_time'] . '">      
            <input id="pp_ReturnURL" name="pp_ReturnURL" type="hidden" value="' . $this->JazzCashClient->return_url . '">      
            <input id="pp_SecureHash" name="pp_SecureHash" type="hidden" value="' . $secure_hash . '">      
            <input id="ppmpf_1" name="ppmpf_1" type="hidden" value="' . $order['metafield_1'] . '">        
            <input id="ppmpf_2" name="ppmpf_2" type="hidden" value="' . $order['metafield_2'] . '">       
            <input id="ppmpf_3" name="ppmpf_3" type="hidden" value="' . $order['metafield_3'] . '">       
            <input id="ppmpf_4" name="ppmpf_4" type="hidden" value="' . $order['metafield_4'] . '">       
            <input id="ppmpf_5" name="ppmpf_5" type="hidden" value="' . $order['metafield_5'] . '">     
            <input type="SUBMIT" value="SUBMIT">                                                                    
        </form>';
        return $form;
    }
    public function processResponse(){
        if(!isset($_POST['pp_ResponseCode']) || $_POST['pp_ResponseCode'] == ""){
            $_POST['pp_ResponseCode'] = "0";
        }
        if(!isset($_POST['pp_ResponseMessage']) || $_POST['pp_ResponseMessage'] == ""){
            $_POST['pp_ResponseMessage'] = "There was an unknown error with your transaction";
        }
        return array(
            "status" => $_POST['pp_ResponseCode'],
            "message" => $_POST['pp_ResponseMessage'],
            "data" => $_POST
        );
    }
}
