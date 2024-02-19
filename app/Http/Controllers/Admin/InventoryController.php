<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $search = $request->search;
            
            $inventory = Inventory::where('name', 'like', "%$search%")
                    ->orWhereHas('category', function ($locationQuery) use ($search) {
                        $locationQuery->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%$search%");
                    })
                    ->get();

            if(!$inventory){
                $inventory = "";
                return view('admin.inventory',compact('inventory'));
            }
            return view('admin.inventory',compact('inventory'));
        }
        $inventory = Inventory::with('user','category')->get();
        return view('admin.inventory',compact('inventory'));
    }

    public function add(){
        $category = Category::get();
        return view('forms.add_inventory',compact('category'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required','string','max:255'],
            'category' => ['required'],
            'price' => ['required','numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'position' => ['required'],
            'desc' => ['required','string', 'max:1000'],
        ]);
        
        $create_godown = Inventory::create([
            'inventory_code' => uniqid(),
            'name' => $request->name,
            'category_id' => $request->category,
            'user_id' => Auth::user()->id,
            'description' => $request->desc,
            'price' => $request->price,
            'position' => $request->position,
        ]);

        return redirect('/admin/inventory')->with('message',"Inventory created Successfully");
    }

    public function edit($id){
        $inventory = Inventory::find($id);
        $category = Category::get();
        return view('forms.update_inventory', compact('inventory','category','id'));
    }
    public function update($id,Request $request){
        
        $request->validate([
            'name' => ['required','string','max:255'],
            'category' => ['required'],
            'price' => ['required','numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'position' => ['required'],
            'desc' => ['required','string', 'max:1000'],
        ]);

        $inventory = Inventory::findOrFail($id);
        $update_inventory = $inventory->update([
            'name' => $request->name,
            'category_id' => $request->category,
            'user_id' => Auth::user()->id,
            'description' => $request->desc,
            'price' => $request->price,
            'position' => $request->position,
        ]);
        return redirect('/admin/inventory')->with('message',"Inventory updated Successfully");
    }

    public function delete($id){
        $inventory = Inventory::find($id);
        $deleted_by = $inventory->update([
            'deleted_by_user_id' => Auth::user()->id,
        ]);
        $inventory->delete();
        return back();
    }

    public function trash_data(){
        $inventory = Inventory::withTrashed()->where('deleted_at',"!=","")->get();
        return view('admin.inventory', compact('inventory'));
    }

    public function restore_data($id){
        Inventory::withTrashed()->find($id)->restore();
        return redirect('/admin/inventory');
    }
}
