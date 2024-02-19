<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image_inventory extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "inventory_images";
    protected $fillable = [
        'inventory_id',
        'image_name',
        'image_data',
        'deleted_by_user_id'
    ];

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }
}
