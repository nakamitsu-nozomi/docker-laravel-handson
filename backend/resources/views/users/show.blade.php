@extends('app')

@section('title', '記事一覧')


@section('content')

  <div class="container">
      @foreach($locations as $location)
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
          @if( Auth::id() === $location->user_id )
          <!-- dropdown -->
          <div class="ml-auto card-text">
            <div class="dropdown">
              <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <button type="button" class="btn btn-link text-muted m-0 p-2">
                  <i class="fas fa-ellipsis-v"></i>
                </button>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{route("locations.edit",["location" =>$location])}}">
                  <i class="fas fa-pen mr-1"></i>位置情報を更新する
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $location->id }}">
                  <i class="fas fa-trash-alt mr-1"></i>位置情報を削除する
                </a>
              </div>
            </div>
          </div>
          <!-- dropdown -->
  
          <!-- modal -->
          <div id="modal-delete-{{ $location ->id }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="POST" action="{{ route('locations.destroy', ['location' => $location]) }}">
                  @csrf
                  @method('DELETE')
                  <div class="modal-body">
                    郵便番号【{{ $location->zipcode }}】を削除します。よろしいですか？
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
            郵便番号：  {{$location->zipcode}}
          </h3>
          <h3 class="h4 card-title">
            天気
          </h3>
        </div>
      </div>


      @endforeach
  </div>
@endsection



