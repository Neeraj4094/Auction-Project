@if(count($data) >0)
    @php $id=1 @endphp
    @foreach($data as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->name}}</td>
            <td>{{$category->created_at}}</td>
            <td>
                <div class="flex">
                    <a href="">Edit</a>
                    <a href="">Delete</a>
                </div>
            </td>
        </tr>
        @php $id++ @endphp
    @endforeach
@else
<tr>No data available</tr>
@endif