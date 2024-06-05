<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GeneralSettingController extends Controller
{
    public function index(): View
    {
        $generalSettings = GeneralSetting::all();
        return view('pages.settings.general_settings',compact('generalSettings'));
    }

    public function update(Request $request)
    {
//        return $request->all();
        foreach ($request->settings as $key => $value) {
            GeneralSetting::firstWhere('key', $key)->update([
                'value' => $value
            ]);
        }
        return redirect()->back()->with('success','ინფორმაცია წარმატებით განახლდა!');
    }
}
