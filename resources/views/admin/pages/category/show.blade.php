@extends('admin.layouts.app')

@section('contents')

<div id="msg"></div>
<table>
    <thead>
        <th>Sr No.</th>
        <th>Name</th>
        <th>Created Date</th>
        <th>Action</th>
    </thead>
    <tbody id="table-content">

    </tbody>
</table>

@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        fetchdata(1);

        function fetchdata(page){
            $.ajax({
                url:"{{route('admin.show.category')}}",
                type:"GET",
                success:function(data){
                    $("#table-content").html(data);
                },
                error:function(data){
                    console.log(data);
                }
            });
        }
    });
</script>
@endsection