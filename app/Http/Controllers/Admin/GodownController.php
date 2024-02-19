<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GodownController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $search = $request->search;
            
            $godown = Godown::where('name', 'like', "%$search%")
                       ->orWhereHas('location', function ($locationQuery) use ($search) {
                           $locationQuery->where('address', 'like', "%$search%");
                       })
                       ->orWhereHas('user', function ($userQuery) use ($search) {
                           $userQuery->where('name', 'like', "%$search%");
                       })
                       ->get();
            if(!$godown){
                $godown = "";
                return view('admin.godown',compact('godown'));
            }
            return view('admin.godown',compact('godown'));
        }
        $godown = Godown::with('user','location')->get();
        return view('admin.godown',compact('godown'));
    }

    public function add(){
        $location = Location::get();
        return view('forms.add_godown',compact('location'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required','string','max:255'],
            'location' => ['required','numeric','max:100','unique:godown,location_id'],
        ]);
        
        $create_godown = Godown::create([
            'name' => $request->name,
            'location_id' => $request->location,
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/admin/godown')->with('message',"Godown created Successfully");
    }

    public function edit($id){
        $godown = Godown::find($id);
        $location = Location::get();
        return view('forms.update_godown', compact('godown','location','id'));
    }

    public function update($id, Request $request){
        $request->validate([
            'name' => ['required','string','max:255'],
            'location' => ['required','numeric','max:100','unique:godown,location_id,'.$id],
        ]);

        $category = Godown::find($id);
        $add_location = $category->update([
            'name' => $request->name,
            'location_id' => $request->location,
            'user_id' => Auth::user()->id,
        ]);
        return redirect('/admin/godown')->with('message',"Category Updated successfully");
    }

    public function delete($id){
        $category = Godown::find($id);
        $deleted_by = $category->update([
            'deleted_by_user_id' => Auth::user()->id,
        ]);
        $category->delete();

        return redirect('/admin/godown')->with('message',"Category deleted successfully");
    }

    public function trash_data(){
        $godown = Godown::withTrashed()->where('deleted_at','!=',"")->get();
        return view('admin.godown',compact('godown'));
    }

    public function restore_data($id){
        Godown::withTrashed()->find($id)->restore();
        return redirect('/admin/godown');
    }
}
