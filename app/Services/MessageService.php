<?php

namespace App\Services;

use App\Models\SmsHistory;

class MessageService
{
    public function email($email, $text)
    {
        try {
            \Mail::send('general.notifications.email',
                array(
                    'text' => $text,
                ), function($message) use ($email)
                {
                    $message->from('info@phpweb.ge', env('APP_NAME'));
                    $message->subject('შვებულების მოთხოვნა');
                    $message->to($email);
                });
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function sms($destination, $text)
    {
        $apiKey = config('wifisher.key');
        $sender = config('wifisher.sender');
        preg_match_all('!\d+!', $destination, $matches);
        $to = implode($matches[0]);

        if (substr($to, 0, 3) != '995') {
            $to = '995' . $to;
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('wifisher.url').'/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('from' => $sender,'to' => $to,'content' => $text),
            CURLOPT_HTTPHEADER => array(
                'api-key: '.$apiKey
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $json = json_decode($response,true);
        //errorSendTelegram($response);
//        return $json;
        if(isset($json['data']) && $json['status'] == 200){
            SmsHistory::create([
                'phone' => $to,
                'message_id' => $json['data']['client_id'],
                'message' => $text
            ]);
        }
        return $response;
    }
}
