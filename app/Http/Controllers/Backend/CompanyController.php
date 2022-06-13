<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Postcode;
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

    public function index() {
        return view('backend.companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $company = new Company();
        $company->form_action = $this->getRoute() . '.create';
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';
        return view('backend.companies.form', [
            'company' => $company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        if ($request->has('submit')) {
            $newCompany = $request->all();

            // Validate input, indicate this is 'create' function
            // $this->validator($newCompany, 'create')->validate();

            // image file
            // 拡張子を取得
            $extension = $request->file("image")->getClientOriginalExtension();

            //保存のファイル名を構築
            $filenameToStore = "image_.".$extension;

            $path = $request->file("image")->storeAs("public/uploads/files/", $filenameToStore);
            $newCompany['image'] = 'public/uploads/files/'.$filenameToStore;

            try {
                $company = Company::create($newCompany);
                if ($company) {
                    // Create is successful, back to list
                    return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
                } else {
                    // Create is failed
                    return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
                }
            } catch (Exception $e) {
                // Create is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $company = Company::find($id);
        $company->form_action = $this->getRoute() . '.update';
        $company->page_title = 'Company Edit Page';
        // Add page type here to indicate that the form.blade.php is in 'edit' mode
        $company->page_type = 'edit';
        return view('backend.companies.form', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $newCompany = $request->all();
        try {
            $currentCompany = Company::find($request->get('id'));
            if ($currentCompany) {
                // Validate input only after getting password, because if not validator will keep complaining that password does not meet validation rules
                // Hashed password from DB will always have length of 60 characters so it will pass validation
                // Also indicate this is 'update' function
                //$this->validator($newCompany, 'update')->validate();

                // Update company
                $currentCompany->update($newCompany);
                // If update is successful
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_UPDATE_MESSAGE'));
            } else {
                // If update is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
            }
        } catch (Exception $e) {
            // If update is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_UPDATE_MESSAGE'));
        }
    }

    public function delete(Request $request) {
        try {
            // Get user by id
            $company = Company::find($request->get('id'));
            // If to-delete Company is not the one currently logged in, proceed with delete attempt
            if (Auth::id() != $company->id) {

                // Delete company
                $company->delete();

                // If delete is successful
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
            }
            // Send error if logged in user trying to delete himself
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_SELF_MESSAGE'));
        } catch (Exception $e) {
            // If delete is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_DELETE_MESSAGE'));
        }
    }
}
