<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Student extends Model
{
    use HasFactory;
    protected $table = "students";
    protected $fillable = [
        'name',
        'email',
        'image'
    ];

    public function add_student($request){
        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalName();
        $filepath = $file->storeAs('images',$filename,'public');

        $add = self::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $filepath,
        ]);
    }
}
