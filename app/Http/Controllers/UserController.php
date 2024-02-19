<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        if(Auth::user()->role === "admin"){
            $users = User::where("role","admin")->get();
        }elseif(Auth::user()->role === "manager"){
            $users = User::where("role","manager")->get();
        }else{
            $users = User::where("role","employee")->get();
        }

        $btn_name = "User Trash Data";
        if($request->search){
            $users = User::where('name',"LIKE",'%'.$request->search.'%')->Orwhere('email',"LIKE",'%'.$request->search.'%')->Orwhere('address',"LIKE",'%'.$request->search.'%')->get();
            return view('admin.dashboard',compact('users'));
        }
        return view('employee.dashboard',compact('users'));
    }

    public function edit($id){
        $url = "/update/$id";
        $user = User::find($id);
        return view('forms.update_user', compact('url','user'));
    }
    public function update($id,Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class . ",email,$id"],
            'password' => ['required'],
            'address' => ['required'],
            'role' => ['required'],
        ]);

        $user = User::find($id);
        $update_user = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role' => $request->role
        ]);

        if(Auth::user()->role === "admin"){
            return redirect('/admin/dashboard')->with('message',"Account Updated Successfully");
        }elseif(Auth::user()->role === "manager"){
            return redirect('/manager/dashboard')->with('message',"Account Updated Successfully");
        }else{
            return redirect('/dashboard')->with('message',"Account Updated Successfully");
        }
    }

    public function add_user(){
        $url = "/create";
        return view('forms.add_user',compact('url'));
    }

    public function delete($id){
        User::find($id)->delete();
        if(Auth::user()->role === "admin"){
            return redirect('/admin/dashboard');
        }elseif(Auth::user()->role === "manager"){
            return redirect('/manager/dashboard');
        }else{
            return redirect('/employee/dashboard');
        }
    }

    public function trash_data(Request $request){
        if($request->search){
            $users = User::where('name',"LIKE",'%'.$request->search.'%')->Orwhere('email',"LIKE",'%'.$request->search.'%')->Orwhere('address',"LIKE",'%'.$request->search.'%')->get();
            return view('admin.dashboard',compact('users'));
        }
        if(Auth::user()->role === "admin"){
            $users = User::withTrashed()->where('deleted_at',"!=","")->where('role','admin')->get();
            return view('admin.dashboard',compact('users'));
        }elseif(Auth::user()->role === "manager"){
            $users = User::withTrashed()->where('deleted_at',"!=","")->where('role','manager')->get();
            return view('manager.dashboard',compact('users'));
        }else{
            $users = User::withTrashed()->where('deleted_at',"!=","")->where('role','employee')->get();
            return view('employee.dashboard',compact('users'));
        }
    }
    public function restore_data($id){
        User::withTrashed()->find($id)->restore();
        return redirect()->back();
    }
}
