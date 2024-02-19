<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admintest(){
        // if(Auth::guard()->user()->role == "admin"){
        //     dd("ok");
        // }else{
        //     abort(403);
        // }
        if(\Gate::allows('admin',auth()->user())){
            echo ("admin");
        }
        else{
        abort(403);
        }
        // if(\Gate::forUser(Auth::guard('admin')->user())->allows('admin')){
            
        // }
    }
    public function editortest(){
        if(\Gate::allows('admin',auth()->user())){
            echo ("admin");
        }
        else{
        abort(403);
        }
        if(Auth::guard()->user()->role == "editor"){
            echo "editor";
        }else{
            abort(403);
        }
    }
}
