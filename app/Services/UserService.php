<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function generateNumber()
    {
        $number = mt_rand(1000, 9999); // better than rand()

        // call the same function if the barcode exists already
        if ($this->cardNumberExists($number)) {
            return $this->generateNumber();
        }

        // otherwise, it's valid and can be used
        return str_pad($number,4,"0", STR_PAD_LEFT);
    }

    protected function cardNumberExists($number) {
        return User::where('card_number',$number)->exists();
    }
}
