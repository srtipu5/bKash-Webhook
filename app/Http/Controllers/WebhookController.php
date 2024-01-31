<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct()
    {
    }

    function writeLog($logName, $logData)
    {
        Log::info($logName, $logData);
    }

    public function get_content($URL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $URL);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function getStringToSign($message)
    {
        $signableKeys = [
            'Message',
            'MessageId',
            'Subject',
            'SubscribeURL',
            'Timestamp',
            'Token',
            'TopicArn',
            'Type'
        ];

        $stringToSign = '';

        if ($message['SignatureVersion'] !== '1') {
            $errorLog =  "The SignatureVersion \"{$message['SignatureVersion']}\" is not supported.";
            $this->writeLog('SignatureVersion-Error', $errorLog);
        }
        else{
            foreach ($signableKeys as $key) {
                if (isset($message[$key])) {
                    if (is_array($message[$key])) {
                        $stringToSign .= "{$key}\n" . implode("\n", $message[$key]) . "\n";
                    } else {
                        $stringToSign .= "{$key}\n{$message[$key]}\n";
                    }
                }
            }
            
            $this->writeLog('StringToSign', [$stringToSign]);
        }
        return $stringToSign;
    }
    function validateUrl($url)
    {
        $defaultHostPattern = '/^sns\.[a-zA-Z0-9\-]{3,}\.amazonaws\.com(\.cn)?$/';
        $parsed = parse_url($url);

        if (empty($parsed['scheme']) || empty($parsed['host']) || $parsed['scheme'] !== 'https' || substr($url, -4) !== '.pem' || !preg_match($defaultHostPattern, $parsed['host'])) {
            return false;
        } else {
            return true;
        }
    }

    function webhookListener(Request $request)
    {
        //payload
        $payload = json_decode($request->getContent(), true);
        //return $payload;
        $this->writeLog('Payload', $payload);

        //verify signature
        $signingCertURL = $payload['SigningCertURL'];
        $certUrlValidation = $this->validateUrl($signingCertURL);

        if ($certUrlValidation) {
            $pubCert = $this->get_content($signingCertURL);
            $signature = $payload['Signature'];
            $signatureDecoded = base64_decode($signature);
            $content = $this->getStringToSign($payload);

            // Get Message Type
            $messageType = $payload['Type'];
           // return $messageType;

            if ($content) {
                $verified = 1;
                try {
                    $verified = openssl_verify($content, $signatureDecoded, $pubCert, OPENSSL_ALGO_SHA1);
                } catch (\Exception $e) {
                    $this->writeLog('Openssl_error', ["message" => $e]);
                    return "openssl_verify Exception";
                }

                if ($verified == 1) {
                    if ($messageType == "SubscriptionConfirmation") {
                        $subscribeURL = $payload['SubscribeURL'];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $subscribeURL);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        $this->writeLog('Subscribe-Result', [$response]);

                    } else if ($messageType == "Notification") {

                        $notificationData = $payload['Message'];
                        // save notificationData in your DB
                        $this->writeLog('NotificationData-Message', [$notificationData]);

                    }
                }
            }

        }

    }

}
