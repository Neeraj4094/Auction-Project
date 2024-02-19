<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <form id="add_student" class="border grid w-40">
    @csrf
        <input type="text" name="name" id="name" placeholder="Enter" class="border rounded-md">
        <br>
        <br>
        <input type="email" name="email" id="email" placeholder="Enter email" class="border rounded-md">
        <br>
        <br>
        <input type="file" name="file" id="file" class="border rounded-md">
        <button type="submit" class="bg-slate-200 p-2 border rounded-md w-20" id="btnsubmit">Add</button>
    </form>

    <span id="output"></span>

    <script>
        $(document).ready(function(){
            $("#add_student").submit(function(event){
                event.preventDefault(); //Stops loading

                var form = $("#add_student")[0];
                var data = new FormData(form);

                $("#btnsubmit").prop("disabled",true); //Disable Submit button

                $.ajax({
                    type:"POST",
                    url:"{{route('store.student')}}",
                    data:data,
                    processData:false,
                    contentType:false,
                    success:function(data){
                        $("#output").text(data.res);
                        $("#btnsubmit").prop("disabled",false);
                        $("input[type='text']").val('');
                        $("input[type='email']").val('');
                        $("input[type='file']").val('');
                    },
                    error:function(e){
                        $("#output").text(e.responseText);
                        $("#btnsubmit").prop("disabled",false);
                        $("input[type='text']").val('');
                        $("input[type='email']").val('');
                        $("input[type='file']").val('');
                    }
                });
            });
        });
    </script>
</body>
</html>