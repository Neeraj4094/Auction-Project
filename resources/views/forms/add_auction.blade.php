<x-app>
    <div class="grid place-items-center p-10 space-y-4">
        <h2 class="text-3xl">Add New Event</h2>
        <form action="{{url('/admin/auction/create')}}" method="post" class="w-[650px] space-y-3 p-4 rounded-lg border">
        @csrf
            <div class="grid space-y-2 w-full">
                <label for="start_time">Event Date</label>
                <input type="date" name="start_time" id="start_time" placeholder="Enter event name" class="px-4 rounded-lg" value="{{old('start_time')}}">
                @error('start_time')
                    {{$message}}
                @enderror
            </div>
            
            <!-- <div class="flex items-center gap-3"> -->
                <fieldset>
                    <legend>Choose Auction Items </legend>
                    <div class=" grid grid-cols-4 mt-2 items-center w-full">
                        @foreach($inventory as $data)
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="items[]" multiple id="{{$data->id}}" value="{{$data->id}}">
                            <label for="{{$data->id}}">{{$data->name}}</label>
                        </div>
                        @endforeach
                    </div>
                    @error('items')
                        {{$message}}
                    @enderror
                </fieldset>
                
                
            <!-- </div> -->
            <input type="submit" name="add_godown" id="add_godown" class="border rounded-lg p-2 bg-blue-600 text-white">
        </form>
    </div>
</x-app>