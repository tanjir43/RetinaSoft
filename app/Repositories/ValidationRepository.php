<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationRepository
{

    public function isValidFile(Request $request, $fileName = null)
    {
        if(!empty($fileName))  {
            return $request->validate([
                $fileName   => 'required|image|max:2048|mimes:jpg,jpeg,png,pdf,docx,doc,xlsx,xlx,pptx,ppt'
            ]);
        }
        return $request->validate([
            'file'      => 'required|image|max:2048|mimes:jpg,jpeg,png,pdf,docx,doc,xlsx,xlx,pptx,ppt'
        ]);
    }

    public function isValidCompany(Request $request, $id)
    {
        if(!empty($id)) {
            return Validator::make($request->all(), [
                'name'              => 'required|max:190',
                'name_l'            => 'nullable|max:190',
                'address'           => 'nullable|max:3000',
                'email'             => 'nullable|max:150',
                'phone'             => 'nullable|min:9|max:18|unique:companies,phone'.$id,
                'trade_license'     => 'nullable|max:100|unique:companies,trade_license'.$id,
                'vat'               => 'nullable|min:0|max:100',
                'vat_area_code'     => 'nullable|max:100',
                'mashuk_no'         => 'nullable|max:100|unique:companies,mashuk_no'.$id,
                'tin'               => 'nullable|max:100|unique:companies,tin'.$id,
                'registration_no'   => 'nullable|max:100|unique:companies,registration_no'.$id,
            ]);
        }
        return Validator::make($request->all(), [
            'name'              => 'required|max:190',
            'name_l'            => 'nullable|max:190',
            'address'           => 'nullable|max:3000',
            'email'             => 'nullable|max:150',
            'phone'             => 'nullable|min:9|max:18|unique:companies,phone',
            'trade_license'     => 'nullable|max:100|unique:companies,trade_license',
            'vat'               => 'nullable|min:0|max:100',
            'vat_area_code'     => 'nullable|max:100',
            'mashuk_no'         => 'nullable|max:100|unique:companies,mashuk_no',
            'tin'               => 'nullable|max:100|unique:companies,tin',
            'registration_no'   => 'nullable|max:100|unique:companies,registration_no',
        ]);
    }

    public function isValidUserForm(Request $request)
    {
        return $request->validate([
            'name'          => 'required|max:190',
            'email'         => 'required|email|unique:users,email|unique:employees,email|unique:temp_employees,email',
            'password'      => 'required|min:8|max:190|confirmed',
            'phone'         => 'min:9|max:18|unique:employees,phone|unique:temp_employees,phone',
            'nid'           => 'required|unique:employees,nid|unique:temp_employees,nid',
        ]);
    }

    public function isValidDepartment(Request $request){
        $id = $request->id;
        if ($id != 0) {
            return Validator::make($request->all(), [
                'name'          => 'required|max:250|unique:departments,name,' . $id,
                'name_l'        => 'nullable|max:250|unique:departments,name_l,' . $id
            ]);
        }
        return Validator::make($request->all(), [
            'name'          => 'required|max:250|unique:departments,name',
            'name_l'        => 'nullable|max:250|unique:departments,name_l'
        ]);
    }

    public function isValidDesignation(Request $request){
        $id = $request->id;
        if ($id != 0) {
            return Validator::make($request->all(), [
                'name'          => 'required|max:250|unique:designations,name,' . $id,
                'name_l'        => 'nullable|max:250|unique:designations,name_l,' . $id
            ]);
        }
        return Validator::make($request->all(), [
            'name'          => 'required|max:250|unique:designations,name',
            'name_l'        => 'nullable|max:250|unique:designations,name_l'
        ]);
    }

    public function isValidEmployee(Request $request, $id)
    {
        if(!empty($id)) {
            return Validator::make($request->all(), [
                'name'              => 'required|max:250',
                'name_l'            => 'nullable|max:250',
                #'date_of_birth'     => 'required',
                'id_card'           => 'nullable|max:190|unique:employees,id_card,'.$id,
                'nid'               => 'required|unique:employees,nid|unique:employees,nid'.$id,

                'employee_id'       => 'required|max:190|unique:employees,employee_id,'.$id,
                'joining_date'      => 'required',
                'department'        => 'required|exists:departments,id',
                'designation'       => 'required|exists:designations,id',

                'basic_salary'      =>  'required|numeric|between:1,999999999.99',
                'opening_balance'   =>  'required|numeric|between:-999999999.99,999999999.99',

                'phone'             => 'nullable|max:190|unique:employees,phone,'.$id,
                'phone_alt'         => 'nullable|max:190',
                'email'             => 'nullable|max:190|email|unique:employees,email,'.$id,
                'email_office'      => 'nullable|max:190',
                'address'           => 'nullable|max:65500',
            ]);
        }
        return Validator::make($request->all(), [
            'name'              => 'required|max:250',
            'name_l'            => 'nullable|max:250',
            #'date_of_birth'     => 'required',
            'id_card'           => 'nullable|max:190|unique:employees,id_card',
            'nid'               => 'required|unique:employees,nid|unique:employees,nid',

            'employee_id'       => 'required|max:190|unique:employees,employee_id',
            'joining_date'      => 'required',
            'department'        => 'required|exists:departments,id',
            'designation'       => 'required|exists:designations,id',

            'basic_salary'      =>  'required|numeric|between:1,999999999.99',

            'opening_balance'   =>  'required|numeric|between:-999999999.99,999999999.99',

            'phone'             => 'required|max:190|unique:employees,phone',
            'phone_alt'         => 'nullable|max:190',
            'email'             => 'nullable|max:190|email|unique:employees,email',
            'email_office'      => 'nullable|max:190',
            'address'           => 'nullable|max:65500',
        ]);
    }

    public function isValidEmployeeHistory(Request $request)
    {
        return Validator::make($request->all(), [
            'employee_id'       =>  'required|max:190|exists:employees,id',

            'is_fired'          =>  'required|in:0,1',
            'is_resigned'       =>  'required|in:0,1',
            'is_promoted'       =>  'required|in:0,1',
            
            'department'        => (!$request->is_fired && !$request->is_resigned) ? 'required|exists:departments,id' : 'nullable',
            'designation'       => (!$request->is_fired && !$request->is_resigned) ? 'required|exists:designations,id' : 'nullable',

            'basic_salary'      =>  ((!$request->is_fired && !$request->is_resigned) &&
                                    ($request->is_promoted)) 
                                    ? 'required|numeric|between:1,999999999.99' : 'nullable',

            'joining_date'      => ((!$request->is_fired && !$request->is_resigned) &&
                                    ($request->is_promoted)) 
                                    ? 'required' : 'nullable' ,
            'last_working_date' => 'required',
            'comment'           => 'nullable|max:65500',
        ]);
    }
}