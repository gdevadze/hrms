<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function formattedDate(): Attribute
    {
        Carbon::setLocale(currentLocale());
        return new Attribute(
            get: fn($value) => Carbon::parse($this->date)->translatedFormat('d F')
        );
    }
}
