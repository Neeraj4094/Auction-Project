@extends('layouts.crud')
@section('content')
<div class="grid place-items-center space-y-2">
    <a href="{{route('show.employee')}}" data-bs-toggle="modal"
        data-bs-target="#AddStudentModal" class="bg-blue-700 text-white rounded-md px-3 py-1">All Student</a>
    <div id="success_message"></div>
    <form id="update_employee" class="grid gap-1 border rounded p-4 w-96">
        @csrf
        <input type="hidden" name="id" value="{{$employee->id}}">
        <input type="text" name="name" placeholder="Enter name" value="{{$employee->name}}">
        <span class="err_msg" id="err_name"></span>
        <input type="email" name="email" placeholder="Enter email" value="{{$employee->email}}">
        <span class="err_msg" id="err_email"></span>
        <div class="flex items-center gap-2">
            <input type="file" name="image">
            <img src="{{asset('storage/'.$employee->image)}}" alt="Image" width="30%" class="rounded-lg">
        </div>
        <span class="err_msg" id="err_image"></span>
        <button type="submit" id="btnsubmit" class="bg-blue-700 rounded-md px-3 py-1 text-white">Update</button>
    </form>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $("#update_employee").submit(function(event){
            event.preventDefault();

            var form = $("#update_employee")[0];
            var data = new FormData(form);

            $(".err_msg").html('');

                $("#btnsubmit").prop("disabled", true);
                $("#btnsubmit").addClass('bg-blue-500');
            $.ajax({
                type:"POST",
                url:"{{route('update.employee')}}",
                data:data,
                processData:false,
                contentType:false,
                success:function(response){
                    if(response.status == 400){
                        $(".err_msg").addClass("text-sm text-red-700 p-1");
                        $("#err_name").append(response.errors['name']);
                        $("#err_email").append(response.errors['email']);
                        $("#err_image").append(response.errors['image']);
                    } else {
                        $("#success_message").addClass("bg-yellow-100 text-yellow-700 px-3 py-1");
                        $("#success_message").text(response.message);
                        window.location.href = "{{route('show.employee')}}",
                        $("#btnsubmit").prop("disabled", false);
                    }
                },
            });
        });
    });
    
</script>
@endsection