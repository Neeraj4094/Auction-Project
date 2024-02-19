<x-app>
    <div class="grid place-items-center p-6 space-y-4">
        <h2 class="text-3xl">Add New Inventory</h2>
        <form action="{{url('/admin/inventory/store')}}" method="post" enctype="multipart/form-data" class="w-[600px] space-y-3 p-4 rounded-lg border">
        @csrf
            
            <div class="flex gap-4 w-full">
                <div class="grid space-y-2 w-full">
                    <label for="name">Inventory Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter inventory name" class="px-4 rounded-lg" value="{{old('name')}}">
                    @error('name')
                        {{$message}}
                    @enderror
                </div>
                <div class="grid space-y-2 w-full">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="rounded-lg text-slate-600">
                        <option value="">Select Location</option>
                        @foreach($category as $data)
                        <option value="{{$data->id}}" {{(old("category") == $data->id) ? "selected" : "" }}>{{$data->name}}</option>
                        @endforeach
                    </select>
                    @error('category')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <div class="flex gap-4 w-full">
                <div class="grid space-y-2 w-full">
                    <label for="price">Price</label>
                    <input type="number" min="0" max="100000" step="1" name="price" id="price" placeholder="Enter price" required="required" class="px-4 rounded-lg" value="{{old('price')}}">
                    @error('price')
                        {{$message}}
                    @enderror
                </div>
                <div class="grid space-y-2 w-full">
                    <label for="position">Position</label>
                    <select name="position" id="position" class="rounded-lg text-slate-600">
                        <option value="">Select Condition</option>
                        <option value="1" {{(old('position') == "1") ? "selected" : "" }}>New</option>
                        <option value="2" {{(old('position') == "2") ? "selected" : "" }}>2nd Hand</option>
                        <option value="3" {{(old('position') == "3") ? "selected" : "" }}>Old</option>
                    </select>
                    @error('position')
                        {{$message}}
                    @enderror
                </div>
            </div>
            <div class="grid space-y-2 w-full">
                <label for="desc">Description</label>
                <textarea name="desc" id="desc" cols="30" rows="4" class="px-4 rounded-lg" placeholder="Enter description">{{old('desc')}}</textarea>
                @error('desc')
                    {{$message}}
                @enderror
            </div>
            <input type="submit" name="add_inventory" id="add_inventory" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>