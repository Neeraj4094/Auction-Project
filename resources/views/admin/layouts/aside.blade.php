<aside class="grid place-items-center border-slate-600 border-r">
    <div class="w-16 h-16 rounded-lg">
        <img src="{{asset('/images/wing.png')}}" alt="Admin Logo" class="w-full h-full object-cover">
    </div>
    <div class="  w-full h-full px-2 mt-4">
        <span class="text-blue-600 font-semibold">Home</span>
        <ul class=" space-y-1">
            @auth
            @if(auth()->user()->role == "admin")
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/admin/dashboard')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Dashboard</span>
                </div>
            </li>
            @elseif(auth()->user()->role == "manager")
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/manager/dashboard')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Dashboard</span>
                </div>
            </li>
            @else
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/dashboard')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Dashboard</span>
                </div>
            </li>
            @endif
            
            @if(auth()->user()->role == "admin")
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/admin/category')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Category</span>
                </div>
            </li>
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/admin/location')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Location</span>
                </div>
            </li>
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/admin/godown')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Godown</span>
                </div>
            </li>
            @endif
            @endauth
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/auction')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Auction</span>
                </div>
            </li>
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/inventory')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Inventory</span>
                </div>
            </li>
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/inventory_images')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Inventory Images</span>
                </div>
            </li>
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/event')}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Event</span>
                </div>
            </li>
            @auth
            <li class="flex items-center gap-3 hover:bg-slate-200 p-2 rounded-lg relative">
                <a href="{{url('/edit',['id'=>auth()->user()->id])}}" class="absolute inset-0 "></a>
                <div class="flex gap-2">
                    <span>o</span>
                    <span>Settings</span>
                </div>
            </li>
            @endauth
            <li class="flex items-center bg-blue-600 text-white  hover:bg-blue-700 p-2 rounded-lg relative">
                <form action="{{route('logout')}}" method="post" class=" cursor-pointer">
                @csrf
                <div class="flex gap-2">
                    <span>o</span>
                    <button type="submit">Logout</button>
                </div>
                </form>
            </li>
            
        </ul>
    </div>
</aside>