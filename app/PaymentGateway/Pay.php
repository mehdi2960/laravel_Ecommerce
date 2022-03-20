<?php

namespace App\PaymentGateway;

class Pay extends Payment
{
    public function send($amounts, $addressId)
    {
        $api = 'test';
        $amount = $amounts['paying_amount'] . '0';
        $redirect = route('home.payment_verify' , ['gatewayName' => 'pay']);
        $result = $this->sendRequest($api, $amount, $redirect);
        $result = json_decode($result);
        if ($result->status) {

            $createOrder = parent::createOrder($addressId, $amounts, $result->token, 'pay');
            if (array_key_exists('error', $createOrder)) {
                return $createOrder;
            }

            $go = "https://pay.ir/pg/$result->token";
            return ['success' => $go];
        } else {
            return ['error' => $result->errorMessage];
        }
    }

    public function verify($token , $status)
    {
        $api = 'test';
        $token = $token;
        $result = json_decode($this->verifyRequest($api, $token));
        if (isset($result->status)) {
            if ($result->status == 1) {
                $updateOrder = parent::updateOrder($token, $result->transId);
                if (array_key_exists('error', $updateOrder)) {
                    return $updateOrder;
                }
                \Cart::clear();
                return ['success' => ' پرداخت با موفقیت انجام شد.شماره تراکنش' . $result->transId];
            } else {
                return ['error' => 'پرداخت با خطا مواجه شد.شماره وضعیت' . $result->status];
            }
        } else {
            if ($status == 0) {
                return ['error' => 'پرداخت با خطا مواجه شد.شماره وضعیت' . $status];
            }
        }
    }

    public function sendRequest($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api'          => $api,
            'amount'       => $amount,
            'redirect'     => $redirect,
            'mobile'       => $mobile,
            'factorNumber' => $factorNumber,
            'description'  => $description,
        ]);
    }

    public function verifyRequest($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api'     => $api,
            'token' => $token,
        ]);
    }

    public function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}

