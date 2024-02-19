<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request) {
        $users = User::get();
        $btn_name = "User Trash Data";
        if($request->search){
            $users = User::where('name',"LIKE",'%'.$request->search.'%')->Orwhere('email',"LIKE",'%'.$request->search.'%')->Orwhere('address',"LIKE",'%'.$request->search.'%')->get();
            return view('admin.dashboard',compact('users','btn_name'));
        }
        return view('admin.dashboard',compact('users','btn_name'));
    }

    public function edit($id){
        $url = "/admin/update/$id";
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

        return redirect('/admin/dashboard')->with('message',"Account Updated Successfully");
    }

    public function add_user(){
        $url = "/create";
        return view('forms.add_user',compact('url'));
    }

    public function delete($id){
        User::find($id)->delete();
        return redirect('/admin/dashboard');
    }

    public function trash_data(Request $request){
        if($request->search){
            $users = User::where('name',"LIKE",'%'.$request->search.'%')->Orwhere('email',"LIKE",'%'.$request->search.'%')->Orwhere('address',"LIKE",'%'.$request->search.'%')->get();
            return view('admin.dashboard',compact('users','btn_name'));
        }
        $users = User::withTrashed()->where('deleted_at',"!=","")->get();
        $btn_name = "User Data";
        return view('admin.dashboard',compact('users','btn_name'));
    }
    public function restore_data($id){
        User::withTrashed()->find($id)->restore();
        return redirect()->back();
    }
}
