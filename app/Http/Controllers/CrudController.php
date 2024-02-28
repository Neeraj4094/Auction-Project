<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    public function create(){
        return view('crud.create');
    }
    
    public function show(){
        $students = Student::all();
        return view('crud.show');
    }
    public function get_students_data(){
        $employee = Employee::all();
        return response()->json([
            'employee'=>$employee
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:employees,email',
            'image' => 'required|max:10000|file',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors'=>[
                    'name' => $validator->errors()->first('name'),
                    'email' => $validator->errors()->first('email'),
                    'image' => $validator->errors()->first('image'),
                ],
            ]);
        }

        $file = $request->file('image');
        $filename = time() . $file->getClientOriginalName();
        $filepath = $file->storeAs('images',$filename,'public');
        
        $employee = new Employee;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->image = $filepath;
        $employee->save();

        return response()->json([
            'status' => 200,
            'message'=> "Student created Successfully!"
        ]);
    }

    public function edit_employee($id){
        $employee = Employee::find($id);
        return view('crud.update',compact('employee'));
    }

    public function update_employee(Request $request){
        $id = $request->id;
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:employees,email,'. $id,
        ]);
        if($request->file('image')){
            $validator = Validator::make($request->all(),[
                'image' => 'required|max:10000|file',
            ]);
        }
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors'=>[
                    'name' => $validator->errors()->first('name'),
                    'email' => $validator->errors()->first('email'),
                    'image' => $validator->errors()->first('image'),
                ],
            ]);
        }
        $employee = Employee::find($id);

        if($request->file('image')){
            $file = $request->file('image');
            $filename = time() . $file->getClientOriginalName();
            $update['image'] = $file->storeAs('images',$filename,'public');
        }
        $update['name'] = $request->name;
        $update['email'] = $request->email;
        $update = $employee->update($update);

        return response()->json([
            'status' => 200,
            'message' => 'Data Updated Successfully'
        ]);
    }

    public function delete_employee($id){
        $employee = Employee::find($id);
        if(empty($employee)){
            return response()->json([
                'status' => 400,
                'error' => 'This account does not exist',
            ]);
        }
        $employee->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Account deleted Successfully!',
        ]);
    }



    // AJAX Start
    public function add(){
        return view('crud.add');
    }
}
