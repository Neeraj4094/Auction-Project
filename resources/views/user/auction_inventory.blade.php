@extends('layouts.home.app')

@section('content')
<h1 class="text-center font-bold text-3xl pt-6 underline">"{{$auction[0]->event->name}}" Details</h1>
<div class="flex items-center justify-center p-1 fixed top-20 right-4 gap-2 text-lg border rounded-lg shadow bg-slate-100">
    <span class="">Event Start Time :-</span>
    <p id="start" class=""></p>
</div>
<div class="flex items-center justify-center p-1 fixed top-32 right-4 gap-2 text-lg border rounded-lg shadow bg-slate-100">
    <span class="">Event End Time :-</span>
    <p id="end" class=""></p>
</div>
<div class="flex items-center justify-center p-10">
    <div class="grid grid-cols-3 gap-4">
        @foreach($auction as $data)
        @php
            $event = DB::table('events')->where('id',$data->event_id)->first();
            $category = DB::table('category')->where('id',$data->event->category_id)->first();
            $inventory_id = explode(',',$data->inventory_ids);
            $user = DB::table('users')->where('id',$data->user_id)->first(); 
        @endphp
            <div class="bg-white p-4 border rounded-lg relative" id="timer">
                <!-- <a href="{{url('/user/auction/inventory')}}" class="absolute inset-0"></a> -->
                <div class="mx-auto grid max-w-7xl gap-x-4 gap-y-6 px-6 lg:px-4">
                    <div class="max-w-2xl">
                        <h2 class="text-lg tracking-tight text-gray-900">Category Name:- <span class="text-xl  font-bold">{{$category->name}}</span></h2>
                        <h2 class="text-lg tracking-tight text-gray-900">Item Name:- <span class="text-xl  font-bold">{{$data->inventory->name}}</span></h2>
                    </div>
                    <div class="">
                        <h2 class="text-lg tracking-tight text-gray-900">Item Details:- </h2><span class="text-sm">{{$data->inventory->description}}</span>
                    </div>
                    <ul role="list" class="grid">
                        <li>
                            <div class="flex items-center gap-x-6">
                                <img class="h-16 w-16 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                                <div class="grid">
                                    <div>
                                        <p class="text-sm font-semibold leading-6 text-indigo-600">Created by:-</p>
                                        <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900">{{$user->name}}</h3>
                                    </div>
                                    <div>                                    
                                        <p class="text-sm font-semibold leading-6 text-indigo-600">Created Date:-</p>
                                        <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900">{{$data->created_at}}</h3>
                                    </div>     
                                </div>                   
                            </div>
                        </li>
                        
                    </ul>
                    <a href="{{route('buy_now')}}" class="rounded-lg px-3 py-1 bg-blue-700 w-auto text-white text-center">Buy Now</a>
                </div>
            </div>
        @endforeach
    </div>
    
</div>
@endsection
<script>
    
var countDownstartDate = new Date("{{ $auction[0]->event_start_time }}").getTime();

var x = setInterval(function() {

  var now = new Date().getTime();
  var distance = countDownstartDate - now;
    
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  document.getElementById("start").innerHTML = days + "days " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("start").innerHTML = "EXPIRED";
  }
}, 1000);
</script>

<script>
    
var countDownDate = new Date("{{ $auction[0]->event_end_time }}").getTime();

var x = setInterval(function() {

  var now = new Date().getTime();
  var distance = countDownDate - now;
    
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  document.getElementById("end").innerHTML = days + "days " + hours + "h "
  + minutes + "m " + seconds + "s ";
    
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("end").innerHTML = "EXPIRED";
  }
}, 1000);
</script>