@extends('layouts.crud')
@section('content')

<div class="card grid place-items-center">
    @if(session('message'))
    {{$message}}
    @endif
    <div id="success_message"></div>
    <ul id="error_message"></ul>
    <div class="card-header flex justify-between w-96">
        <h4 class="font-bold text-xl">Student Data</h4>
        <a href="{{route('create.employee')}}" data-bs-toggle="modal"
            data-bs-target="#AddStudentModal" class="bg-blue-700 text-white rounded-md px-3 py-1">Add Student</a>
    </div>
    <div id="error_message"></div>
    <div class="card-body w-96 border rounded-lg p-4">
        <table class="table table-bordered w-full" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="all_employees">
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $.ajax({
            type: "GET",
            url: "{{route('show.all.employee')}}",
            dataType: "json",
            success:function(response){
                // if(response.employee.length > 0){
                    $.each(response.employee, function (key, item) {
                        let img = item.image;
                        $("#all_employees").append(`
                        <tr class="border">
                            <td class="px-3">`+item.id+`</td>
                            <td class="px-3">`+item.name+`</td>
                            <td class="px-3">
                            <img src="{{asset('storage/`+img+`')}}" width="80px" />
                            </td>
                            <td>
                            <a href="edit-employee/`+item.id+`" >Edit</a>
                            <a href="#" class="delaydata" data-id="`+item.id+`" >Delete</a>
                            </td>
                        </tr>`)
                    });
                // }else{
                //     $("#all_employees").append("<tr><td colspan="4" >Data not found</td></tr>");
                // }
            },
            error:function(err){
                $("#error_message").text(`<li>`+err+`<li>`);
            }
        });

        $("#all_employees").on("click",".delaydata",function(){
            var id = $(this).attr("data-id");
            var obj = $(this);
            $.ajax({
                type:"GET",
                url:"delete-employee/"+id,
                success:function(response){
                    $(obj).parent().parent().remove();
                    $("#success_message").addClass("bg-yellow-100 text-yellow-700 px-3 py-1");
                    $("#success_message").text(response.message);
                },
                error:function(err){
                    $("#error_message").addClass("bg-red-100 text-red-700 px-3 py-1");
                    $("#error_message").text(err.responseText);
                }
            });
        });
        // fetchstudent();

        // function fetchstudent() {
        //     $.ajax({
        //         type: "GET",
        //         url: "{{route('show.all.employee')}}",
        //         dataType: "json",
        //         success: function (response) {
        //             $('tbody').html("");
        //             $.each(response.students, function (key, item) {
        //                 var img = item.image;
        //                 $('tbody').append('<tr>\
        //                     <td>' + item.id + '</td>\
        //                     <td>' + item.name + '</td>\
        //                     <td><img src="{{asset('storage/app/`+img+`')}}" alt="`+img+`" width="100px" height="100px" /></td>\
        //                     <td><button type="button" value="' + item.id + '" class="btn btn-primary editbtn btn-sm">Edit</button></td>\
        //                     <td><button type="button" value="' + item.id + '" class="btn btn-danger deletebtn btn-sm">Delete</button></td>\
        //                 \</tr>');
        //             });
        //         }
        //     });
        // }
    });
</script>
@endsection