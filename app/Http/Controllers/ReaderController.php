<?php

namespace App\Http\Controllers;

use App\Services\ReaderService;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index()
    {

    }

    public function importData(ReaderService $readerService)
    {
        $response = $readerService->importData();
        if ($response){
            return jsonResponse(['status' => 0]);
        }
        return jsonResponse(['status' => 1]);
    }
}
