<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prefecture;

class ApiPrefecturesController extends Controller {

    /**
     * Return the contents of Prefecture array in select box form
     *
     */
    public function getPrefectures() {
        $prefs = Prefecture::orderBy('id','asc')->get();
        $list = array();
        $list += array("" => "選択してください");
        foreach ($prefs as $pref) {
            $list += array($pref->id => $pref->display_name);
        }
        return $list;
    }

}
