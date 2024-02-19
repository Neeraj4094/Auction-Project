<div class="py-2">
<div class="flex items-center justify-between p-2 border-b">
    <h2>Welcome Admin, @auth {{auth()->user()->name}} @endauth</h2>
    <div class="w-10 h-10 rounded-full bg-slate-200 p-1">
        <img src="{{asset('/images/wing.png')}}" alt="">
    </div>
</div>
<!-- <div class="flex items-center justify-between  p-2 py-4 border-b w-full h-full px-3">
    
    <div class="grid space-y-3">
        <h2 class="text-2xl font-bold">Manage Admin Records</h2>
        <form action="{{url('/admin/dashboard')}}" method="get" class="relative">
            <input type="search" name="search" id="search" class="p-1 border rounded-md" placeholder="Search...">
            <button type="submit" class=" border rounded-r-md bg-slate-100 h-full">search</button>
        </form>
    </div>
    
    <div class="flex gap-2">
        <a href="{{url('/home')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
            <span class="">Home</span>
        </a>
        <a href="{{url('/admin/add_user')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
            <span class="">Add User</span>
        </a>
        
        <a href="{{url('/admin/dashboard')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
            <span class="">User Data</span>
        </a>
        <a href="{{url('/admin/trash_data')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
            <span class="">User Trash Data</span>
        </a>
        <a href="{{url('/admin/location/trash_data')}}" class="px-5 py-2 rounded-md text-white bg-blue-600">
            <span class="">Location Trash Data</span>
        </a>
    </div>
</div> -->
</div>