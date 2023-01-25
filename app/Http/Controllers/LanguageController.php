<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('pages.languages.index',compact('languages'));
    }

    public function show($code)
    {
        $language = Language::where('code',$code)->first();
        $data = file_get_contents('../lang/'.$language->code.'.json');
        $jsonArr = json_decode($data, true);
        return view('pages.languages.show',compact('language','jsonArr'));
    }

    public function saveLanguageJson(Request $request)
    {
        $language = Language::findOrFail(1);
        $data = file_get_contents('../lang/'.$language->code.'.json');
        $json_arr = json_decode($data, true);
        $json_arr[$request->code] = $request->text;
        file_put_contents('../lang/'.$language->code.'.json',json_encode($json_arr,JSON_UNESCAPED_UNICODE));
        return $json_arr;
    }
}
