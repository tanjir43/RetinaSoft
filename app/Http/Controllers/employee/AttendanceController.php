<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSheet;
use App\Models\AttendanceSheetDetail;
use App\Models\Employee;
use App\Repositories\SaveRepository;
use App\Repositories\ValidationRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use yajra\Datatables\DataTables;


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
        $employees = Employee::all();
        return view('admin.employees.attendance.index',compact('employees'));
    }

    public function validation(Request $request)
    {

        return Validator::make($request->all(),[
            'month'         => 'required',
            'year'          => 'required',
            'employee*'     => 'required|max:190|exists:employees,id',
        ]);
    }

    public function save(Request $request)
    {


        $isValid = $this->validation($request);
        if ($isValid->fails()) {
            return back();
        }

        $total_active_employee = Employee::count();

     /*    if($total_active_employee != count($request->employee)){
            return response()->json(['errors' => [__('msg.please_add_all_employee')] ]);
        } */

        $isValidAttendanceSheet = AttendanceSheet::where([
            ['month','=',$request->month],
            ['year','=',$request->year],
        ])->count();

        if($isValidAttendanceSheet > 0){
            return back();
        }

        $user = Auth::user()->id;

        $data = [
            'month'             => $request->month,
            'year'              => $request->year,
            'created_by'        => $user
        ];

        DB::beginTransaction();

        try {
            $attendance = AttendanceSheet::create($data);
            $details = [];
                $details[] = [ 
                    'attendance_sheet_id'   => $attendance->id,
                    'employee_id'           => $request->employee,
                    'in_time'               => $request->in_time,
                    'out_time'              => $request->out_time,
                    'created_at'            => now()
                ];
            
            AttendanceSheetDetail::insert($details);
            DB::commit();
            return back();

        } catch (Exception $e) {
            DB::rollback();
            return back();
        }
    }

    public function datatable()
    {
        $info = AttendanceSheet::withTrashed()->with('createdby', 'updatedby', 'deletedby')
        ->with('details',function ($q)
            {
                $q->with('employee');
            })
        ->orderby('id', 'DESC');

        return DataTables::of($info)
            ->editColumn('year', function ($data) {
                return $data->year;
            })
            ->filterColumn('year', function ($query, $keyword) {
                $query
                    ->Where('year', 'like', '%' . $keyword . '%')
                    ->orWhere('month', 'like', '%' . $keyword . '%');
            })
            ->editColumn('information', function ($data) {
                $html = '';
                if (!empty($data)) {
                $html .= '<span > <strong>'. __('msg.year'). ' :  </strong>' . $data->year . '</span>';
                }
                if (!empty($data)) {
                    $html .= '<br> <strong>' . __('msg.month') . ' : </strong>' . $data->month;
                }
                return $html;
            })
            ->editColumn('deleted_at', function ($data) {
                if (empty($data->deleted_at)) {
                    return '<span class="badge bg-success">' . __('msg.running') . '</span>';
                } else {
                    $html= '<p class="text-center"><span class="badge bg-danger">'.__('msg.closed').'</span>';
                    if ($data->deletedby) {
                        $html.= '<br><span class="badge bg-danger mt-1">'.$data->deletedby->name.'</span></p>';
                    }
                    return $html;
                }
            })
            ->editColumn('created_at', function ($data) {
                 $html = '<span class="badge badge-pill bg-success">' . $data->created_at . '</span>';
                if (!empty($data->createdby)) {
                    $html .= '<br><span class="badge bg-success">' . $data->createdby->name . '</span>';
                }
                if ($data->created_at != $data->updated_at) {
                    $html .= '<br><span class="badge badge-pill bg-warning mt-1" style="margin-top: 5px">' . $data->updated_at . '</span>';
                    if (!empty($data->updatedby)) {
                        $html .= '<br><span class="badge bg-warning">' . $data->updatedby->name . '</span>';
                    }
                }
                return $html;
            })
            ->addColumn('action', function ($data) {
                $edit_url = route('attendance.edit', $data->id);


                $html = '<div class="text-center">';

                $html .= '<a  href="' . $edit_url . '">' . '<i class="fas fa-edit"></i>' . '</a>';
/*                 if (empty($data->deleted_at)) {
                 
                            $html .= '<a onclick="return confirm(\'' . __('msg.block_this_company?') . ' \')" href="' . $block . '">' .'<span style="margin-left:10px;"><i class="fas fa-lock  text-danger"></i></span>' . '</a>'  ;
                       
                    } else {
                        $html .= '<a onclick="return confirm(\'' . __('msg.unblock_this_company?') . ' \')" href="' . $unblock . '">' . '<i class="fas fa-unlock text-success"></i>' . '</a>';
                    } */
               
                $html .= '</ul></div>';
                return $html; 
            })
            ->rawColumns(['year', 'deleted_at', 'created_at', 'information', 'action'])
            ->make(true);
    }

    public function edit($id)
    {
        $employees = Employee::all();

        $record = AttendanceSheet::where('id', $id)->firstOrFail();
        
        return view('admin.employees.attendance.index',compact(['record','employees']));
    }


}
