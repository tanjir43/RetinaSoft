<?php
namespace App\Repositories;

use App\Mail\UserAcceptMail;
use App\Mail\UserMail;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeHistory;
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

    public function Department(Request $request,$id)
    {
        $created_by = Auth::user()->id;

        if (!empty($id)) {
            $info = Department::find($id);

            if (!empty($info)){
                $info->name             =   $request->name;
                $info->name_l           =   $request->name_l;
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
            'created_by'            => $created_by,
        ];

        DB::beginTransaction();
        try {
            Department::create($data);
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function BlockDepartment($id)
    {
        $deleted_by = Auth::user()->id;
        $info = Department::find($id);
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

    public function UnblockDepartment($id)
    {
        $updated_by = Auth::user()->id;
        $info = Department::withTrashed()->find($id);
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

    public function Designation(Request $request,$id)
    {
        $created_by = Auth::user()->id;

        if (!empty($id)) {
            $info = Designation::find($id);

            if (!empty($info)){
                $info->name             =   $request->name;
                $info->name_l           =   $request->name_l;
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
            'created_by'            => $created_by,
        ];

        DB::beginTransaction();
        try {
            Designation::create($data);
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function BlockDesignation($id)
    {
        $deleted_by = Auth::user()->id;
        $info = Designation::find($id);
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

    public function UnblockDesignation($id)
    {
        $updated_by = Auth::user()->id;
        $info = Designation::withTrashed()->find($id);
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

    public function Employee(Request $request,$id)
    {
        $user = Auth::user()->id;
        $id = $request->id;
        if (!empty($id)) {
            $info = Employee::with('appointment')->withTrashed()->find($id);
            $totalEmployeeHistory = EmployeeHistory::where('employee_id',$id)->count();
            
            if (!empty($info)){
                $appointment_id = $info->appointment->id;
                
                $info->employee_id      =   $request->employee_id;
                $info->name             =   $request->name;
                $info->name_l           =   $request->name_l;
                $info->dob              =   date('Y-m-d',strtotime($request->dob));
                #$info->id_card          =   $request->id_card;
                $info->nid              =   $request->nid;
                
                if ($totalEmployeeHistory <= 1) {
                    $info->department_id    =   $request->department;
                    $info->designation_id   =   $request->designation;
                }
                
                $info->phone            =   $request->phone;
                $info->phone_alt        =   $request->phone_alt;
                $info->email            =   $request->email;
                $info->email_office     =   $request->email_office;
                $info->address          =   $request->address;
                
                if ($info->opening_balance > $request->opening_balance) {
                    $change = $request->opening_balance - $info->opening_balance;
                    $info->balance      +=   $change;
                }
                elseif ($info->opening_balance < $request->opening_balance) {
                    $change = $info->opening_balance - $request->opening_balance;
                    $info->balance      -=   $change;
                }
                $info->opening_balance  =   $request->opening_balance;
                $info->updated_by   =   $user;
                
                DB::beginTransaction();
                try {
                    $info->save();
                    EmployeeHistory::where('id',$appointment_id)
                    ->update([
                        'department_id'     =>  $request->department,
                        'designation_id'    =>  $request->designation,
                        
                        'basic_salary'      =>  $request->basic_salary,
                        
                        'joining_date'      =>  date('Y-m-d',strtotime($request->joining_date)),
                        'updated_by'        =>  $user
                    ]);
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
            'employee_id'       =>  $request->employee_id,
            'name'              =>  $request->name,
            'name_l'            =>  $request->name_l,
            'dob'               =>  date('Y-m-d',strtotime($request->dob)),
            #'id_card'           =>  $request->id_card,
            'nid'               =>  $request->nid,

            'department_id'     =>  $request->department,
            'designation_id'    =>  $request->designation,

            'phone'             =>  $request->phone,
            'phone_alt'         =>  $request->phone_alt,
            'email'             =>  $request->email,
            'email_office'      =>  $request->email_office,
            'address'           =>  $request->address,

            'opening_balance'   =>  $request->opening_balance,
            'balance'           =>  $request->opening_balance,

            'created_by'        =>  $user
        ];
        
        $joining_data = [
            'department_id'     =>  $request->department,
            'designation_id'    =>  $request->designation,
            
            'basic_salary'      =>  $request->basic_salary,

            'status'            =>  'join',
            'joining_date'      =>  date('Y-m-d',strtotime($request->joining_date)),
            'created_by'        =>  $user
        ];
        
        DB::beginTransaction();
        try {
            $employee = Employee::create($data);
            $joining_data['employee_id']    =   $employee->id;
            EmployeeHistory::create($joining_data);
            #dd($employee);
            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function EmployeeHistory(Request $request,$id)
    {
        
        $user = Auth::user()->id;
        $id = $request->id;

        $employee = Employee::find($request->employee_id);
        $employee_name = $employee->name;

        if (!empty($id)) {
            //check is history is last one?
            $latestHistory = EmployeeHistory::where('employee_id',$request->employee_id)
            ->orderBy('id','desc')->first();
            if ($latestHistory->id == $request->id) {
                /* 
                    if latest history id and request id is same 
                    update employee table and history table
                */
                #get employee history
                $history = EmployeeHistory::find($request->id);

                #set employee update info
                $employee->department_id    =   $request->department;
                $employee->designation_id   =   $request->designation;

                $employee->updated_by       =   $user;
                $employee->updated_at       =   now();

                #set employee history update info
                $history->department_id     =   $request->department;
                $history->designation_id    =   $request->designation;

                $history->basic_salary      =   $request->basic_salary;

                $history->joining_date      =   date('Y-m-d', strtotime($request->joining_date));

                $history->updated_by        =   $user;
                $history->updated_at        =   now();

                DB::beginTransaction();
                try {
                    $employee->save();
                    $history->save();
                    DB::commit();

                    return 'success';
                } catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['errors' => [__('msg.problem_try_again')]]);
                }
            } else {
                #get employee history
                $history = EmployeeHistory::find($request->id);

                $history->branch_id         =   $request->branch;
                $history->department_id     =   $request->department;
                $history->designation_id    =   $request->designation;

                $history->basic_salary      =   $request->basic_salary;
                #$history->other_benefits    =   $request->other_benefits;
                #$history->overtime_rate     =   $request->overtime_rate;
                #$history->bonus             =   $request->bonus;
                
                $history->joining_date      =   date('Y-m-d', strtotime($request->joining_date));
                $history->last_working_date =   date('Y-m-d', strtotime($request->last_working_date));
                
                $history->is_transferred    =   $request->is_transferred;
                $history->is_promoted       =   $request->is_promoted;

                $history->is_fired          =   $request->is_fired;
                $history->is_resigned       =   !$request->is_fired && $request->is_resigned  ? true : false;

                $history->comment           =   $request->comment;

                $history->updated_by        =   $user;
                $history->updated_at        =   now();

                DB::beginTransaction();
                try {
                    $history->save();
                    DB::commit();

                    SetLog('Update An Employee Working History. (' . $employee_name . ')');
                    return response()->json(['success'  =>  __('msg.successfully_done')]);
                } catch (Exception $e) {
                    DB::rollback();
                    return $e;
                }
            }
        }

        if(!$request->is_fired && !$request->is_resigned){            
            $employee->department_id    =   $request->department;
            $employee->designation_id   =   $request->designation;
        }
        $employee->updated_by       =   $user;
        $employee->updated_at       =   now();

        $last_history = EmployeeHistory::where('employee_id',$request->employee_id)
        ->orderBy('id','desc')->first();

        if($request->is_fired){
            $employee->status = 'fired';
        }
        elseif($request->is_resigned){
            $employee->status = 'resigned';
        }

        $last_history->is_fired = $request->is_fired;
        $last_history->is_resigned = !$request->is_fired && $request->is_resigned  ? true : false;
        $last_history->is_promoted = $request->is_promoted;

        $last_history->last_working_date = date('Y-m-d',strtotime($request->last_working_date));

        $last_history->comment      =   $request->comment;
        $last_history->updated_by   =   $user;
        $last_history->updated_at   =   now();


        $data = [
            'employee_id'       =>  $request->employee_id,
            'department_id'     =>  $request->department,
            'designation_id'    =>  $request->designation,

            'basic_salary'      =>  $request->basic_salary,

            'joining_date'      =>  date('Y-m-d', strtotime($request->joining_date)),
            'created_by'        =>  $user
        ];        

        DB::beginTransaction();
        try {
            $employee->save();
            $last_history->save();

            if(
                (!$request->is_fired && !$request->is_resigned) &&
                ($request->is_promoted)
            ){
                EmployeeHistory::create($data);
                User::where('employee_id', $employee->id)->update(['branch_id' => $request->branch]);
            }
            DB::commit();

            return 'success';
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
