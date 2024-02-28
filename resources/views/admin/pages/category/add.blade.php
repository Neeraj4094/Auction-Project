@extends('admin.layouts.app')

@section('contents')

<div id="msg"></div>
<div class="grid place-items-center p-10 space-y-4">
    <h2 class="text-3xl">Create New Category</h2>
    <form id="add_category" class="w-96 space-y-3 p-4 rounded-lg border">
        @csrf
        <div class="grid space-y-2">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter name" class="px-4 rounded-lg" value="{{old('name')}}">
            <span class="err_msg" id="err_name"></span>
        </div>
        <button type="submit" id="btnsubmit" class="border rounded-lg p-2 bg-blue-600 text-white">Submit</button>
    </form>
</div>
<a href="{{route('admin.show.category')}}">All Categories</a>
@endsection
@section('scripts')

<script>
    $(document).ready(function(){
        $("#add_category").submit(function(event){
            event.preventDefault();

            var form = $("#add_category")[0];
            var data = new FormData(form);
            $("#btnsubmit").prop("disabled", true);
            $("#msg").html('');
            
            $.ajax({
                url: "{{ route('admin.store.new.category') }}",
                type: "POST",
                data: data,
                processData: false,  // important for FormData
                contentType: false,  // important for FormData
                success: function (response) {
                    // Check if response is JSON
                    if (response && response.message) {
                        $("#msg").append(response.message);
                        if(response.redirect){
                            window.location.href = response.redirect;
                        }
                    } else {
                        console.error("Invalid response format");
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    $("#msg").append("An error occurred. Please try again.");
                }
            });
        });
    });
</script>
@endsection
    