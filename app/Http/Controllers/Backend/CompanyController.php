<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Config;

class CompanyController extends Controller
{
    /**
     * Get named route
     *
     */
    private function getRoute() {
        return 'company';
    }

    /**
     * Validator for user
     *
     * @return \Illuminate\Http\Response
     */
    // protected function validator(array $data, $type) {
    //     // Determine if password validation is required depending on the calling
    //     return Validator::make($data, [
    //             'username' => 'required|string|max:255|unique:users,username,' . $data['id'],
    //             'display_name' => 'required|string|max:100',
    //             // (update: not required, create: required)
    //             'password' => 'string|min:6|max:255',
    //     ]);
    // }

    // 
    public function index() {
        return view('backend.companies.index');
    }
}
