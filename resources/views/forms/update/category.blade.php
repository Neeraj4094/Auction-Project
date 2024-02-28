<x-app>

    <div class="grid place-items-center p-10 space-y-4">
        <h2 class="text-3xl">Update Category</h2>
        <form id="update_category" class="w-96 space-y-3 p-4 rounded-lg border">
            @csrf
            <div class="grid space-y-2">
                <input type="hidden" name="id" value="{{$category->name}}">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter name" class="px-4 rounded-lg" value="{{old('name')}}">
                <span class="err_msg" id="err_name"></span>
            </div>
            <button type="submit" id="btnsubmit" class="border rounded-lg p-2 bg-blue-600 text-white">Submit</button>
        </form>
    </div>
    <script>
        $(document).ready(function(){
            $("#update_category").submit(function(event){
                event.preventDefault();

                var form = $("#update_category")[0];
                var data = new FormData(form);

                $("#btnsubmit").prop("disabled",true);
                $("#btnsubmit").addClass("bg-blue-500");
                
                $(".err_msg").html('');

                $.ajax(
                    type:"POST",
                    url:"{{route('admin.category.update')}}",
                    data:data,
                    success:function(response){
                        if(response.status == 400){
                            $(".err_msg").addClass("text-sm text-red-700 p-1");
                            $("#err_name").append(response.name);
                        }else{
                            window.location.href="/admin/category";
                        }
                    }
                );
            });
        });
    </script>
</x-app>