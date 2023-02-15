<?php

define('TRANSL_FROM_LATIN', 1);
define('TRANSL_TO_LATIN', 2);

if (!function_exists('jsonResponse')) {
    function jsonResponse($data = [], int $status = 200,$headers = [],$options)
    {
        return response()->json($data, $status,$headers,$options);
    }
}

if (!function_exists('currentUser')) {
    function currentUser(){
        return optional(auth() -> user());
    }
}

if (!function_exists('monthWorkingDays')) {
    function monthWorkingDays($data = [],$workingSchedule){
        if (is_array($data)){
            $daysInMonth = $data['days_in_month'];
            $month = $data['month'];
            $year = $data['year'];
            for ($i = 1; $i <= $daysInMonth; $i++) {

                $date = $year . '/' . $month . '/' . $i; //format date
                $get_name = date('l', strtotime($date)); //get week day
                $day_name = substr($get_name, 0, 3); // Trim day name to 3 chars
//                echo $get_name;
                //if not a weekend add day to array  && $day_name != 'Sun' && $day_name != 'Sat'
                if (in_array(strtoupper($get_name),$workingSchedule)) {
                    $workdays[] = $i;
                }
//
//                if () {
//                    $workdays[] = $i;
//                }
            }
        }

        return $workdays;
    }
}

if (!function_exists('currentLocale')) {
    function currentLocale(){
        return app()->currentLocale();
    }
}

if (!function_exists('getMonthName')){
    function getMonthName($monthKey){
        $months = [
            '01' => 'იანვარი',
            '02'=>'თებერვალი',
            '03'=>'მარტი',
            '04'=>'აპრილი',
            '05'=>'მაისი',
            '06'=>'ივნისი',
            '07'=>'ივლისი',
            '08'=>'აგვისტო',
            '09'=>'სექტემბერი',
            '10'=>'ოქტომბერი',
            '11'=>'ნოემბერი',
            '12'=>'დეკემბერი'
        ];
        return $months[$monthKey];
    }
}

if (!function_exists('durationStr')){
    function durationStr($duration){
        switch ($duration) {
            case 1:
                return '24 საათი';
            case 7:
                return '1 კვირა';
            case 14:
                return '2 კვირა';
            case 30:
                return '1 თვე';
            case 90:
                return '3 თვე';
            case 180:
                return '6 თვე';
            case 365:
                return '12 თვე';
            default:
                return $duration.' დღე';
        }
    }
}

if (!function_exists('localeUrl')) {
    function localeUrl($locale){
        $requestUri = request()->getRequestUri();
        $parsedRequestUri = explode('/',$requestUri);
        array_shift($parsedRequestUri);
        $parsedRequestUri[0] = $locale;
        return implode('/',$parsedRequestUri);
    }
}

if (!function_exists('generateCode')){
    function generateCode($length){
        $permitted_chars = '0123456789';
        return substr(str_shuffle($permitted_chars), 0, $length);
    }
}

if (!function_exists('errorSendTelegram')){
    function errorSendTelegram($exception)
    {
        $botToken = '1290501868:AAEHh4XABNQKrzs2y4yyf5pItRBiy0yDbgc';
        $website = "https://api.telegram.org/bot" . $botToken;
        $params = [
            'chat_id' => 995786504,
            'text' => "Olympia: $exception",
        ];
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_error($ch);
        curl_close($ch);
    }
}

if (!function_exists('getUserCount')) {
    function getUserCount(){
        $userCount = \App\Models\User::whereNotIn('id',[1])->get()->count();
        return $userCount;
    }
}

if (!function_exists('getCarsCount')) {
    function getCarsCount(){
        $carsCount = \App\Models\Car::all()->count();
        return $carsCount;
    }
}

if(!function_exists('translit')) {
    function translit($str, $mode = TRANSL_TO_LATIN)
    {
        $converter = array(
            'ა' => 'a',
            'ბ' => 'b',
            'გ' => 'g',
            'დ' => 'd',
            'ე' => 'e',
            'ვ' => 'v',
            'ზ' => 'z',
            'თ' => 't',
            'ი' => 'i',
            'კ' => 'k',
            'ლ' => 'l',
            'მ' => 'm',
            'ნ' => 'n',
            'ო' => 'o',
            'პ' => 'p',
            'ჟ' => 'zh',
            'რ' => 'r',
            'ს' => 's',
            'ტ' => 't',
            'უ' => 'u',
            'ფ' => 'p',
            'ქ' => 'q',
            'ღ' => 'g',
            'ყ' => 'k',
            'შ' => 'sh',
            'ჩ' => 'ch',
            'ც' => 'ts',
            'ძ' => 'dz',
            'წ' => 'ts',
            'ჭ' => 'ch',
            'ხ' => 'kh',
            'ჯ' => 'j',
            'ჰ' => 'h',
            //' ' => '-',
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'io',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sht',
            'ъ' => 'a',
            'ы' => 'i',
            'ь' => 'y',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya'
        );
        if ($mode == TRANSL_FROM_LATIN) {
            $converter = array_flip($converter);
        }
        return strtr(strtolower($str), $converter);
    }

}

if(!function_exists('sum_times')) {
    function sum_times(...$args) {
        foreach ($args as $time) {
            $timeArr = explode(':');

        }
        return collect($args)->map(fn ($time) => strtotime($time))->sum() / 1000 / 60 / 60;
    }
}

if (!function_exists('seconds2time')) {
    function seconds2time($totalSeconds)
    {
        $remains = $totalSeconds % 3600;
        $hours = str_pad((int)($totalSeconds / 3600),2,0,STR_PAD_LEFT);
        $minutes = str_pad((int)($remains / 60),2,0,STR_PAD_LEFT);
        $seconds = str_pad($remains % 60,2,0,STR_PAD_LEFT);
        return "{$hours}:{$minutes}:{$seconds}";
    }
}
