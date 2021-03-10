@extends('app')

@section('title', '記事一覧')


@section('content')

  <div class="container">
      {{-- @foreach (array_map(NULL, $locations, $weathers,$temp_maxs,$temp_mins,$weather_icons) as [ $location,$weather, $temp_max,$temp_min,$weather_icon ]) --}}
      @foreach($outputs as $output)
      <div class="card mt-3">
        <div class="card-body d-flex flex-row">
          <i class="fas fa-user-circle fa-3x mr-1"></i>
          <div>
            <div class="font-weight-bold">
            ユーザー名:  {{$user->name}}
            </div> 
            <div class="font-weight-lighter">
            </div>
          </div>
          @if( Auth::id() === $output[4]->user_id )
          <!-- dropdown -->
          <div class="ml-auto card-text">
            <div class="dropdown">
              <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <button type="button" class="btn btn-link text-muted m-0 p-2">
                  <i class="fas fa-ellipsis-v"></i>
                </button>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{route("locations.edit",["location" =>$output[4]])}}">
                  <i class="fas fa-pen mr-1"></i>位置情報を更新する
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $output[4]->id }}">
                  <i class="fas fa-trash-alt mr-1"></i>位置情報を削除する
                </a>
              </div>
            </div>
          </div>
          <!-- dropdown -->
  
          <!-- modal -->
          <div id="modal-delete-{{ $output[4] ->id }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="POST" action="{{ route('locations.destroy', ['location' => $output[4]]) }}">
                  @csrf
                  @method('DELETE')
                  <div class="modal-body">
                    郵便番号【{{ $output[4]->zipcode }}】を削除します。よろしいですか？
                  </div>
                  <div class="modal-footer justify-content-between">
                    <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                    <button type="submit" class="btn btn-danger">削除する</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- modal -->
        @endif
        </div>
        <div class="card-body pt-0 pb-2">
          <h3 class="h4 card-title">
            郵便番号：  {{$output[4]->zipcode}}
          </h3>
          <h3 class="h4 card-title"> {{$date}}の天気</h3>
          <p> {{$output[0]}}</p>
           <img src="https://openweathermap.org/img/wn/<?php echo $output[3]; ?>@2x.png">
            <p>最高気温:{{$output[1]}}℃ <span>最低気温：{{$output[2]}}℃</span></p>
        </div>
      </div>
      @endforeach
  </div>
@endsection



