@extends('app')

@section('title', '記事一覧')


@section('content')
@include('error_card_list')
  <div class="container">
  @foreach ($locations as $location)
    @include('locations.card')
  @endforeach
 {{$locations->links()}}
  </div>
@endsection
