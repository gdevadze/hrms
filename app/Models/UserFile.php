<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'formatted_create_date'
    ];

    public function formattedCreateDate(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->created_at)->format('d.m.Y H:i')
        );
    }
}
