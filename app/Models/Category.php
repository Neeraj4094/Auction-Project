<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "category";
    protected $fillable = [
        'name',
        'user_id',
        'deleted_by_user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function checkCategoryExists($request){
        $category = Category::where('name',$request->name)->first();
        return $category;
    }

    public function storeCategory($request){
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if(@$request->id){
            return self::where(['id'=>$request->id])->update($data);
        }

        return self::create($data);
    }
}
