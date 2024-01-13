<?php

namespace App\Library;


class PhonePe
{

    protected $params      = [];
    public $_url;
    protected $environment = 'sandbox';


    function __construct($environment)
    {
        $this->environment = $environment;

        if ($this->environment == 'sandbox') {
            $this->_url = 'https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/pay';
        } else {
            $this->_url = 'https://api.phonepe.com/apis/hermes/pg/v1/pay';
        }
        $this->param('service_provider', 'phonepe');
    }

    public function param($param, $value)
    {
        $this->params["$param"] = $value;
    }
    public function getRequestJson($data, $totalAmount = null)
    {
        // dd($data, '- $data');
        $credentials = $data['credentials'];
        $plan = $data['plan'];
        $user = $data['user'];
        $paymentMethod = $data['paymentMethod'];
        $merchantTransactionIdNumber = rand(1000000, 10000000000);

        if(!$totalAmount){
            $totalAddonsPrice = ($data['totalAddons'] * $plan->connection_addons_price) * $data['totalFrequencyDuration'];
            $totalPlanPrice = $plan->price * $data['totalFrequencyDuration'];
            $totalAmount = $totalAddonsPrice + $totalPlanPrice;
        }
        // $requestJson ='{
        //     "merchantId": "'.$credentials->merchant_key.'",
        //     "merchantTransactionId": "MT'.$merchantTransactionIdNumber.'",
        //     "merchantUserId": "'.$user->uid.'",
        //     "amount": '.($plan->price * 100).',
        //     "redirectUrl": "'.route('user.registers.payment_success', ['user' => $user->uid, 'plan' => $plan->uid, 'payment_method' => $paymentMethod->uid]).'",
        //     "redirectMode": "POST",
        //     "callbackUrl": "'.route('user.registers.payment_success', ['user' => $user->uid, 'plan' => $plan->uid, 'payment_method' => $paymentMethod->uid]).'",
        //     "mobileNumber": "'.$user->customer->phone.'",
        //     "paymentInstrument": {
        //         "type": "PAY_PAGE"
        //         }
        // }'; 
        $requestJson = '{
            "merchantId": "' . $credentials->merchant_key . '",
            "merchantTransactionId": "MT' . $merchantTransactionIdNumber . '",
            "merchantUserId": "' . $user->uid . '",
            "amount": ' . ($totalAmount * 100) . ',
            "redirectUrl": "' . route('user.registers.payment_success', ['user' => $user->uid, 'plan' => $plan->uid, 'payment_method' => $paymentMethod->uid]) . '",
            "redirectMode": "POST",
            "callbackUrl": "' . route('user.registers.payment_success', ['user' => $user->uid, 'plan' => $plan->uid, 'payment_method' => $paymentMethod->uid]) . '",
            "mobileNumber": "' . $user->customer->phone . '",
            "paymentInstrument": {
                "type": "PAY_PAGE"
                }
        }';
        return $requestJson;
    }
}
