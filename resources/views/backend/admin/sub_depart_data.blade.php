@extends('layouts.app')
@section('title','DEPARTMENT DASHBOARD')
@section('css')
  <style>
     .imagePreview {
        width: 70px;
        height: 70px;
        background-position: center center;
        background:url('{{asset("images/default.jpg")}}');
        background-color:#fff;
        background-size: cover;
        background-repeat:no-repeat;
        display: inline-block;
        box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
    }
  </style>
@stop
@section('content')
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title text-center">ဌာနခွဲစာရင်း</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="paginate">
                <thead class=" text-primary">
                  <th>
                    စဉ်
                  </th>
                  <th>
                    logo
                  </th>
                  <th>
                    ဌာနခွဲအမည်
                  </th>
                  <th>
                    ရုံးဖုန်း
                  </th>
                  <th>
                   ဦးစီးအရာရှိဖုန်း
                  </th>
                  <th>
                    လိပ်စာ
                  </th>
                  <th>
                  တည်နေရာ
                  </th>
                  <th>
                    ပြင်ဆင်ရန်
                  </th>
                  <th>
                    ပယ်ဖျက်ရန်
                  </th>
                </thead>
                <tbody>
                  @if(count($sub_depart_datas) > 0)
                    @foreach($sub_depart_datas as $index=>$data)
                      <tr>
                        <td>
                          {{$index+1}}
                        </td>
                        <td>
                         <img src="{{$data['logo']}}" class="imagePreview" alt="logo">
                        </td>
                        <td>
                          {{$data['name']}}
                        </td>
                        <td>
                          {{$data['office_phone']}}
                        </td>
                        <td>
                          {{$data['human_phone']}}
                        </td>
                        <td>
                          {{$data['address']}}
                        </td>
                        <td>
                            <b><u>Latitude</u></b>
                            <p>{{$data['latitude']}}</p>
                            <b><u>Longitude</u></b>
                            <p>{{$data['longitude']}}</p>
                        </td>
                        <td>
                        <button type="button" class="btn btn-primary btn-sm"  onclick="editData({{$data['id']}})" data-toggle="modal" data-target="#editData">Edit</button>
                        </td>
                        <td>
                          <button onclick="deleteSubDepart({{$data['id']}})" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editData" tabindex="-1" role="dialog" aria-labelledby="editDataLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDataLabel">ဌာနခွဲအချက်အလက်ပြင်ဆင်ရန်</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="update">
          <input type="hidden" name="id" class="hidden_id"> 
          <div class="form-group">
              <label for="">ဌာန</label>
                <select name="main_depart_id" class="form-control main_depart_option">
                    @if(count($main_departs) > 0)
                        @foreach($main_departs as $data)
                        <option value="{{$data->id}}">{{$data->depart_name}}</option>
                        @endforeach
                    @endif
                </select>
          </div>
          <div class="form-group">
            <label for="">ဌာနခွဲအမည်</label>
            <input type="text" name="name" placeholder="ဌာနခွဲအမည်" class="form-control name">
          </div>
          <div class="form-group">
            <label for="">ရုံးဖုန်း</label>
            <input type="text" name="office_phone" placeholder="ရုံးဖုန်း" class="form-control office_phone">
          </div>
          <div class="form-group">
            <label for="">ဦးစီးအရာရှိဖုန်း</label>
            <input type="text" name="human_phone" placeholder="ဦးစီးအရာရှိဖုန်း" class="form-control human_phone">
          </div>
          <div class="form-group">
            <label for="">လိပ်စာ</label>
            <input type="text" name="address" placeholder="လိပ်စာ" class="form-control address">
          </div>
          <div class="form-group">
            <label>တည်နေရာ</label>
            <div class="row">
              <div class="col-md-6">
                <label for="">Latitude</label>
                <input type="text" name="latitude" placeholder="Latitude | eg.16.832383" class="form-control latitude">
              </div>
              <div class="col-md-6">
                <label for="">Longitude</label>
                <input type="text" name="longitude" placeholder="Longitude | eg.16.832383" class="form-control longitude">
              </div>
            </div>
          </div>
            <div class="form-group new_pass_input" style="display : none;">
              <div class="form-label-group">
                <input type="password" class="form-control" placeholder="New Password" name="new_password" autocomplete="off">
              </div>
            </div>
          <div class="form-group">
            <label for="logo" class="btn btn-primary">Logo</label>
            <input type="file" id="logo" name="logo">
            <button type="button" class="btn btn-primary float-right" onclick="change_pass()">Change Password</button>
          </div>
          <div class="form-group">
            <input type="submit" name="" value="Change" class="btn-block btn btn-info btn-md">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop
@section('js')
<script>
  removeShowEntryOnDataTable("paginate");
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
   // edit data
   let editData = function(id) {
    let url="{{url('admin/sub-depart/data/edit')}}/"+id;
    $.ajax({
      url : url,
      type : "get",
      dataType : "json"
    }).done(function(response){
      console.log(response);
      $(".hidden_id").val(response['id']);
      $(".name").val(response['name']);
      $(".office_phone").val(response['office_phone']);
      $(".human_phone").val(response['human_phone']);
      $(".address").val(response['address']);
      $(".latitude").val(response['latitude']);
      $(".longitude").val(response['longitude']);
      $(".main_depart_option").val(response['main_depart_id']);
    }).fail(function(error){
      console.log(error);
    });
  }

  $(document).on('submit','#update', function(e) { // update data 
    e.preventDefault();
    let form_data = new FormData(this);
    let url = "{{url('admin/update/sub-depart-data')}}";
    $.ajax({
      url: url,
      type: "post",
      data: form_data,
      dataType: "json",
      processData: false,
      contentType: false,
    }).done(function(response) {
      if (response) {
        toastr.success("Update Successful!");
        location.reload();
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

      if (error.responseJSON.errors.new_password) {
        toastr.error(error.responseJSON.errors.new_password[0]);
      }
    });
  });

  // delete sub depart data
  var deleteSubDepart=function(id){
    if(confirm("Are you sure?")){
      window.location.href=`{{url('admin/sub-depart/delete/${id}')}}`;
    }
  }

  let click=1;
  let change_pass=function(){
    if(click % 2 == 0){
      $(".new_pass_input").hide();
      $(".new_pass_input input[type='password']").removeAttr('required');
    }else{
      $(".new_pass_input").show();
      $(".new_pass_input input[type='password']").attr('required',true);
    }
      click++;
  }
</script>
@if(Session::has('success'))
<script>toastr.success("{{Session('success')}}")</script>
@endif
@stop
