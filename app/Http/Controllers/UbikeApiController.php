<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UbikeApiController extends Controller
{
    public function array_search_key($sna, $array)
    {
        foreach($array as $key=>$data) {
            if (in_array($sna,$data)) {
                return $array[$key];
            }
        }
        return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search_sna(Request $request)
    {
        $ubike_json = file_get_contents('https://tcgbusfs.blob.core.windows.net/blobyoubike/YouBikeTP.json');
        $json_array = json_decode($ubike_json, TRUE);
        $sna = $request->sna;
        
        if (isset($request->sna)) {
            $result = $this->array_search_key($sna, $json_array["retVal"]);
        } else {
            $result = $json_array["retVal"];
        }

        return response(['data' => $result]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
}
