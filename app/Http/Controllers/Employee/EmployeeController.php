<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request){
        
        $users = User::where("role","employee")->get();
        $btn_name = "User Trash Data";
        if($request->search){
            $users = User::where('name',"LIKE",'%'.$request->search.'%')->Orwhere('email',"LIKE",'%'.$request->search.'%')->Orwhere('address',"LIKE",'%'.$request->search.'%')->get();
            return view('admin.dashboard',compact('users'));
        }
        return view('employee.dashboard',compact('users'));
    }
}
