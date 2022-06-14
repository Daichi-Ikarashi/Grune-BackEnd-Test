<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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

    /**
     * Validator for company
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data, $type) {
        // create:image file required. update:image file not required
        if ($type === 'create') {
            return Validator::make($data, [
                'name' => 'required|min:3|max:100',
                'email' => 'required|min:5|max:100',
                'postcode' => 'required|min:7|max:100',
                'prefecture_id' => 'required|int|max:100',
                'city' => 'required|min:2|max:100',
                'local' => 'required|min:2|max:100',
                'street_address' => 'max:100',
                'business_hour' => 'max:100',
                'regular_holiday' => 'max:100',
                'phone' => 'max:100',
                'fax' => 'max:100',
                'url' => 'max:100',
                'license_number' => 'max:100',
                'image' => 'required|image|max:5120'
            ]);
        } if ($type === 'update') {
            return Validator::make($data, [
                'name' => 'required|min:3|max:100',
                'email' => 'required|min:5|max:100',
                'postcode' => 'required|min:7|max:100',
                'prefecture_id' => 'required|int|max:100',
                'city' => 'required|min:2|max:100',
                'local' => 'required|min:2|max:100',
                'street_address' => 'max:100',
                'business_hour' => 'max:100',
                'regular_holiday' => 'max:100',
                'phone' => 'max:100',
                'fax' => 'max:100',
                'url' => 'max:100',
                'license_number' => 'max:100',
                'image' => 'image|max:5120'
            ]);
        }
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
        $newCompany = $request->all();
        // Validate input, indicate this is 'create' function
        $this->validator($newCompany, 'create')->validate();

        try {
            $company = Company::create($newCompany);
            // after create, get id and save image file
            // save file name "image_{id}.extension"
            $id = $company["id"];
            // get extension
            $extension = $request->image->getClientOriginalExtension();
            // Specifying the file name
            $filenameToStore = "image_".$id.".".$extension;
            // store image file
            $path = $request->image->storeAs("public/uploads/files", $filenameToStore);
            // save file path in company table by fill,save method
            $company->fill([
                'id' => $id,
                'image' => $path
            ]);
            $company->save();
            if ($company) {
                // Create is successful, back to list
                return redirect()->route($this->getRoute())->with('success', Config::get('const.SUCCESS_CREATE_MESSAGE'));
            } else {                    // Create is failed
                return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
            }
        } catch (Exception $e) {
            // Create is failed
            return redirect()->route($this->getRoute())->with('error', Config::get('const.FAILED_CREATE_MESSAGE'));
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
        $company->page_title = 'User Edit Page';
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
        // Also indicate this is 'update' function
        $this->validator($newCompany, 'update')->validate();
        // If new files are added, change image file
        if ($request->image) {
            $extension = $request->image->getClientOriginalExtension();
            $id = $request->get('id');
            $filenameToStore = "image_".$id.".".$extension;
            // First, Check for the existence of existing files and delete them if they exist.
            if (Storage::exists('public/uploads/files/'.$filenameToStore)) {
                Storage::delete('public/uploads/files/'.$filenameToStore);
            }
            // Save a new One
            $path = $request->image->storeAs("public/uploads/files", $filenameToStore);
            $newCompany['image'] = $path;
        }
        try {
            $currentCompany = Company::find($request->get('id'));
            if ($currentCompany) {
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
            // Get company by id
            $company = Company::find($request->get('id'));
            // If to-delete Company is not the one currently logged in, proceed with delete attempt
            if (Auth::id() != $company->id) {

                // Specify the path and delete
                Storage::delete($company->image);
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
