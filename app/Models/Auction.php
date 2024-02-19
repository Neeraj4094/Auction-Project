<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $table = "auction";
    protected $fillable = [
        'auction_code',
        'user_id',
        'event_id',
        'inventory_id',
        'event_start_time',
        'event_end_time',
        'deleted_by_user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function event(){
        return $this->belongsTo(Events::class);
    }

    public function inventory(){
        return $this->belongsTo(Inventory::class, 'inventory_id','id');
    }
}
