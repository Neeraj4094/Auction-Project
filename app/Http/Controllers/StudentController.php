<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        return view('show_student');
    }

    public function add(){
        return view('add_student');
    }

    public function store(Request $request){
        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalName();
        $filepath = $file->storeAs('images',$filename,'public');

        $add = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $filepath,
        ]);
        // $add_student = Student::add_student($request);
        
        return response()->json(['res'=>'ok']);
    }

    public function allstudent(){
        $student = Student::get();
        return response()->json(['student'=>$student]);
    }

    public function edit($id){
        $student = Student::find($id)->first();
        return view('edit_user',compact('student'));
    }

    public function update(Request $request){
        $student = Student::find($request->id);
        $student->name = $request->name;
        $student->email = $request->email;

        if($request->file('file')){

            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalName();
            $filepath = $file->storeAs('images',$filename,'public');
            $student->image = $filepath;
        }
        $student->save();

        return response()->json(['result'=>'Student Updated Successfully']);
    }

    public function delete($id){
        Student::find($id)->delete();
        return response()->json(['result'=>'Student Deleted Successfully!']);
    }
}
