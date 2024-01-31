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

    function get_content($URL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $URL);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function getStringToSign($message)
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
            $errorLog = "The SignatureVersion \"{$message['SignatureVersion']}\" is not supported.";
            $this->writeLog('SignatureVersion-Error', array($errorLog));
        } else {
            foreach ($signableKeys as $key) {
                if (isset($message[$key])) {
                    $stringToSign .= "{$key}\n{$message[$key]}\n";
                }
            }
            $this->writeLog('StringToSign', array($stringToSign));
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
        $this->writeLog('Payload', $payload);

        //verify signature
        $signingCertURL = $payload['SigningCertURL'];
        $certUrlValidation = $this->validateUrl($signingCertURL);

        if ($certUrlValidation == '1') {
            $pubCert = $this->get_content($signingCertURL);

            $signature = $payload['Signature'];
            $signatureDecoded = base64_decode($signature);
            $content = $this->getStringToSign($payload);

            // Get Message Type
            $messageType = $payload['Type'];

            if ($content != '') {
                $verified = openssl_verify($content, $signatureDecoded, $pubCert, OPENSSL_ALGO_SHA1);
                if ($verified == 1) {
                    if ($messageType == "SubscriptionConfirmation") {
                        $subscribeURL = $payload['SubscribeURL'];

                        $ch = curl_init();
                        // Set the cURL options
                        curl_setopt($ch, CURLOPT_URL, $subscribeURL);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        $this->writeLog('Subscribe-Result', array($response));

                    } else if ($messageType == "Notification") {

                        $notificationData = $payload['Message'];
                        // save notificationData in your DB
                        $this->writeLog('NotificationData-Message', array($notificationData));

                    }
                }
            }

        }

    }

}
