<?php
namespace App\Repositories;

use App\Mail\UserAcceptMail;
use App\Mail\UserMail;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Media;
use App\Models\TempEmployee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SaveRepository {

    public function uploadFile(Request $request, $fileName = null) {
        $created_by = Auth::user()->id;
        $upload     = $request->file($fileName ?? 'file');
        $path       = $upload->getRealPath();
        $file       = file_get_contents($path);
        $base64     = base64_encode($file);
        $file = [
            'name'          =>  $upload->getClientOriginalName(),
            'mime'          =>  $upload->getClientMimeType(),
            'size'          =>  number_format(($upload->getSize() / 1024), 1),
            'attachment'    =>  'data:'.$upload->getClientMimeType().';base64,'.$base64,
            'created_by'    =>  $created_by
        ];
        $info = Media::create($file);
        return $info->id;
    }

    public function Company(Request $request,$id)
    {
        $created_by = Auth::user()->id;

        if (!empty($id)) {
            $info = Company::find($id);

            if (!empty($info)){
                $info->name             =   $request->name;
                $info->name_l           =   $request->name_l;
                $info->address          =   $request->address;
                $info->email            =   $request->email;
                $info->phone            =   $request->phone;
                $info->trade_license    =   $request->trade_license;
                $info->vat              =   $request->vat;
                $info->vat_area_code    =   $request->vat_area_code;
                $info->mashuk_no        =   $request->mashuk_no;
                $info->tin              =   $request->tin;
                $info->registration_no  =   $request->registration_no;
                $info->updated_by       =   $created_by;

                DB::beginTransaction();
                try {
                    $info->save();
                    DB::commit();
                    return 'success';
                } catch (Exception $e) {
                    DB::rollback();
                    return $e;
                }
            }
            else{
                return  "No record found";
            }
        }

        $data = [
            'name'                  => $request->name,
            'name_l'                => $request->name_l,
            'address'               => $request->address,
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'trade_license'         => $request->trade_license,
            'vat'                   => $request->vat,
            'vat_area_code'         => $request->vat_area_code,
            'mashuk_no'             => $request->mashuk_no,
            'tin'                   => $request->tin,
            'registration_no'       => $request->registration_no,
            'created_by'            => $created_by,
        ];

        DB::beginTransaction();
        try {
            Company::create($data);
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function BlockCompany($id)
    {
        $deleted_by = Auth::user()->id;
        $info = Company::find($id);
        if (!empty($info)){
            $info->deleted_by   = $deleted_by;
            DB::beginTransaction();
            try {
                $info->save();
                $info->delete();
                DB::commit();
                return 'success';
            } catch (Exception $e) {
                DB::rollback();
                return $e;
            }
        }
        else{
            return __('msg.no_record_found');
        }
    }

    public function UnblockCompany($id)
    {
        $updated_by = Auth::user()->id;
        $info = Company::withTrashed()->find($id);
        if (!empty($info)){
            $info->updated_by   = $updated_by;
            $info->deleted_by   = null;

            DB::beginTransaction();
            try {
                $info->save();
                $info->restore();
                DB::commit();
                return 'success';
            } catch (Exception $e) {
                DB::rollback();
                return $e;
            }
        }
        else{
            return __('msg.no_record_found');
        }
    }

    public function UserForm(Request $request)
    {
        #$role_id = 7;
        $user = [
            'name'                  =>  $request->name,
            'email'                 =>  $request->email,
            'password'              =>  Hash::make($request->password),
            'nid'                   =>  $request->nid,
            'phone'                 =>  $request->phone,
            'created_by'            =>  '0'
        ];
  
        $info  = [
            'name'  =>  $request->name
        ];

        DB::beginTransaction();
        try {
            TempEmployee::create($user);
            Mail::to($request->email)->send( new UserMail((object)$info));
            DB::commit();
            return 'success';

        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return $e;
        }
    }

    public function AddEmployee(Request $request,$id) 
    {
        $role_id = 3;
        $tempEmployee = TempEmployee::findOrFail($id);
        $user_id  = Auth::user()->id;
        $employee_data = [
            'name'                  =>  $tempEmployee->name,
            'email'                 =>  $tempEmployee->email,
            'phone'                 =>  $tempEmployee->phone,
            'nid'                   =>  $tempEmployee->nid,
            'created_by'            =>  $user_id
        ];
        $activation_code = md5(Str::random(30).time());
        $user_data = [
            'name'                  =>  $tempEmployee->name,
            'email'                 =>  $tempEmployee->email,
            'password'              =>  $tempEmployee->password,
            'role_id'               =>  $role_id,
            'created_by'            =>  $user_id
        ];

        $info  = [
            'name'              => $tempEmployee->name,
            'activation_code'   => $activation_code
        ];

        $password_reset  = [
            'email'              => $tempEmployee->email,
            'token'              => $activation_code
        ];

        DB::beginTransaction();
        try {
            $employee = Employee::create($employee_data);
            $user_data['employee_id'] = $employee->id;
            
            User::create($user_data);
            DB::table('password_reset_tokens')->insert($password_reset);
            
            Mail::to($tempEmployee->email)->send( new UserAcceptMail((object)$info));
            $tempEmployee->delete();
            DB::commit();
            return 'success';

        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}