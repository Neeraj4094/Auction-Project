<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index(Request $request){
        
        $users = User::where("role","manager")->get();
        $btn_name = "User Trash Data";
        if($request->search){
            $users = User::where('name',"LIKE",'%'.$request->search.'%')->Orwhere('email',"LIKE",'%'.$request->search.'%')->Orwhere('address',"LIKE",'%'.$request->search.'%')->get();
            return view('admin.dashboard',compact('users'));
        }
        return view('manager.dashboard',compact('users'));
    }
}
