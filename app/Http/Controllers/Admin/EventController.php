<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Events;
use App\Models\Inventory;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $search = $request->search;
            
            $event = Events::where('name', 'like', "%$search%")
                        ->orWhereHas('category', function ($locationQuery) use ($search) {
                            $locationQuery->where('name', 'like', "%$search%");
                        })
                       ->orWhereHas('location', function ($locationQuery) use ($search) {
                           $locationQuery->where('address', 'like', "%$search%");
                       })
                       ->orWhereHas('user', function ($userQuery) use ($search) {
                           $userQuery->where('name', 'like', "%$search%");
                       })
                       ->get();
            if(!$event){
                $event = "";
                return view('admin.events',compact('event'));
            }
            return view('admin.events',compact('event'));
        }
        $event = Events::with('user')->with('location')->with('category')->get();
        return view('admin.events',compact('event'));
    }

    public function add(){
        $location = Location::get();
        $category = Category::get();
        return view('forms.add_events',compact('location','category'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required','string','max:255'],
            // 'start_time' => ['required', 'date', 'after:now'],
            'location' => ['required'],
            'category' => ['required'],
        ]);

        $check_event = Events::where('category_id',$request->category)->first();
    
        if(!empty($check_event) && ($check_event->location_id == $request->location && $check_event->status == 1)){
            return back()->with('error',"This event is already alotted to your selected location");
        }
        $create_event = Events::create([
            'event_code' => uniqid(),
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'location_id' => $request->location,
            'category_id' => $request->category,
        ]);

        return redirect('/admin/auction/add');
        
    }

    public function edit($id,$user_id = null){
        $location = Location::get();
        $category = Category::get();
        $event = Events::find($id);
        $user = (!empty($user_id)) ? $user_id : "";
        return view('forms.update_events',compact('location','category','event','id','user'));
    }

    public function update($id, Request $request){
        $request->validate([
            'name' => ['required','string','max:255'],
            // 'start_time' => ['required', 'date', 'after:now'],
            'location' => ['required'],
            'category' => ['required'],
        ]);

        $check_event = Events::find($request->event);
        if(!empty($check_event) && ($check_event->location_id == $request->location)){
            return back()->with('error',"This event is already alotted to your seected location");
        }
        $event = Events::find($id);
        if(!empty($request->user_id)){
            $inventory = Inventory::find($id);
            $category = Category::get();
            return view('forms.update_inventory', compact('inventory','category','id'));
        }
        $update_event = $event->update([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
            'location_id' => $request->location,
            'category_id' => $request->category,
        ]);

        $event = Events::where('name',$request->name)->pluck('id');
        $inventory = Inventory::get();
        return view('froms.add_auction',compact('event','inventory'));
    }

    public function delete($id){
        $category = Events::find($id);
        $deleted_by = $category->update([
            'deleted_by_user_id' => Auth::user()->id,
        ]);
        $category->delete();

        return redirect('/admin/event')->with('message',"Event deleted successfully");
    }

    public function trash_data(){
        $event = Events::withTrashed()->where('deleted_at','!=',"")->get();
        return view('admin.events',compact('event'));
    }

    public function restore_data($id){
        Events::withTrashed()->find($id)->restore();
        return redirect('/admin/event');
    }
}
