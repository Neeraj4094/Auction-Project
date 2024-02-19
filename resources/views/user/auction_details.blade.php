@extends('layouts.home.app')

@section('content')
<h1 class="text-center font-bold text-3xl pt-6 underline">Auction Details</h1>
<div class="flex items-center justify-center p-10">
    <div class="grid grid-cols-3 gap-4">
        @foreach($auction as $data)
        @php
            $event = DB::table('events')->where('id',$data->event_id)->first();
            $inventory_id = explode(',',$data->inventory_ids);
            $user = DB::table('users')->where('id',$data->user_id)->first();
                    
        @endphp
            <div class="bg-white p-4 border rounded-lg relative">
                <a href="{{url('/auction/inventory?event='. $data->event_id)}}" class="absolute inset-0"></a>
                <div class="mx-auto grid max-w-7xl gap-x-4 gap-y-6 px-6 lg:px-4 ">
                    <div class="max-w-2xl space-y-4">
                        <h2 class="text-lg tracking-tight text-gray-900">Event Name:- <span class="text-xl  font-bold">{{$event->name}}</span></h2>
                        
                        <ul class=" list-disc">
                            <h3 class="text-lg">Items Lists:-</h3>
                        @foreach($inventory_id as $id)
                            @php
                                $inventory = DB::table('inventory')->where('id',$id)->first();
                            @endphp
                            <li class="ml-8 font-semibold ">{{$inventory->name}}</li>
                        @endforeach
                        </ul>
                        @php 
                        $category = DB::table('category')->find($event->category_id);
                        $location = DB::table('location')->find($event->location_id);
                        @endphp
                        <p class=" text-lg leading-8 text-gray-600">Category :- <span class="font-semibold">{{$category->name}}</span></p>
                        <p class=" text-lg leading-8 text-gray-600">Location :- <span class="font-semibold">{{$location->address}}</span></p>
                    </div>
                    <ul role="list" class="grid">
                    <li>
                        <div class="flex items-center gap-x-6">
                        <img class="h-16 w-16 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        <div>
                            <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900">{{$user->name}}</h3>
                            <p class="text-sm font-semibold leading-6 text-indigo-600">Co-Founder / CEO</p>
                        </div>
                        </div>
                    </li>

                    </ul>
                </div>
            </div>
        @endforeach
    </div>
    
</div>
@endsection