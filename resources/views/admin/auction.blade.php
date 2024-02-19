<x-app-layout>
    <div class="w-full">
        <div class="flex items-center justify-between  p-2 py-4 border-b w-full h-full px-3">
            
            <div class="grid space-y-3">
                <h2 class="text-2xl font-bold">Manage Admin Records</h2>
                <form action="{{url('/admin/auction')}}" method="get" class="relative">
                    <input type="search" name="search" id="search" class="p-1 border rounded-md" placeholder="Search...">
                    <button type="submit" class=" border rounded-r-md bg-slate-100 h-full">search</button>
                </form>
            </div>
            
            <div class="flex gap-4">
                <a href="{{url('/auction/add')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">Add AUction</span>
                </a>
                <a href="{{url('/auction/trash_data')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">Auction Trash Data</span>
                </a>
            </div>
        </div>
        @if(count($auction)>0)
        
        <div class="border p-3 overflow-y-scroll h-[360px]">
               @foreach($auction as $data)

               @php
                    $event = DB::table('events')->where('id',$data->event_id)->first();
                    $user = DB::table('users')->where('id',$data->user_id)->first();
                    $inventory_id = explode(',',$data->inventory_ids);
                
                @endphp
                <div class="border rounded-lg grid grid-cols-2 p-2">
                    <div class="grid">
                        <span>Event Name :- {{$event->name}}</span>
                        <span>User Name :- {{$user->name}}</span>
                @foreach($inventory_id as $id)
                @php
                    $inventory = DB::table('inventory')->where('id',$id)->first();
                @endphp
                        <span>Inventory Name :- {{$inventory->name}}</span> 
                @endforeach
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <div class="grid">
                            <span>Created Date :- {{$user->created_at}}</span>
                            <span>Updated Date :- {{$user->updated_at}}</span>
                        </div>
                        <span class="px-2 py-1 bg-blue-600 text-white rounded-md">{{($user->status === 1) ? "Active" : "Blocked" }}</span>
                        
                        @if(!empty($data[0]->deleted_at))
                        <form action="{{url('/auction/restore',['id'=>$user->id])}}" method="post">
                        @csrf
                            <button type="submit">Restore</button>
                        </form>
                        <form action="{{url("/auction/delete/$user->id")}}" method="post">
                        @csrf
                            <button type="submit">Delete</button>
                        </form>
                        @else
                        <a href="{{url('/auction/edit',['id'=>$user->id,'user_id'=>auth()->user()->id])}}">
                            <button type="submit">Edit</button>
                        </a>
                        <form action="{{url("/auction/delete/$user->id")}}" method="post">
                        @csrf
                            <button type="submit">Delete</button>
                        </form>
                    @endif
                    </div>
                </div>
                
                @endforeach
            @else
                <p class="text-center p-36 text-slate-500">Data not found</p>
            @endif
        </div>
    </div>
</x-app-layout>
