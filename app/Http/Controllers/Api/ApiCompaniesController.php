<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;

class ApiCompaniesController extends Controller {

    /**
     * Return the contents of Company table in tabular form
     *
     */
    public function getCompaniesTabular() {
        $companies = Company::with('prefecture')->orderBy('id', 'asc')->get();
        // ここでPref ID Apiに投げて名前を返してもらい、それを返す
        return response()->json($companies);
    }

}
