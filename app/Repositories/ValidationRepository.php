<?php
namespace App\Repositories;

use Illuminate\Http\Request;

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

    public function isValidOrganization(Request $request, $id)
    {
        if(!empty($id)) {
            return $request->validate([
                'name'              => 'required|max:190',
                'name_l'            => 'nullable|max:190',
                'address'           => 'nullable|max:3000',
                'email'             => 'nullable|max:150',
                'phone'             => 'nullable|min:9|max:18|unique:organizations,phone'.$id,
                'trade_license'     => 'nullable|max:100|unique:organizations,trade_license'.$id,
                'vat'               => 'nullable|min:0|max:100',
                'vat_area_code'     => 'nullable|max:100',
                'mashuk_no'         => 'nullable|max:100|unique:organizations,mashuk_no'.$id,
                'tin'               => 'nullable|max:100|unique:organizations,tin'.$id,
                'registration_no'   => 'nullable|max:100|unique:organizations,registration_no'.$id,
            ]);
        }
        return $request->validate([
            'name'              => 'required|max:190',
            'name_l'            => 'nullable|max:190',
            'address'           => 'nullable|max:3000',
            'email'             => 'nullable|max:150',
            'phone'             => 'nullable|min:9|max:18|unique:organizations,phone',
            'trade_license'     => 'nullable|max:100|unique:organizations,trade_license',
            'vat'               => 'nullable|min:0|max:100',
            'vat_area_code'     => 'nullable|max:100',
            'mashuk_no'         => 'nullable|max:100|unique:organizations,mashuk_no',
            'tin'               => 'nullable|max:100|unique:organizations,tin',
            'registration_no'   => 'nullable|max:100|unique:organizations,registration_no',
        ]);
    }
}