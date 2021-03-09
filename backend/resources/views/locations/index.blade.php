@extends('app')

@section('title', '記事一覧')


@section('content')

  <div class="container">

  
      <div class="card mt-3">
        <div class="card-body d-flex flex-row">
          <i class="fas fa-user-circle fa-3x mr-1"></i>
          <div>
            <div class="font-weight-bold">
            ユーザー名
            </div> 
            <div class="font-weight-bold">
              郵便番号：{{$zipcode}}
            </div> 
            <div class="font-weight-lighter">
            </div>
          </div>
        </div>
        <div class="card-body pt-0 pb-2">
          <h3 class="h4 card-title">
            天気
          </h3>
        </div>
      </div>
  </div>
@endsection



