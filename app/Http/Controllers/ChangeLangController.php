<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeLangController extends Controller
{
    public function index(Request $request)
    {
        session()->put('locale',$request->lang);
        if(!Auth::check()) {
           $id   = Auth::user()->id;
           $info = User::find($id);
           dd($info);
           try {
                $info->default_lan = $request->lang;
                $info->save();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        return redirect()->back();
    }
}
