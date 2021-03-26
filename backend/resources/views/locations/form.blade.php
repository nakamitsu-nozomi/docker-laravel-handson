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
    <location-tags-input
      :initial-tags='@json($tagNames ?? [])'
      :autocomplete-items='@json($allTagNames ??[])'
    >
    </location-tags-input>
</div>