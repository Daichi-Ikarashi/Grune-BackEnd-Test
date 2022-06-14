<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;

class ApiCompaniesController extends Controller {

    /**
     * Return the contents of Company table in tabular form
     *
     */
    // Returns the data registered in the Company table as JSON data.
    public function getCompaniesTabular() {
        $companies = Company::with('prefecture')->orderBy('id', 'asc')->get();
        return response()->json($companies);
    }

}
