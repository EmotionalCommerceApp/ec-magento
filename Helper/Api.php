<?php
namespace Ec\Qr\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Api extends AbstractHelper
{

    const API_URL = 'localhost:8000';


    public function getCampaigns($key, $secret, $domain)
    {
        $headers =  array(
          'Accept: application/json',
          'Content-Type: application/json',
          'key: '.$key,
          'secret: '.$secret,
        );

        $regUrl = $domain. '.' . self::API_URL."/api/campaigns";

        $regCurl = curl_init($regUrl);
        curl_setopt($regCurl, CURLOPT_POST, 0);
        curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
          $regCurl,
          CURLOPT_HTTPHEADER,
          $headers
        );
        $regResult = json_decode(curl_exec($regCurl));
        $statusCode = curl_getinfo($regCurl, CURLINFO_HTTP_CODE);
        curl_close($regCurl);

        if ($statusCode != 200) {
            return [
                'success' => false,
                'message' => $regResult->message,
            ];
        }

        $campaigns = [];

        foreach ($regResult->data as $campaign) {
            $campaigns[] = [
                'name' => $campaign->name,
                'id' => $campaign->id,
            ];
        }

        while ($regResult->next_page_url) {
            $regCurl = curl_init($regResult->next_page_url);
            curl_setopt($regCurl, CURLOPT_POST, 0);
            curl_setopt($regCurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(
                $regCurl,
                CURLOPT_HTTPHEADER,
                $headers
            );
            $regResult = json_decode(curl_exec($regCurl));

            foreach ($regResult->data as $campaign) {
                $campaigns[] = [
                    'name' => $campaign->name,
                    'id' => $campaign->id,
                ];
            }
            curl_close($regCurl);
        }

        return [
            'success' => true,
            'data' => $campaigns,
        ];

    }

}
