<x-app>

    <div class="grid place-items-center p-10 space-y-4">
        <h2 class="text-3xl">Update Category</h2>
        <form action="{{url('/admin/category/update',['id'=>$id])}}" method="post" class="w-96 space-y-3 p-4 rounded-lg border">
        @csrf
            <div class="grid space-y-2">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" class="px-4 rounded-lg" value="{{$category->name}}">
                @error('name')
                    {{$message}}
                @enderror
            </div>
            <input type="submit" name="add_category" id="add_category" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>