<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "events";
    protected $fillable = [
        'event_code',
        'name',
        'user_id',
        'location_id',
        'category_id',
        'deleted_by_user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
