<x-app-layout>
    <div class="w-full">
        <div class="flex items-center justify-between  p-2 py-4 border-b w-full h-full px-3">
            
            <div class="grid space-y-3">
                <h2 class="text-2xl font-bold">Manage Admin Records</h2>
                <form action="{{url('/admin/location')}}" method="get" class="relative">
                    <input type="search" name="search" id="search" class="p-1 border rounded-md" placeholder="Search...">
                    <button type="submit" class=" border rounded-r-md bg-slate-100 h-full">search</button>
                </form>
            </div>
            
            <div class="flex gap-2">
                <a href="{{url('/home')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">Home</span>
                </a>
                <a href="{{url('/admin/location/trash_data')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">Location Trash Data</span>
                </a>
            </div>
        </div>
        <div class="border p-3 overflow-y-scroll h-[360px]">
            @if(count($location)>0)
                @foreach($location as $user)
                <div class="border rounded-lg grid grid-cols-2 p-2">
                    <div class="grid">
                        <span>Location Address :- {{$user->address}}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <div class="grid">
                            <span>Created Date :- {{$user->created_at}}</span>
                            <span>Updated Date :- {{$user->updated_at}}</span>
                        </div>
                        <span class="px-2 py-1 bg-blue-600 text-white rounded-md">{{($user->status === 1) ? "Active" : "Blocked" }}</span>
                    
                        <form action="{{url('/admin/location/restore',['id'=>$user->id])}}" method="post">
                        @csrf
                            <button type="submit">Restore</button>
                        </form>
                        <form action="{{url("/admin/delete/$user->id")}}" method="post">
                        @csrf
                            <button type="submit">Delete</button>
                        </form>
                    
                        <form action="{{url('/admin/location/edit',['id'=>$user->id])}}" method="get">
                        @csrf
                            <button type="submit">Edit</button>
                        </form>
                        <form action="{{url("/admin/location/delete/$user->id")}}" method="post">
                        @csrf
                            <button type="submit">Delete</button>
                        </form>
                    
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-center p-36 text-slate-500">Data not found</p>
            @endif
        </div>
    </div>
</x-app-layout>
