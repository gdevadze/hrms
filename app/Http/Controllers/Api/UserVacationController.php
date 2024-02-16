<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vacation;
use Illuminate\Http\Request;

class UserVacationController extends Controller
{
    public function index()
    {
        return Vacation::where('user_id',apiUser()->id)->get();
    }
}
