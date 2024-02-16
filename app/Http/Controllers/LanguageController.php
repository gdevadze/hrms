<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function index(): View
    {
        $languages = Language::all();
        return view('pages.languages.index',compact('languages'));
    }

    public function jsonLangImport(Request $request)
    {
        $mylang = Language::find(2);
        $lang = Language::find(1);

        $data1 = json_decode(file_get_contents('../lang/' . $lang->code . '.json'), true);
        $data2 = json_decode(file_get_contents('../lang/' . $mylang->code . '.json'), true);

        // Find keys in data1 that are not in data2
        $unique_keys = array_diff_key($data1, $data2);

        // Merge data1 key-value pairs with unique keys into data2
        foreach ($unique_keys as $key => $value) {
            $data2[$key] = $value;
        }

        // Write the merged data back to file2
        file_put_contents('../lang/' . $mylang->code . '.json', json_encode($data2, JSON_UNESCAPED_UNICODE));

        return jsonResponse(['status' => 0]);
    }

    public function show($code): View
    {
        $language = Language::where('code',$code)->first();
        $data = file_get_contents('../lang/'.$language->code.'.json');
        $jsonArr = json_decode($data, true);
        return view('pages.languages.show',compact('language','jsonArr'));
    }
    public function languageJsonAjax(Request $request)
    {
        $code = $request->id;
        $language = Language::where('code',$code)->first();
        $data = file_get_contents('../lang/'.$language->code.'.json');
        $jsonArr = json_decode($data,true);
        $a = array();
        foreach ($jsonArr as $key => $json){
            array_push($a, [
                'key' => $key,
                'value' => $json
            ]);
        }
        return Datatables()->of($a)
            ->addColumn('action', function ($data) use($language) {
//                $html = '';
                $html = '<button type="submit" id="edit_key"
                                                        data-id="'.$language->id.'"
                                                        data-key="'.$data['key'].'"
                                                        data-value="'.$data['value'].'"
                                                        class="btn btn-outline-primary waves-effect waves-light mb-2">
                                                    რედაქტირება
                                                </button>';
                $html .= ' <button type="submit" id="lang_data" onclick="deleteLangJson()"
                                                        data-id="'.$language->id.'"
                                                        data-key="'.$data['key'].'"
                                                        data-value="'.$data['value'].'"
                                                        class="btn btn-outline-danger waves-effect waves-light mb-2">
                                                    წაშლა
                                                </button>';
                return $html;
            })
            ->rawColumns(['action','formatted_value'])
            ->toJson();
    }

    public function createLanguageJson(Request $request): JsonResponse
    {
        $id = $request->id;
        return jsonResponse(['status' => 0,'html' => view('general.languages.create_language_json',compact('id'))->render()]);
    }

    public function editLanguageJson(Request $request): JsonResponse
    {
        $id = $request->id;
        $key = $request->key;
        $value = $request->value;
        return jsonResponse(['status' => 0,'html' => view('general.languages.edit_language_json',compact('id','key','value'))->render()]);
    }

    public function storeLanguageJson(Request $request, $id)
    {
        $la = Language::find($id);
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required'
        ]);

        $items = file_get_contents('../lang/' . $la->code . '.json');

        $reqKey = trim($request->key);

        if (array_key_exists($reqKey, json_decode($items, true))) {
            return jsonResponse(['status' => 1,'msg' => 'აღნიშნული Key ('.$reqKey.') უკვე დამატებულია!']);
        } else {
            $languages = Language::all();
            foreach ($languages as $language){
                if($language->id == $la->id){
                    $newArr[$reqKey] = trim($request->value);
                    $itemsss = json_decode($items, true);
                    $result = array_merge($itemsss, $newArr);
                    file_put_contents('../lang/'. $la->code . '.json', json_encode($result,JSON_UNESCAPED_UNICODE));
                }else{
                    $items = file_get_contents('../lang/' . $language->code . '.json');
                    $newArr[$reqKey] = "";
                    $itemsss = json_decode($items, true);
                    $result = array_merge($itemsss, $newArr);
                    file_put_contents('../lang/'. $language->code . '.json', json_encode($result,JSON_UNESCAPED_UNICODE));
                }
            }

            return jsonResponse(['status' => 0,'msg' => 'თარგმანი წარმატებით დაემატა!']);
        }
    }

    public function updateLanguageJson(Request $request,$id)
    {
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required'
        ]);

        $reqkey = trim($request->key);
        $reqValue = $request->value;
        $lang = Language::find($id);

        $data = file_get_contents('../lang/' . $lang->code . '.json');

        $json_arr = json_decode($data, true);

        $json_arr[$reqkey] = $reqValue;

        file_put_contents('../lang/'. $lang->code . '.json', json_encode($json_arr,JSON_UNESCAPED_UNICODE));
        return jsonResponse(['status' => 0,'msg' => 'თარგმანი წარმატებით განახლდა!']);
    }

    public function deleteLanguageJson(Request $request)
    {
        $this->validate($request, [
            'key' => 'required',
            'value' => 'required'
        ]);

        $reqkey = $request->key;
        $reqValue = $request->value;
        $id = $request->id;
        $lang = Language::find($id);
        $data = file_get_contents('../lang/'. $lang->code . '.json');

        $json_arr = json_decode($data, true);
        unset($json_arr[$reqkey]);

        file_put_contents('../lang/'. $lang->code . '.json', json_encode($json_arr,JSON_UNESCAPED_UNICODE));
        return jsonResponse(['status' => 1]);
    }
}
