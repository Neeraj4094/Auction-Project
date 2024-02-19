<x-app>

    <div class="grid place-items-center p-10 space-y-4">
        <h2 class="text-3xl">Update Location</h2>
        <form action="{{url('/admin/location/update',['id'=>$id])}}" method="post" class="w-96 space-y-3 p-4 rounded-lg border">
        @csrf
            <div class="grid space-y-2">
                <label for="location">Location</label>
                <textarea name="location" id="location" cols="30" rows="4" class="px-4 rounded-lg" placeholder="Enter location">{{$location->address}}</textarea>
                @error('location')
                    {{$message}}
                @enderror
            </div>
            <input type="submit" value="Add" name="add_location" id="add_location" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>