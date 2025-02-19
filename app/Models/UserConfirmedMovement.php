<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConfirmedMovement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
