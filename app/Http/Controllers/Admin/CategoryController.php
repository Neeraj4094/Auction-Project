<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request){
        if($request->search){
            $category = Category::where('name',"LIKE",'%'.$request->search.'%')->get();
            if(!$category){
                $category = "";
                return view('admin.category',compact('category'));
            }
            return view('admin.category',compact('category'));
        }
        $category = Category::with('user')->get();
        
        return view('admin.category',compact('category'));
    }

    public function add(){
        return view('forms.add_category');
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required','string','max:255','unique:category,name'],
        ]);

        $create = Category::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/admin/category')->with('message',"Category created Successfully");
    }

    public function edit($id){
        $category = Category::find($id);
        return view('forms.update_category', compact('category','id'));
    }

    public function update($id, Request $request){
        $request->validate([
            'name' => ['required','string','max:255','unique:category,name,'. $id],
        ]);

        $category = Category::find($id);
        $add_location = $category->update([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
        ]);
        return redirect('/admin/category')->with('message',"Category Updated successfully");
    }

    public function soft_delete($id){
        $category = Category::find($id);
        $deleted_by = $category->update([
            'deleted_by_user_id' => Auth::user()->id,
        ]);
        $category->delete();

        return redirect('/admin/category')->with('message',"Category deleted successfully");
    }

    public function category_trash_data(Request $request){
        if($request->search){
            $category = Category::where('name',"LIKE",'%'.$request->search.'%')->get();
            if(!$category){
                $category = "";
                return view('admin.category',compact('category'));
            }
            return view('admin.category',compact('category'));
        }
        $category = Category::withTrashed()->where('deleted_at','!=',"")->get();
        return view('admin.category',compact('category'));
    }

    public function restore_data($id){
        Category::withTrashed()->find($id)->restore();
        return redirect('/admin/category');
    }
}
