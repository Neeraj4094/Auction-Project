<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body class="grid place-items-center">
    <h1 class="font-bold text-3xl underline text-center pb-4">Student Data</h1>
    <table class="border p-4" id="studentdata">
        <tr>
            <th>Sr.no</th>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        
    </table>

    <script>
        $(document).ready(function(){
            $.ajax({
                type:"GET",
                url:"{{route('show.allstudent')}}",
                success:function(data){
                    if(data.student.length > 0){
                        for(let i=0;i<data.student.length; i++){
                            let img = data.student[i]['image'];
                            $("#studentdata").append(`
                            <tr>
                            <td>` +(i+1)+`</td>
                            <td>` +(data.student[i]['name'])+`</td>
                            <td>` +(data.student[i]['email'])+`</td>
                            <td>
                            <img src="{{asset('storage/`+img+`')}}" alt="`+img+`" width="100px" height="100px" />
                            </td>
                            <td>
                            <a href="/edit/student/`+(data.student[i]['id'])+`">Edit</a>
                            <a href="#" data-id="`+(data.student[i]['id'])+`" class="deletedata">Delete</a>
                            </td>
                            </tr>
                            `);
                        }
                    }else{
                        $("#studentdata").append("<tr><td colspan='4'>Data not found</td></tr>")
                    }
                },
                error:function(e){
                    console.log(e.responseText);
                }
            });

            $("#studentdata").on("click",".deletedata",function(){
                var id = $(this).attr("data-id");
                var obj = $(this);
                $.ajax({
                    type:"GET",
                    url:"delete/student/"+id,
                    success:function(data){
                        $(obj).parent().parent().remove();
                        $("#output").text(data.result);
                    },
                    error:function(e){
                        console.log(e.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>