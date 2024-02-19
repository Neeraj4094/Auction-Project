<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction_inventory extends Model
{
    use HasFactory;

    protected $table = "auction_inventory";
    protected $fillable = [
        'inventory_id',
        'auction_id',
    ];
}
