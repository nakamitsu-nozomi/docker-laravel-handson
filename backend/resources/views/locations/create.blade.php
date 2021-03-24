@extends('app')

@section('title', '位置情報投稿')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body pt-0">
            @include('error_card_list')

            <div class="card-text">
              <form method="POST" action="{{ route('locations.store') }}">
                @csrf
                <div class="md-form">
                  <label>天気を知りたい場所の郵便番号(ハイフンなし)を入力</label>
                  <input type="text" name="zipcode" class="form-control" required value="{{ $location->zipcode ?? old('zipcode') }}" onKeyUp="AjaxZip3.zip2addr(this,'','addr11','addr11')">
                </div>
                  <div class="md-form">
                  <label>位置情報（自動入力）</label>
                  <input type="text" name="addr11" class="form-control" readonly required value="{{ $location->address ?? old('address') }}">
                </div>
                <div class="md-form">
                  <location-tags-input>
                  </location-tags-input>
                </div>
                <button type="submit" class="btn blue-gradient btn-block">登録する</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
