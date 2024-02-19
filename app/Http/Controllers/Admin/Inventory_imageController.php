<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image_inventory;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Inventory_imageController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $search = $request->search;
            
            $image_inventory = Image_inventory::where(function ($queryBuilder) use ($search) {
                $queryBuilder->whereHas('inventory', function ($inventoryQuery) use ($search) {
                    $inventoryQuery->where('name', 'like', "%$search%");
                });
            })
            ->get();
            if(!$image_inventory){
                $image_inventory = "";
                return view('admin.image_inventory',compact('image_inventory'));
            }
            return view('admin.image_inventory',compact('image_inventory'));
        }
        $image_inventory = Image_inventory::with('inventory')->get();
        return view('admin.image_inventory',compact('image_inventory'));
    }

    public function add(){
        $inventory = Inventory::get();
        return view('forms.add_inventory_images',compact('inventory'));
    }

    protected function storeimage($image){
        $name = $image->getClientOriginalName();
        $image->storeAs("public/images", $name);
        $image_unique_name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension(); 
        return $image_unique_name;
    }

    public function store(Request $request){
        $request->validate([
            'image.*' => ['required','image','mimes:jpg,jpeg,png,gif', 'max:10000'],
            'inventory' => ['required'],
        ]);
        
        foreach($request->file('image') as $image){
            
            $create_godown = Image_inventory::create([
                'inventory_id' => $request->inventory,
                'image_name' => $image->getClientOriginalName(),
                'image_data' => $this->storeimage($image),
            ]);
        }

        return redirect('/admin/inventory_images')->with('message',"Inventory images created Successfully");
    }

    public function edit($id){
        $image_data = Image_inventory::findOrFail($id);
        $inventory = Inventory::get();
        return view('forms.update_inventory_images',compact('inventory','id','image_data'));
    }

    public function update($id, Request $request){
        $image = $request->file('image');
        $image_data = Image_inventory::findOrFail($id);
        $request->validate([
            'inventory' => ['required'],
        ]);
        if(!empty($image)){
            $request->validate([
                'image' => ['required','image','mimes:jpg,jpeg,png,gif', 'max:10000'],
            ]);
            $image_data->image_name = $image->getClientOriginalName();
            $image_data->image_data = $this->storeimage($image);
        }
        
        $image_data->inventory_id = $request->inventory;
        $image_data->save();
        return redirect('/admin/inventory_images')->with('message',"Inventory images updated Successfully");
    }
    public function delete($id){
        $image_data = Image_inventory::find($id);
        $deleted_by = $image_data->update([
            'deleted_by_user_id' => Auth::user()->id,
        ]);
        $image_data->delete();
        return back();
    }

    public function trash_data(){
        $image_inventory = Image_inventory::withTrashed()->where('deleted_at',"!=","")->get();
        return view('admin.image_inventory', compact('image_inventory'));
    }

    public function restore_data($id){
        Image_inventory::withTrashed()->find($id)->restore();
        return redirect('/admin/inventory_images');
    }
}
