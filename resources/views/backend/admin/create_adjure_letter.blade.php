@extends('layouts.app')
@section('title','ADMIN DASHBOARD')
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <form id="create">
                        <input type="hidden" name="id" class="hidden_id">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input class="form-control title" type="text" name="title" placeholder="ခေါင်းစဉ်" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <textarea name="description" class="form form-control description" placeholder="အကြောင်းအရာ" cols="30" rows="5"></textarea required>
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="file" name="file" id="pullTwaePer" hidden="hidden" class="file">
                                            <label for="pullTwaePer" class="btn btn-info text-white">Upload PDF File</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit">
                            <input type="submit" class="btn btn-primary btn-block" value="Created">
                            </div>
                        </form>
                        </div>
                    </div>
      <div class="col-md-7">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title text-center">အမိန့်နှင့်ညွှန်ကြားချက်</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table" id="paginate">
                <thead class=" text-primary">
                  <th>
                    စဉ်
                  </th>
                  <th>
                    ခေါင်းစဉ်
                  </th>
                  <!-- <th>
                    Download
                  </th> -->
                  <th>
                     အသေးစိတ်
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

<!-- Detail Modal -->
<div class="modal fade" id="detailData" tabindex="-1" role="dialog" aria-labelledby="detailDataTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="detailDataTitle">Modal title</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h5 class="title">

        </h5>
        <a href="#" class="text-primary file_link">Download PDF File</a><br>
        <p class="description">

        </p>
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
  let hidden_id = document.querySelector(".hidden_id");
  removeShowEntryOnDataTable("paginate");
  let submit = document.querySelector(".submit");
  let table = $("#paginate").DataTable();
  let title = document.querySelector(".title");
  let description = document.querySelector(".description");
  // let for_change=document.querySelector("form .for-change");

  let load_data = function() {
    table.clear().draw();
    let url = "{{url('admin/adjure/data')}}";
    $.ajax({
      url: url,
      type: "get",
      dataType: "json"
    }).done(function(response) {
        // console.log(response);
      response.map((data, index) => {
        let no = index + 1;
        let title = data['title'];
        // let description=data['description'].length > 40 ? data['description'].substring(0,40)+'.....' : data['description'];
        let path="{{url('adjure/file/download')}}/"+data['file'];
        // let download=`<a href="${path}" class="btn btn-sm btn-primary">Download</a>`;
        var edit = `<td><button class="btn btn-sm btn-primary" onclick="editData(${data['id']})" id="edit">Edit</button></td>`;
        let del = `<td><a href="#" class="btn btn-sm btn-danger" onclick="deleteData(${data['id']})">Delete</a></td>`;
        let detail=`<button type="button" class="btn btn-sm btn-primary detail_data" data-id="${data['id']}" data-toggle="modal" data-target="#detailData">                              Detail</button>`;
        table.row.add([no,title,detail,edit,del]).draw();
      });
    }).fail(function(error) {
      console.log(error);
    });
  }

  load_data(); // load data

  $(document).on('submit', '#create', function(e) { // store data 
    e.preventDefault();
    let form_data = new FormData(this);
    let url = "{{url('admin/store/adjure/letter')}}";
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
      }
    }).fail(function(error) {
    //   console.log(error);
      if (error.responseJSON.errors.file) {
        toastr.error(error.responseJSON.errors.file[0]);
      }

      if (error.responseJSON.errors.title) {
        toastr.error(error.responseJSON.errors.title[0]);
      }

      if (error.responseJSON.errors.description) {
        toastr.error(error.responseJSON.errors.description[0]);
      }
    });
  });

  // edit data
  let editData = function(id) {
    form.setAttribute("id", "update");
    submit.innerHTML = '<input type="submit" class="btn btn-info" value="Update"><button class="btn btn-info float-right" onclick="cancle()">Cancle</button>';
    let url = "{{url('admin/adjure/data/edit')}}/" + id;
    fetch(url)
      .then(response => response.json())
      .then(response => {
        title.value = response['title'];
        description.value = response['description'];
        hidden_id.value = response['id'];
      })
      .catch(error => console.log(error))
  }

  $(document).on('submit', '#update', function(e) { // update data 
    e.preventDefault();
    let form_data = new FormData(this);
    let url = "{{url('admin/update/adjure')}}";
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
        
      }
    }).fail(function(error) {
       if (error.responseJSON.errors.file) {
        toastr.error(error.responseJSON.errors.file[0]);
      }

      if (error.responseJSON.errors.title) {
        toastr.error(error.responseJSON.errors.title[0]);
      }

      if (error.responseJSON.errors.description) {
        toastr.error(error.responseJSON.errors.description[0]);
      }
    });
  });

  let cancle = function() {
    form.reset();
    $(".description").text('');
    form.setAttribute("id", "create");
    submit.innerHTML = '<input type="submit" class="btn btn-primary btn-block" value="Created">';
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

  // ------------------------------------------delete adjure data ----------------------
  let deleteData=function(id){
    let delete_url="{{url('admin/delete/adjure/data')}}/"+id;
    if(confirm(`Are you sure you want to delete?`)){
            $.ajax({
              url : delete_url,
              type : 'post',
              data : { '_method' : 'delete'},
              dataType : "json"
            }).done(function(response){
              toastr.success("Delete Data Successful!");
              load_data();
            }).fail(function(error){
              console.log(error);
            });
        }
  }

  // -------------------------------------detail adjure data ---------------------
  $(document).on('click','.detail_data',function(){
            var id=$(this).data('id');
            $.ajax({
                    url : "{{url('adjure/data/detail')}}/"+id,
                    type : "get",
                    dataType : "json"
            }).done(function(response){
                $(".title").text(response['title']);
                $(".description").text(response['description']);
                let path="{{url('adjure/file/download')}}/"+response['file'];
                $(".file_link").attr("href",path);
            }).fail(function(error){
                console.log(error);
            });
        });
</script>
@stop