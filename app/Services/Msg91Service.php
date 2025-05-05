<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Msg91Service
{
    protected $authKey;
    protected $senderId;
    protected $route;
    protected $country;

    public function __construct()
    {
        $this->authKey = config('services.msg91.auth_key');
        $this->senderId = config('services.msg91.sender_id');
        $this->route = config('services.msg91.route');
        $this->country = config('services.msg91.country');
    }

    public function sendOtp($mobile, $otp)
    {
        $response = Http::get("https://control.msg91.com/api/v5/otp", [
            'authkey'   => $this->authKey,
            'mobile'    => $mobile,
            'otp'       => $otp,
            'sender'    => $this->senderId,
            'country'   => $this->country,
        ]);

        return $response->json();
    }

    public function verifyOtp($mobile, $otp)
    {
        $response = Http::get("https://control.msg91.com/api/v5/otp/verify", [
            'authkey'   => $this->authKey,
            'mobile'    => $mobile,
            'otp'       => $otp,
        ]);

        return $response->json();
    }
}
