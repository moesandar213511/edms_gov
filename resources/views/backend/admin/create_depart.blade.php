@extends('layouts.app')
@section('title','ADMIN DASHBOARD')
@section('content')
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <form id="create">
            <input type="hidden" name="id" class="depart_id">
            <div class="form-group">
              <div class="form-label-group">
                <input class="form-control depart_name" type="text" name="depart_name" placeholder="ဌာနအမည်" required autocomplete="off">
              </div>
            </div>
          <!-- <div class="for-change">
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" class="form-control" placeholder="Password" required name="password" autocomplete="off">
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="off">
              </div>
            </div>
          </div> -->
            <div class="submit">
              <input type="submit" class="btn btn-primary" value="Created">
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title text-center">ဌာန</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="paginate">
                <thead class=" text-primary">
                  <th>
                    စဉ်
                  </th>
                  <th>
                    ဌာနအမည်
                  </th>
                  <th>
                    ပြင်ဆင်ရန်
                  </th>
                  <th>
                    ပယ်ဖျက်ရန်
                  </th>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
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
  let paginate = document.querySelector("#paginate");
  let depart_id = document.querySelector(".depart_id");
  removeShowEntryOnDataTable("paginate");
  let submit = document.querySelector(".submit");
  let table = $("#paginate").DataTable();
  let depart_name = document.querySelector(".depart_name");
  // let for_change=document.querySelector("form .for-change");

  let load_data = function() {
    table.clear().draw();
    let url = "{{url('admin/depart/data')}}";
    $.ajax({
      url: url,
      type: "get",
      dataType: "json"
    }).done(function(response) {
      response.map((data, index) => {
        let no = index + 1;
        let depart_name = data['depart_name'];
        var edit = `<td><button class="btn btn-sm btn-primary" onclick="editData(${data['id']})" id="edit">Edit</button></td>`;
        let del = `<td><a href="#" class="btn btn-sm btn-danger" onclick="deleteData(${data['id']})">Delete</a></td>`;
        table.row.add([no, depart_name, edit,del]).draw();
      });
    }).fail(function(error) {
      console.log(error);
    });
  }

  load_data(); // load data

  $(document).on('submit', '#create', function(e) { // store data 
    e.preventDefault();
    let form_data = new FormData(this);
    let url = "{{url('admin/store/depart')}}";
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
        load_data();
        loadData(); // department show
      }
    }).fail(function(error) {
      if (error.responseJSON.errors.depart_name) {
        toastr.error(error.responseJSON.errors.depart_name[0]);
      }

      if (error.responseJSON.errors.password) {
        toastr.error(error.responseJSON.errors.password[0]);
      }
    });
  });

  // edit data
  let editData = function(id) {
    form.setAttribute("id", "update");
    // for_change.innerHTML=`
    //         <div class="form-group">
    //           <div class="form-label-group">
    //             <a href="#" class="btn btn-sm btn-primary rounded-0" onclick="change_pass()">Change Password</a>
    //           </div>
    //         </div>
    //         <div class="form-group new_pass_input" style="display : none;">
    //           <div class="form-label-group">
    //             <input type="password" class="form-control" placeholder="New Password" name="new_password" autocomplete="off">
    //           </div>
    //         </div>`;
    submit.innerHTML = '<input type="submit" class="btn btn-info" value="Update"><button class="btn btn-info float-right" onclick="cancle()">Cancle</button>';
    let url = "{{url('admin/depart/data/edit')}}/" + id;
    fetch(url)
      .then(response => response.json())
      .then(response => {
        depart_name.value = response['depart_name'];
        depart_id.value = response['id'];
      })
      .catch(error => console.log(error))
  }

  $(document).on('submit', '#update', function(e) { // update data 
    e.preventDefault();
    let form_data = new FormData(this);
    let url = "{{url('admin/update/depart')}}";
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
        load_data();
        loadData(); // department show
      }
    }).fail(function(error) {

      if (error.responseJSON.errors.depart_name) {
        toastr.error(error.responseJSON.errors.depart_name[0]);
      }

      if (error.responseJSON.errors.new_password) {
        toastr.error(error.responseJSON.errors.new_password[0]);
      }
    });
  });

  let cancle = function() {
    form.reset();
    form.setAttribute("id", "create");
    submit.innerHTML = '<input type="submit" class="btn btn-primary" value="Created">';
    for_change.innerHTML=`
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" class="form-control" placeholder="Password" required name="password" autocomplete="off">
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="off">
              </div>
            </div> 
    `;
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

  // ------------------------------------------delete main department ----------------------
  let deleteData=function(id){
    let delete_url="{{url('admin/main-depart/delete')}}/"+id;
    let url="{{url('admin/main-depart/related/sub-depart')}}/"+id;;
    $.ajax({
      url : url,
      type : "get",
      dataType : "json"
    }).done(function(response){
        if(confirm(`This department has ${response} sub department. Are you sure you want to delete?`)){
            $.ajax({
              url : delete_url,
              type : "post",
              data : {'_method' : 'delete'},
              dataType : "json"
            }).done(function(response){
              toastr.success("Delete Data Successful!");
              load_data();
              loadData(); // department show
            }).fail(function(error){
              console.log(error);
            });
        }

    }).fail(function(error){
      console.log(error);
    });
  }
</script>
@stop