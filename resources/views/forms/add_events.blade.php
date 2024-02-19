<x-app>
    @if(request()->session()->has('error'))
        {{request()->session()->get('error')}}
    @endif
    <div class="grid place-items-center p-10 space-y-4">
        <h2 class="text-3xl">Add New Event</h2>
        <form action="{{url('/admin/event/store')}}" method="post" class="w-[550px] space-y-3 p-4 rounded-lg border">
        @csrf
        @if(!empty($user))
        <input type="hidden" name="user_id" id="user_id" value="{{$user}}">
        @endif
            <div class="flex items-center gap-3">
            <div class="grid space-y-2 w-full">
                <label for="name">Event Name</label>
                <input type="text" name="name" id="name" placeholder="Enter event name" class="px-4 rounded-lg" value="{{old('name')}}">
                @error('name')
                    {{$message}}
                @enderror
            </div>
            <!-- <div class="grid space-y-2 w-full">
                <label for="start_time">Event Date</label>
                <input type="date" name="start_time" id="start_time" placeholder="Enter event name" class="px-4 rounded-lg" value="{{old('start_time')}}">
                @error('start_time')
                    {{$message}}
                @enderror
            </div> -->
            </div>
            <div class="flex items-center gap-3">
                <div class="grid space-y-2 w-full">
                    <label for="location">Location</label>
                    <select name="location" id="location" class="rounded-lg text-slate-600">
                        <option value="">Select Location</option>
                        @foreach($location as $data)
                        <option value="{{$data->id}}">{{$data->address}}</option>
                        @endforeach
                    </select>
                    @error('location')
                        {{$message}}
                    @enderror
                </div>
                <div class="grid space-y-2 w-full">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="rounded-lg text-slate-600">
                        <option value="">Select category</option>
                        @foreach($category as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    </select>
                    @error('category')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <input type="submit" name="add_godown" id="add_godown" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>