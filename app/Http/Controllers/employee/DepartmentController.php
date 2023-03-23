<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Repositories\SaveRepository;
use App\Repositories\ValidationRepository;
use Illuminate\Http\Request;
use yajra\Datatables\DataTables;

class DepartmentController extends Controller
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
        return view('admin.employees.department.index');
    }

    public function save(Request $request, $id = null)
    {
        $this->vr->isValidDepartment($request,$id);

        $status = $this->save->Department($request,$id);

        if ($status == 'success') {
            if (!empty($id)) {
                return redirect(route('departments'))->with(['success' => 'successfully saved']);
            }
            return back()->with(['success' => 'successfully saved']);
        } else {
            return back()->with(['errors_' => $status]);
        }
    }

    public function datatable()
    {
        $info = Department::withTrashed()->with( 'createdby', 'updatedby', 'deletedby')->orderby('id', 'DESC');

        return DataTables::of($info)
            ->editColumn('name', function ($data) {
                return ConvertToLang($data);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('name_l', 'like', '%' . $keyword . '%');
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
                $edit_url = route('department.edit', $data->id);
                $block = route('department.block', $data->id);
                $unblock = route('department.unblock', $data->id);

                $html = '<div class="text-center">';

                    if (empty($data->deleted_at)) {
                        $html .= '<a  href="' . $edit_url . '">' . '<i class="fas fa-edit"></i>' . '</a>';
                 
                            $html .= '<a onclick="return confirm(\'' . __('msg.block_this_department?') . ' \')" href="' . $block . '">' .'<span style="margin-left:10px;"><i class="fas fa-lock  text-danger"></i></span>' . '</a>'  ;
                       
                    } else {
                        $html .= '<a onclick="return confirm(\'' . __('msg.unblock_this_department?') . ' \')" href="' . $unblock . '">' . '<i class="fas fa-unlock text-success"></i>' . '</a>';
                    }
               
                $html .= '</ul></div>';
                return $html; 
            })
            ->rawColumns(['name', 'deleted_at', 'created_at', 'action'])
            ->make(true);
    }

    public function edit($id)
    {
        $record = Department::where('id', $id)->firstOrFail();
        
        return view('admin.employees.department.index',compact('record'));
    }

    public function block($id)
    {
        $status = $this->save->BlockDepartment($id);
        if ($status == 'success') {
            return redirect(route('departments'))->with(['success' => 'successfully saved']);
        } else {
            return back()->with(['errors_' => $status]);
        }
    }

    public function unblock($id)
    {
        $status = $this->save->UnblockDepartment($id);
        if ($status == 'success') {
            return redirect(route('departments'))->with(['success' => 'successfully saved']);
        } else {
            return back()->with(['errors_' => $status]);
        }
    }
}
