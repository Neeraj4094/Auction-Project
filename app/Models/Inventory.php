<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "inventory";
    protected $fillable = [
        'inventory_code',
        'name',
        'category_id',
        'user_id',
        'description',
        'price',
        'position',
        'deleted_by_user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function auction(){
        return $this->hasOne(Auction::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
