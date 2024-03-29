<x-app>
    <div class="grid place-items-center p-10 space-y-4">
        <h2 class="text-3xl">Add New Godown</h2>
        <form action="{{url('/admin/godown/store')}}" method="post" class="w-96 space-y-3 p-4 rounded-lg border">
        @csrf
            <div class="grid space-y-2">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" class="px-4 rounded-lg" value="{{old('name')}}">
                @error('name')
                    {{$message}}
                @enderror
            </div>
            <div class="grid space-y-2">
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
            <input type="submit" name="add_godown" id="add_godown" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>