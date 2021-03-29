<div class="card mt-3">
  <a class="font-weight-bold" href="{{route("locations.show",["location" =>$location->id])}}">
    <div class="card-body d-flex flex-row">
      <i class="far fa-question-circle fa-3x mr-1"></i>
      <div>
      <div class="font-weight-bold">
        郵便番号：  {{ sprintf('%07d', $location->zipcode)}}
     </div> 
      <div class="font-weight-bold">
        位置情報：  {{$location->address}}
     </div> 
      @foreach($location->tags as $tag)
        @if($loop->first)
          <div class="card-body pt-3 pb-4 pl-3">
            <div class="card-text line-height">
        @endif
              <a href="{{route("tags.show",["name"=>$tag->name])}}" class="border p-1 mr-1 mt-1 text-muted">
                {{ $tag->hashtag }}
              </a>
        @if($loop->last)
            </div>
          </div>
        @endif
      @endforeach
      </a> 
      </div>
  @include('locations.dropdown')
    </div>
  </div>