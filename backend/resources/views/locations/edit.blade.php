@extends('app')

@section('title', '位置情報投稿')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body pt-0">
            {{-- @include('error_card_list') --}}
            <div class="card-text">
              <form method="POST" action="{{ route('locations.update',["location"=> $location ]) }}">
                @method("PATCH")
                @csrf

                <div class="md-form">
                  <label>天気を知りたい場所の郵便番号(ハイフンなし)を入力</label>
                  <input type="text" name="zipcode" class="form-control" required value="{{ $location->zipcode ?? old('zipcode') }}">
                </div>
                <button type="submit" class="btn blue-gradient btn-block">変更する</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
