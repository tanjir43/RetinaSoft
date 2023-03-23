<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Repositories\SaveRepository;
use App\Repositories\ValidationRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
        return view('admin.employees.employee.index');
    }
}
