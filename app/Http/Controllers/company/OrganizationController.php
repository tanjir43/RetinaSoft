<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Repositories\SaveRepository;
use App\Repositories\ValidationRepository;
use Illuminate\Http\Request;

class OrganizationController extends Controller
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
        return view('admin.company.organization.index');
    }

    public function save(Request $request, $id = null)
    {
        $this->vr->isValidOrganization($request,$id);
        if($request->hasFile('file')) {
            $this->vr->isValidFile($request);
        }
        $status = $this->save->Organization($request,$id);

        if($status == 'success') {
            if(!empty($id)) {
                return redirect(route('organization'));
            }
            return back();
        } else {
            return back();
        }
    }
    
}
