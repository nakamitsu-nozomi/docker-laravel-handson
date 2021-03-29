@extends('app')

@section('title', '記事一覧')


@section('content')
  <div class="container">
  <div class="card mt-3">
    <div class="card-body d-flex flex-row">
      <i class="far fa-question-circle fa-3x mr-1"></i>
      <div>
        <div class="font-weight-bold">
          郵便番号：  {{$location->zipcode}}
        </div> 
        <div class="font-weight-lighter">
        <h1 class="h4 card-title ">
          {{$location->address}}の {{$tomorrow}}の天気
        </h1>
        </div>
      </div>
  @include('locations.dropdown')
    </div>
    <div class="card-body pt-0 pb-2">
      @foreach (array_map(null, $weathers, $temp_maxs,$weather_icons,$temp_mins,$dates,$times) as [$weather,$temp_max,$weather_icon,$temp_min,$date,$time])
      @if ($date === $tomorrow)
      {{-- @if ($i < config('const.tomorow_weather_count')) --}}
        <h3 class="h4 card-title"> {{$date}}{{$time}}</h3>
        <p> {{$weather}}</p>
          <img src="https://openweathermap.org/img/wn/<?php echo $weather_icon; ?>@2x.png">
          <p>最高気温:{{$temp_max}}℃ <span>最低気温：{{$temp_min}}℃</span></p>
        @endif
        @endforeach
    </div>

  </div>

  </div>
@endsection









