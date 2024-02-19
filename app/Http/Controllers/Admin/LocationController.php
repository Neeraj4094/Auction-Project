<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function add(){
        return view('forms.location');
    }
 
    public function store(Request $request){
        if(Auth::user()->role != "admin"){
            abort(403);
        }
        $request->validate([
            'location' => 'required|unique:location,address',
        ]);
        
        $location = Location::create([
            'user_id' => Auth::user()->id,
            'address' => $request->location,
        ]);
        return redirect('/admin/location')->with('message',"Location added successfully");
    }

    public function show(Request $request){
        if($request->search){
            $location = Location::where('address',"LIKE",'%'.$request->search.'%')->get();
            if(!$location){
                $location = "";
                return view('admin.location',compact('location'));
            }
            return view('admin.location',compact('location'));
        }
        $location = Location::get();
        return view('admin.location', compact('location'));
    }

    public function edit($id){
        $location= Location::find($id);
        return view('forms.update_location',compact('location','id'));
    }

    public function update($id, Request $request){
        if(Auth::user()->role != "admin"){
            abort(403);
        }
        $request->validate([
            'location' => 'required|unique:location,address,'. $id,
        ]);
        
        $location = Location::find($id);
        $add_location = $location->update([
            'user_id' => Auth::user()->id,
            'address' => $request->location,
        ]);
        return redirect('/admin/location')->with('message',"Location Updated successfully");
    }

    public function delete($id){
        Location::find($id)->delete();
        return back();
    }

    public function trash_data(){
        $location = Location::withTrashed()->where('deleted_at',"!=","")->get();
        return view('admin.location', compact('location'));
    }

    public function restore_data($id){
        Location::withTrashed()->find($id)->restore();
        return redirect('/admin/location');
    }
}
