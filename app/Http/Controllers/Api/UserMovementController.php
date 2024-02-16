<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use Illuminate\Http\Request;

class UserMovementController extends Controller
{
    public function index()
    {
        return Movement::where('user_id',apiUser()->id)->latest()->get();
    }
}
