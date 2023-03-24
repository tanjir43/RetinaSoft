<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Repositories\SaveRepository;
use App\Repositories\ValidationRepository;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private $vr;
    private $save;
    public function __construct(ValidationRepository $validationRepository, SaveRepository $saveRepository)
    {
        $this->vr   = $validationRepository;
        $this->save = $saveRepository;
    }

    public function index()
    {
        return view('admin.employees.attendance.index',compact('month_options','year_options'));
    }


/*     public function create()
    {
        if (!$this->have_permission(70) || !$this->have_permission(74)) {
            return response()->json(['deny' => __('msg.deny')]);
        }

        $branch_id = $_GET['branch'] ?? Auth::user()->branch_id;
        $branchInfo = Branch::find($branch_id);

        $month_options = [];
        for ($month=1; $month <= 12; $month++) {
            $d = date('Y-'.$month.'-d');
            $month_name = strtolower(date('F',strtotime($d)));

            $last_day = date('t',strtotime($d));

            array_push($month_options,[
                'value'     =>  $month_name,
                'label'     =>  __('msg.'.$month_name),
                'last_day'  =>  $last_day
            ]);
        }

        $year_options = [];
        for ($i=date('Y',strtotime('-1 years')); $i < date('Y',strtotime('+2 years')); $i++) {
            array_push($year_options,[
                'value' =>  (int)$i,
                'label' =>  (int)$i 
            ]);
        }

        $employees = Employee::where([
            ['branch_id','=',$branch_id],
            ['status','=','working'],
        ])->with('salary','department','designation')->get();

        return response()->json([
            'month_options'     =>  $month_options, 
            'year_options'      =>  $year_options, 
            'branches'          =>  Branch::all(),
            'default_branch'    =>  $branchInfo,
            'employees'         =>  $employees,
            'page'              =>  $this->translate($branchInfo->branch_type),
        ]); 
    } */
}
