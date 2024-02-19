<x-app>
    <div class="grid place-items-center p-6 space-y-4">
        <h2 class="text-3xl">Update Inventory Images</h2>
        <form action="{{url('/admin/inventory_images/update',['id'=>$id])}}" method="post" enctype="multipart/form-data" class="w-80 space-y-3 p-4 rounded-lg border">
        @csrf
            
            <div class="grid space-y-2 w-full">
                <label for="inventory">Inventory</label>
                <select name="inventory" id="inventory" class="rounded-lg text-slate-600">
                    <option value="">Select Inventory</option>
                    @foreach($inventory as $data)
                    <option value="{{$data->id}}" {{($image_data->inventory_id == $data->id) ? "selected" : "" }}>{{$data->name}}</option>
                    @endforeach
                </select>
                @error('inventory')
                    {{$message}}
                @enderror
            </div>
            
            <div class="grid space-y-2 w-full">
                    <label for="image">Choose Image</label>
                    <input type="file" name="image" id="image" class="px-4 rounded-lg">
                    @error('image')
                        {{$message}}
                    @enderror
                </div>
            
            <input type="submit" name="add_inventory" id="add_inventory" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>