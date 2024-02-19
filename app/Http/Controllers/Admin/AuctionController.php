<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Auction_inventory;
use App\Models\Events;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index(request $request){
        $auction_event_id = Auction::distinct('event_id')->pluck('event_id');
        if($request->search){
            $search = $request->search;
            
            $auction = Auction::select('event_id', 'user_id', \DB::raw('GROUP_CONCAT(inventory_id) as inventory_ids'))
                ->groupBy('event_id', 'user_id')
                ->havingRaw('COUNT(*) > 1')
                ->where(function ($queryBuilder) use ($search) {
                    $queryBuilder->whereHas('event', function ($eventQuery) use ($search) {
                            $eventQuery->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('inventory', function ($inventoryQuery) use ($search) {
                            $inventoryQuery->where('name', 'like', "%$search%");
                        });
                })
                ->get();
                
            if(!$auction){
                $auction = "";
                return view('admin.auction',compact('auction'));
            }
            return view('admin.auction',compact('auction'));
        }
        $auction = Auction::select('event_id', 'user_id', \DB::raw('GROUP_CONCAT(inventory_id) as inventory_ids'))
        ->groupBy('event_id', 'user_id')
        ->havingRaw('COUNT(*) > 1')
        ->get();
    
        return view('admin.auction',compact('auction'));
    }

    public function add(){
        $inventory = Inventory::get();
        return view('forms.add_auction',compact('inventory'));
    }

    public function create(Request $request){
        $request->validate([
            'start_time' => ['required', 'date', 'after:now'],
            'items' => ['required'],
            'items.*' => ['required','integer','exists:inventory,id'],
        ]);
        $items = $request->input('items',[]);
        $event = Events::latest()->first();
        
        $code = uniqid();
        foreach($items as $item){
            $auction = Auction::create([ 
                // 'auction_code' => $code,
                'auction_code' => uniqid(),
                'user_id' => Auth::user()->id,
                'event_id' => $event->id,
                'inventory_id' => $item,
                'event_start_time' => $request->start_time,
                'event_end_time' => now()->parse($request->start_time)->addHours(1),
            ]);
        }

        // $auctiondata = Auction::where('auction_code',$code)->first();
        // foreach($items as $item){
        //     $auction_inventory = Auction_inventory::create([
        //         'inventory_id' => $item,
        //         'auction_id' => $auctiondata->id,
        //     ]);
        // }

        return redirect('/admin/auction')->with('message',"Auction created Successfully");
    }

    public function trash_data(){
        $auction = Auction::select('event_id', 'user_id', \DB::raw('GROUP_CONCAT(inventory_id) as inventory_ids'))
        ->groupBy('event_id', 'user_id')
        ->havingRaw('COUNT(*) > 1')
        ->where('deleted_at', "!=", "")
        ->get();
        return view('admin.auction',compact('auction'));
    }

    public function delete($id){
        $auction = Auction::find($id);
        if(!$auction){
            return back()->with('error',"Auction not exists");
        }
        $delete = $auction->delete();
        return back()->with('message',"Auction deleted Successfull");
    }

}
