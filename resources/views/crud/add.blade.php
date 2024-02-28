@extends('layouts.crud')
@section('content')
<div class="grid place-items-center space-y-2">
    <a href="{{route('show.employee')}}" data-bs-toggle="modal"
        data-bs-target="#AddStudentModal" class="bg-blue-700 text-white rounded-md px-3 py-1">All Student</a>
    <div id="success_message"></div>
    <ul id="error_message"></ul>
    <form id="add_student" class="grid gap-1 border rounded p-4">
        @csrf
        <input type="text" name="name" placeholder="Enter name">
        <span class="err_msg" id="err_name"></span>
        <input type="email" name="email" placeholder="Enter email">
        <span class="err_msg" id="err_email"></span>
        <input type="file" name="image">
        <span class="err_msg" id="err_image"></span>
        <button type="submit" id="btnsubmit" class="bg-blue-700 rounded-md px-3 py-1 text-white">Submit</button>
    </form>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("#add_student").submit(function(event){
            event.preventDefault();

            var form = $("#add_student")[0];
            var data = new FormData(form);

            $("#btnsubmit").prop("disabled", true);
            $("#btnsubmit").addClass('bg-blue-500');

            // Clear previous error messages
            $(".err_msg").html('');

            $.ajax({
                type: "POST",
                url: "{{ route('store.employee') }}",
                data: data,
                processData: false,
                contentType: false,
                success: function(response){
                    $("#btnsubmit").prop("disabled", false);
                    if(response.status == 400){
                        $(".err_msg").addClass("text-sm text-red-700 p-1");
                        $("#err_name").append(response.errors['name']);
                        $("#err_email").append(response.errors['email']);
                        $("#err_image").append(response.errors['image']);
                    } else {
                        $("#success_message").addClass("bg-red-100 text-red-700 px-3 py-1");
                        $("#success_message").text(response.message);
                        $("input[type='text']").val('');
                        $("input[type='email']").val('');
                        $("input[type='file']").val('');
                    }
                },
            });
        });
    });
</script>
@endsection