<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSheet;
use App\Models\AttendanceSheetDetail;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $current_user = User::where('id',$user)->with('employee')->first();
        $attendance_detail = AttendanceSheetDetail::where('employee_id',$current_user->employee->id)->first();
        #$attendance_detail->in_time;

        #dd($attendance_detail->in_time);
        return view('user.dashboard',compact(['current_user','attendance_detail']));
    }

    public function createAttendance()
    {
        $user = Auth::user()->id;
        $email = Auth::user()->email;
        $employee = Employee::where('email',$email)->first();

        $d = date('Y-m-d');
        $month_name = strtolower(date('F',strtotime($d)));
        $year = date('Y');
        $day = date('d');
        $in_time = date('H-i-s');
        $out_time = date('H-i-s');

        $data = [
            'year'      => $year,
            'month'     => $month_name,
            'created_by'=> $user
        ];
/* 
       /*  $attendanceSheet = AttendanceSheet::where(['year'=>$year,'month'=>$month_name])->with('details')->first();
        
        if(!empty($attendanceSheet)) {
            #$attendance_detail_create = AttendanceSheetDetail::create($attendance_detail);
            dd('2');
            dd($attendanceSheet);
        } */


     



        $attendanceSheet = AttendanceSheet::where(['year'=>$year,'month'=>$month_name])->with('details')->first();
        
        if(!empty($attendanceSheet)) {
            #$attendance_detail_create = AttendanceSheetDetail::create($attendance_detail);
        
         /*    $outdata = [
                'out_time'              => $out_time,
                'attendance_sheet_id'   => $attendanceSheet,
                'employee_id'           => $user,
            ];
            DB::beginTransaction();
            try {
            DB::table('attendance_sheet_details')->insert($outdata);
            DB::commit();
            return 'success';

            }catch (Exception $e) {
                DB::rollback();
                return $e;
            } */
        }

        DB::beginTransaction();
        try {

        $attendance_sheet_create = AttendanceSheet::create($data);
        $att_id = $attendance_sheet_create->id;
        $attr2 = AttendanceSheetDetail::where('attendance_sheet_id',$att_id)->first();
        
        $attendance_detail = [
            'attendance_sheet_id'   => $att_id,
            'in_time'     => $in_time,
            'employee_id' => $employee->id,
            'day'         => $day
        ]; 
        
        if(!empty($attr2)) {
            if(!empty($employee)){
                $attendance_detail = [
                  'attendance_sheet_id' => $att_id,
                  'in_time'     => $in_time,
                  'employee_id' => $employee->id,
                  'day'         => $day
                ];
            }
            DB::table('attendance_sheet_details')->insert($attendance_detail);
        }
        AttendanceSheetDetail::create($attendance_detail);
        
/*         $attendance_detail = [
            'attendance_sheet_id'   => $attendanceSheet->id,
            'in_time'     => $in_time,
            'employee_id' => $employee->id,
            'day'         => $day
        ];
            
            if(!empty($attendanceSheet)) {
                #$attendance_detail_create = AttendanceSheetDetail::create($attendance_detail);
                dd('2');
                dd($attendanceSheet);
            } */

            DB::commit();
            return redirect()->route('user.dashboard');
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
