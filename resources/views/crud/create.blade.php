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
        <input type="email" name="email" placeholder="Enter email">
        <input type="file" name="image">
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

            $("#btnsubmit").prop("disabled",true);
            $("#btnsubmit").addClass('bg-blue-500');

            $.ajax({
                type:"POST",
                url:"{{route('store.employee')}}",
                data:data,
                processData:false,
                contentType:false,
                success:function(response){
                    if(response.status == 400){
                        $("#error_message").html("");
                        $("#error_message").addClass("bg-red-100 text-red-700 px-3 py-1");
                        $.each(response.errors,function(key,err_val){
                            $("#error_message").append('<li>'+err_val+'</li>');
                        });
                    }else{
                        $("#success_message").addClass("bg-red-100 text-red-700 px-3 py-1");
                        $("#success_message").text(response.message);
                    }
                    $("#btnsubmit").prop("disabled",false);
                    $("input[type='text']").val('');
                    $("input[type='email']").val('');
                    $("input[type='file']").val('');
                },
                error:function(err){
                    $("#error_message").html("");
                    $("#error_message").addClass("bg-red-100 text-red-700 px-3 py-1");
                    $.each(err.errors,function(key,err_val){
                        $("#error_message").append('<li>'+err_val+'</li>');
                    });
                    $("#btnsubmit").prop("disabled",false);
                    $("input[type='text']").val('');
                    $("input[type='email']").val('');
                    $("input[type='file']").val('');
                },
            });
        });
    });
</script>
@endsection