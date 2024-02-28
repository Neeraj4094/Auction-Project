<x-app-layout>
    <div class="w-full">
        <div class="flex items-center justify-between  p-2 py-4 border-b w-full h-full px-3">
        
            <div class="grid space-y-3">
                <h2 class="text-2xl font-bold">Manage Employee Records</h2>
                <form action="{{url('/admin/dashboard')}}" method="get" class="relative">
                    <input type="search" name="search" id="search" class="p-1 border rounded-md" placeholder="Search...">
                    <button type="submit" class=" border rounded-r-md bg-slate-100 h-full">search</button>
                </form>
            </div>
            
            <div class="flex gap-2">
                <a href="{{url('/')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">Home</span>
                </a>
                <a href="{{url('/add_user')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">Add User</span>
                </a>
                <a href="{{url('/trash_data')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
                    <span class="">User Trash Data</span>
                </a>s
            </div>
        </div>
        <div class="border p-3 overflow-y-scroll h-[360px]">
            @auth
            @if(count($users)>0 || !empty($users))
                @foreach($users as $user)
                <div class="border rounded-lg grid grid-cols-2 p-2">
                    <div class="grid">
                        <span>Name :- {{$user->name}}</span>
                        <span>Email :- {{$user->email}}</span>
                        <span>Address :- {{$user->address}}</span>
                    </div>
                    <div class="flex items-center justify-between">
                    <div class="grid">
                        <span>Created Date :- {{$user->created_at}}</span>
                        <span>Updated Date :- {{$user->updated_at}}</span>
                    </div>
                    <span class="px-2 py-1 bg-blue-600 text-white rounded-md">{{($user->status === 1) ? "Active" : "Blocked" }}</span>
                        @if(!empty($user->deleted_at))
                        <form action="{{url('/restore',['id'=>$user->id])}}" method="post">
                        @csrf
                            <button type="submit">Restore</button>
                        </form>
                        <form action="{{url("/delete/$user->id")}}" method="post">
                        @csrf
                            <button type="submit">Delete</button>
                        </form>
                        @else
                        <a href="{{url('/edit',['id'=>$user->id])}}">Edit</a>
                        <form action="{{url("/delete/$user->id")}}" method="post">
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
            @endauth
        </div>
    </div>
</x-app-layout>
