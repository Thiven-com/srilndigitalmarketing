<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlanApiService
{
    private $baseUrl = 'https://planapi.in/Api/';
    private $apiUserId = '7364';
    private $apiPassword = '112233';
    private $tokenId = '0a233507-01bc-434a-944c-34f04075b146';

    /**
     * Common API Caller
     */
    private function callApi($endpoint, $payload = [])
    {
        $url = $this->baseUrl . $endpoint;

        $response = Http::withHeaders([
            'ApiUserID' => $this->apiUserId,
            'ApiPassword' => $this->apiPassword,
            'TokenID' => $this->tokenId,
            'Content-Type' => 'application/json'
        ])->asForm()->withOptions([
                    'curl' => [
                        CURLOPT_SSL_OPTIONS => CURLSSLOPT_NATIVE_CA,
                    ],
                ])
            ->post($url, $payload);
        Log::info($response->json());
        return $response->json();
    }


    /**
     * 🔍 UPI Verification
     */
    public function verifyUpi($upiId)
    {
        $payload = [
            'UpiId' => $upiId,
            'ApiMode' => 1,
        ];

        return $this->callApi('Ekyc/UpiVerification', $payload);
    }

    /**
     * 🏦 Bank Verification
     */
    public function verifyBank($accountNo, $ifsc)
    {
        $payload = [
            'AccountNo' => $accountNo,
            'Ifsc' => $ifsc,
            'ApiMode' => 1,
        ];

        return $this->callApi('Ekyc/BankVarification', $payload);
    }
    /**
     * 🏦 PAN Verification
     */
    public function verifyPan($accountNo)
    {
        $payload = [
            'Panid' => $accountNo,
            'ApiMode' => 1,
        ];

        return $this->callApi('Ekyc/PanVerification', $payload);
    }

    /**
     * 🪪 Aadhaar Verification - Send OTP
     */
    public function verifyAadhaar($aadhaarNo)
    {
        $aadhaarNo = preg_replace('/\D/', '', $aadhaarNo);

        $payload = [
            'Aadhaarid' => $aadhaarNo,
            'ApiMode' => 1,
        ];

        Log::info('Aadhaar Send OTP Request', [
            'aadhaar' => substr($aadhaarNo, 0, 4) . 'XXXXXXXX',
            'payload' => [
                'Aadhaarid' => substr($aadhaarNo, 0, 4) . 'XXXXXXXX',
                'ApiMode' => 1,
            ],
        ]);

        return $this->callApi(
            'Ekyc/AdharVerification',
            $payload
        );
    }


    /**
     * 🪪 Aadhaar Verification - Submit OTP
     */
    public function verifyAadhaarOtp($aadhaarNo, $otp, $reqId)
    {
        $payload = [
            'Aadhaarid' => $aadhaarNo,
            'OTP' => $otp,
            'ReqId' => $reqId,
            'ApiMode' => 1,
        ];

        return $this->callApi(
            'Ekyc/AdharVerificationSubmitOtp',
            $payload
        );
    }

}
