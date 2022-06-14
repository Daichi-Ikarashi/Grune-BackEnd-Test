<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Postcode;
use App\Models\Company;

class ApiPostcodesController extends Controller {

    /**
     * Return the contents of Postcode array in some forms
     *
     */
    // Get detailed address from Postcode
    public function getPostcodeData($postcode) {
        $address = Postcode::whereIn('postcode', [$postcode])->get();        
        return $address;
    }
}
