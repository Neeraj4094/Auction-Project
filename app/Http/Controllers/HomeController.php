<?php
namespace App\Http\Controllers;
use App\Models\Auction;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Your controller code here
    public function index(){
        return view('user.home');
    }

    public function auction_details(){
        $auction_event_id = Auction::distinct('event_id')->pluck('event_id');
        $auction = Auction::select('event_id', 'user_id', \DB::raw('GROUP_CONCAT(inventory_id) as inventory_ids'))
        ->groupBy('event_id', 'user_id')
        ->havingRaw('COUNT(*) > 1')
        ->get();
        return view('user.auction_details',compact('auction'));
    }

    public function view_inventory(Request $request){
        // $auction_event_id = Auction::distinct('event_id')->pluck('event_id');
        // $auction = Auction::select('event_id', 'user_id', \DB::raw('GROUP_CONCAT(inventory_id) as inventory_ids'),'event_start_time','event_end_time')
        // ->groupBy('event_id', 'user_id','event_start_time','event_end_time')
        // ->havingRaw('COUNT(*) > 1')
        // ->get();
        $auction = Auction::with('user','event','inventory')->where('event_id',$request->event)->get();
        return view('user.auction_inventory',compact('auction'));
    }

    public function buy_now(){
        return view('user.buy');
    }
}

