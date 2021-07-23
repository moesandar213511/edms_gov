@extends('layouts.app')
@section('title','DEPARTMENT DASHBOARD')
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h4>
          ဌာနခွဲအသစ်ဖွင့်ရန်
        </h4>
        <form id="create">
          <div class="form-group">
              <label for="">ဌာန</label>
                <select name="main_depart_id" class="form-control">
                    @if(count($main_departs) > 0)
                        @foreach($main_departs as $data)
                        <option value="{{$data->id}}">{{$data->depart_name}}</option>
                        @endforeach
                    @endif
                </select>
          </div>
          <div class="form-group">
            <input type="text" name="name" placeholder="ဌာနခွဲအမည်" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" autocomplete="off" name="password" placeholder="Password" class="form-control">
          </div>
          <div class="form-group">
            <input type="password" autocomplete="off" name="password_confirmation" placeholder="Comfirm Password" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="office_phone" placeholder="ရုံးဖုန်း" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="human_phone" placeholder="ဦးစီးအရာရှိဖုန်း" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="address" placeholder="လိပ်စာ" class="form-control">
          </div>
          <div class="form-group">
            <label>တည်နေရာ</label>
            <div class="row">
              <div class="col-md-6">
                <input type="text" name="latitude" placeholder="Latitude | eg.16.832383" class="form-control">
              </div>
              <div class="col-md-6">
                <input type="text" name="longitude" placeholder="Longitude | eg.16.832383" class="form-control">
              </div>
            </div>

          </div>
          <div class="form-group">
            <label for="logo" class="btn btn-primary">Logo</label>
            <input type="file" id="logo" name="logo">
          </div>
          <div class="form-group">
            <input type="submit" name="" value="Create" class="btn-block btn btn-primary btn-md">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop
@section('js')
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  let form = document.querySelector("form");

  $(document).on('submit', '#create', function(e) { // store data 
    e.preventDefault();
    let form_data = new FormData(this);
    let url = "{{url('admin/store/sub-depart')}}";
    $.ajax({
      url: url,
      type: "post",
      data: form_data,
      dataType: "json",
      processData: false,
      contentType: false,
    }).done(function(response) {
      if (response) {
        toastr.success("Create Successful!");
        form.reset();
        loadData();
      }
    }).fail(function(error) {
      console.log(error);
      if (error.responseJSON.errors.name) {
        toastr.error(error.responseJSON.errors.name[0]);
      }

      if (error.responseJSON.errors.logo) {
        toastr.error(error.responseJSON.errors.logo[0]);
      }

      if (error.responseJSON.errors.office_phone) {
        toastr.error(error.responseJSON.errors.office_phone[0]);
      }

      if (error.responseJSON.errors.human_phone) {
        toastr.error(error.responseJSON.errors.human_phone[0]);
      }

      if (error.responseJSON.errors.address) {
        toastr.error(error.responseJSON.errors.address[0]);
      }

      if (error.responseJSON.errors.latitude) {
        toastr.error(error.responseJSON.errors.latitude[0]);
      }

      if (error.responseJSON.errors.longitude) {
        toastr.error(error.responseJSON.errors.longitude[0]);
      }

      if (error.responseJSON.errors.password) {
        toastr.error(error.responseJSON.errors.password[0]);
      }
    });
  });
</script>
@stop