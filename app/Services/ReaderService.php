<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class ReaderService
{
    protected ?string $ip;
    protected ?int $port;

    public function __construct()
    {
        $this->ip = '92.241.70.166';
        $this->port = 7777;
    }

    public function checkReaderConnection()
    {
        $timeout = 5;
        try {
            $socket = @fsockopen($this->ip, $this->port, $errno, $errstr, $timeout);

            if (!$socket) {
                return false;
            }
        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }

    public function importData()
    {
        if ($this->checkReaderConnection()){
            $curl = curl_init();
            $movement = \App\Models\Movement::latest()->first();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://'.$this->ip.':'.$this->port.'/export/'.Carbon::parse($movement->start_date)->format('Y-m-d'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $responseData = json_decode($response,true);
            $data = $responseData['data'];
            foreach ($data as $json){
                $user = User::where('card_number',$json['card_id'])->latest()->first();
                $startDate = Carbon::parse($json['start_date'])->tz('Asia/Tbilisi');
                $movement = \App\Models\Movement::whereDate('start_date',$startDate->format('Y-m-d'))->where('user_id',$user->id)->first();
                $endDate = $movement->end_date ?? null;
                if ($json['end_date']){
                    $endDate = Carbon::parse($json['end_date'])->tz('Asia/Tbilisi');
                }
               // if(!$movement){
                    \App\Models\Movement::where('start_date',$startDate)->updateOrCreate([
                        'user_id' => $user->id,
                        'card_number' => $json['card_id'],
                        'start_date' => $startDate,
                    ],['end_date' => $endDate]);
               // }
            }

            return true;
        }
        return false;
    }
}
