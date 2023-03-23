<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $current_user = User::where('id',$user)->with('employee')->first();
        #dd($current_user);
        return view('user.dashboard',compact('current_user'));
    }
}
