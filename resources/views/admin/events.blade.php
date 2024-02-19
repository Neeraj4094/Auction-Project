<x-app-layout>
    <div class="w-full">
        <div class="flex items-center justify-between  p-2 py-4 border-b w-full h-full px-3">
            
            <div class="grid space-y-3">
                <h2 class="text-2xl font-bold">Manage Admin Records</h2>
                <form action="{{url('/admin/event')}}" method="get" class="relative">
                    <input type="search" name="search" id="search" class="p-1 border rounded-md" placeholder="Search...">
                    <button type="submit" class=" border rounded-r-md bg-slate-100 h-full">search</button>
                </form>
            </div>
            
            <div class="flex gap-4">
                <a href="{{url('/admin/event/add')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">Add Event</span>
                </a>
                <a href="{{url('/admin/event/trash_data')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">Event Trash Data</span>
                </a>
            </div>
        </div>

        @if(count($event)>0)
        
        <div class="border p-3 overflow-y-scroll h-[360px]">
                @foreach($event as $data)
                <div class="border rounded-lg grid grid-cols-2 p-2">
                    <div class="grid">
                        <span>Name :- {{$data->name}}</span>
                        <span>Created by :- {{$data->user->name}}</span>
                        <span>Location :- {{$data->location->address}}</span>
                        <span>Category :- {{$data->category->name}}</span>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <div class="grid">
                            <span>Created Date :- {{$data->created_at}}</span>
                            <span>Updated Date :- {{$data->updated_at}}</span>
                        </div>
                        <span class="px-2 py-1 bg-blue-600 text-white rounded-md">{{($data->status === 1) ? "Active" : "Blocked" }}</span>
                        
                        <form action="{{url('/admin/event/restore',['id'=>$data->id])}}" method="post">
                        @csrf
                            <button type="submit">Restore</button>
                        </form>
                        <form action="{{url("/admin/delete/$data->id")}}" method="post">
                        @csrf
                            <button type="submit">Delete</button>
                        </form>
                    
                        <form action="{{url('/admin/event/edit',['id'=>$data->id])}}" method="get">
                        
                            <button type="submit">Edit</button>
                        </form>
                        <form action="{{url("/admin/event/delete/$data->id")}}" method="post">
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
