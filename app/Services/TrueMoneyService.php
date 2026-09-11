<?php
namespace App\Services;

class TrueMoneyService {
    private string $apiKey = 'inwcloud_live_6ed435f82c6d426e52a7dfa8391975e946345022';

    public function redeemVoucher(string $voucherUrl): array {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.inwcloud.shop/v1/truemoney/voucher',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "voucher_url" => trim($voucherUrl)
            ]),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json'
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return ['status' => false, 'message' => 'cURL Error #: ' . $err];
        }

        return json_decode($response, true) ?? ['status' => false, 'message' => 'การเชื่อมต่อ API ผิดพลาด'];
    }
}
