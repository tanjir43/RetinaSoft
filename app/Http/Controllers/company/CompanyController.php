<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\SaveRepository;
use App\Repositories\ValidationRepository;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;

class CompanyController extends Controller
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
        return view('admin.company.index');
    }

    public function save(Request $request, $id = null)
    {
        $this->vr->isValidCompany($request,$id);

        $status = $this->save->Company($request,$id);

        if($status == 'success') {
            if(!empty($id)) {
                return redirect(route('organization'));
            }
            return back();
        } else {
            return back();
        }
    }

    public function datatable()
    {
        if (!$this->have_permission(20)) {
            return response()->json(['errors' => [__('msg.access_deny')]]);
        }

        $info = Company::withTrashed()->with( 'created_by', 'updated_by', 'deleted_by')->orderby('id', 'DESC');

        return Datatables::of($info)
            ->editColumn('name', function ($data) {
                return ConvertToLang($data);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('name_bn', 'like', '%' . $keyword . '%')
                    ->orWhere('nid', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('address', 'like', '%' . $keyword . '%');
            })
            ->editColumn('address', function ($data) {
                $html = '';
                if (!empty($data->customer_type)) {
                    $html .= '<span class="badge badge-pill badge-success">' . ConvertToLang($data->customer_type) . '</span>';
                }
                if (!empty($data->nid)) {
                    $html .= '<br>NID/others : ' . $data->nid;
                }
                $html .= '<br>' . __('msg.phone') . ' : ' . $data->phone;
                if (!empty($data->email)) {
                    $html .= '<br>' . __('msg.email') . ' : ' . $data->email;
                }
                if (!empty($data->address)) {
                    $html .= '<br>' . __('msg.address') . ' : ' . $data->address;
                }
                return $html;
            })
            ->editColumn('deleted_at', function ($data) {
                if (empty($data->deleted_at)) {
                    return '<span class="badge badge-success">' . __('msg.running') . '</span>';
                } else {
                    $html= '<p class="text-center"><span class="badge badge-danger">'.__('msg.closed').'</span>';
                    if ($data->deletedby) {
                        $html.= '<br><span class="badge badge-danger mt-1">'.$data->deletedby->name.'</span></p>';
                    }
                    return $html;                }
            })
            ->editColumn('created_at', function ($data) {
                $html = '<span class="badge badge-pill badge-success">' . $data->created_at . '</span>';
                if (!empty($data->createdby)) {
                    $html .= '<br><span class="badge badge-success">' . $data->createdby->name . '</span>';
                }
                if ($data->created_at != $data->updated_at) {
                    $html .= '<br><span class="badge badge-pill badge-warning mt-1" style="margin-top: 5px">' . $data->updated_at . '</span>';
                    if (!empty($data->updatedby)) {
                        $html .= '<br><span class="badge badge-warning">' . $data->updatedby->name . '</span>';
                    }
                }
                return $html;
            })
            ->addColumn('action', function ($data) {
                $edit_url = route('customer.edit', $data->id);
                $block = route('customer.block', $data->id);
                $unblock = route('customer.unblock', $data->id);

                $html = '<div class="btn-group float-right" role="group">
                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                ' . __('msg.action') . ' <span class="caret"></span>
                            </button>
                            <div class="dropdown-menu">';
                if (have_permission(51)) {
                    if (empty($data->deleted_at)) {
                        $html .= '<a class="dropdown-item" href="' . $edit_url . '">' . __('msg.edit') . '</a>';
                        if ($this->have_permission(52)) {
                            $html .= '<a class="dropdown-item" onclick="return confirm(\'' . __('msg.block_this_user?') . ' \')" href="' . $block . '">' . __('msg.block') . '</a>';
                        }
                    } else {
                        $html .= '<a class="dropdown-item" onclick="return confirm(\'' . __('msg.unblock_this_user?') . ' \')" href="' . $unblock . '">' . __('msg.unblock') . '</a>';
                    }
                }
                $html .= '</div></div>';
                return $html;
            })
            ->rawColumns(['name', 'deleted_at', 'created_at', 'address', 'action'])
            ->make(true);
    }
}
