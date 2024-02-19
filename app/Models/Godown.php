<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Godown extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "godown";
    protected $fillable = [
        'name',
        'location_id',
        'user_id',
        'deleted_by_user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
