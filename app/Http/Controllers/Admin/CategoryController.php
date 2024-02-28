<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        return view('forms.add.category');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => ['required','string','max:255','unique:category,name'],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'name' => $validator->errors()->first('name')
            ]);
        }

        $create = Category::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            'status' => 200,
            redirect('/admin/category')->with('message',"Category created Successfully!"),
        ]);
    }

    public function edit(Request $request){
        $id = $request->id;
        $category = Category::find($id);
        return view('forms.update.category', compact('category','id'));
    }

    public function update(Request $request){
        $id = $request->id;
        $validator = Validator::make($request->all(),[
            'name' => ['required','string','max:255','unique:category,name,'. $id],
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'name' => $validator->errors()->first('name')
            ]);
        }

        $category = Category::find($id);
        $add_location = $category->update([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
        ]);
        return response()->json([
            'status' => 200,
             redirect('/admin/category')->with('message',"Category Updated successfully")
        ]);
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


    // _________Add Controller__________
    public function addCategory(){
        return view('admin.pages.category.add');
    }

    public function storeCategory(Request $request){
        try{
            $credentials = Validator::make($request->all(),[
                'name' => 'required'
            ]);

            if($credentials->errors()->first('name')){
                return response()->json([
                    'status' => false,
                    'message' => $credentials->errors()->first('name'),
                ]);
            }
            $cateogry = new Category;
            $checkCategoryExists = $cateogry->checkCategoryExists($request);
            if($checkCategoryExists){
                return [
                    'status' => false,
                    'message' => __("Category already exists.")
                ];
            }
            $category = $cateogry->storeCategory($request);
            if($category){
                if($request->id){
                    return response()->json([
                        'status'=>true,
                        'message'=> __("Category updated successfully."),
                        'redirect' => route('admin.category')
                    ]);
                }
                return response()->json([
                    'status'=> true,
                    'message' => __("Category created successfully."),
                    'redirect' => route('admin.category'),
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => __("Category not saved."),
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function categoryLists(){
        try{
            $category = Category::get();
            return view('admin.pages.category.lists',compact('category'))->render();
        }catch(Exception $e){
            return [
                'status'=>false,
                'message'=>$e->getMessage()
            ];
        }
    }
    public function showCategory(){
        try{
            return view('admin.pages.category.show');
        }catch(Exception $e){
            return [
                'status'=>false,
                'message'=>$e->getMessage()
            ];
        }
    }
}
