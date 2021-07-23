@extends('layouts.app')
@section('title','DEPARTMENT DASHBOARD')
@section('content')
<div class="content">
          <div id="content-wrapper">
            <div class="container-fluid">
        <!-- Dashboard Home -->
          <form id="search">
              <div class="form-group" style="width: 20%!important;display: inline-block!important;">
              <div style="display: block;width: 100%;">
                <input type="date" name="from" class="form-control" required style="width: 90%;display: inline;"> 
              </div>
            </div>
            <span>မှ</span>
            &nbsp;&nbsp;&nbsp;
            <div class="form-group" style="width: 20%!important;display: inline-block!important;">
               <div style="display: block;width: 100%;">
                <input type="date" name="to" class="form-control" required style="width: 90%;display: inline;"> 
              </div>
            </div>
            <span style="display: inline-block;">ထိ</span>
            &nbsp;&nbsp;&nbsp;
              <div class="form-group" style="width: 20%!important;display: inline-block!important;">
                <select name="sub_depart_id" class="form-control">
                    @if(count($sub_departs) > 0)
                        @foreach($sub_departs as $data)
                        <option value="{{$data->id}}">{{$data->name}}</option>
                        @endforeach
                    @endif
                </select>
              </div>
              <span>ဌာန</span>
              &nbsp;&nbsp;&nbsp;
              <div class="form-group" style="width: 20%!important;display: inline-block!important;">
                <input type="submit" name="" value="Search" class="form-control btn btn-primary">
              </div>
          </form>
           <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item">
                          <a class="nav-link active daily_income_letter" href="#oneday_letter" data-toggle="tab">
                            ၂၄ နာရီအတွင်း
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link all_income_letter" href="#all_letter" data-toggle="tab">
                             ဝင်စာအားလုံး
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane active" id="oneday_letter">
                        <div class="card" style="overflow: scroll;height: 68vh;">
                          <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="paginate" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>စဉ်</th>
                          <th width="100px">ရက်စွဲ</th>
                          <th width="100px">စာအမှတ်</th>
                          <th>ခေါင်းစဉ်</th>
                          <th>အကြောင်းအရာ</th>
                          <th>အချိန်</th>
                          <th>မှ</>
                          <th>အဆင့်အတန်း</th>
                          <th>Download</th>
                        </tr>
                      </thead>
                      <tbody class="income_letter">
                         @if(count($income_letters) > 0)
                            @foreach($income_letters as $index=>$data)
                            <tr>
                            <td>{{$index+1}}</td>
                                <td>{{$data['date']}}</td>
                                <td><a href="{{url('sub_depart/single/letter/'.$data['id'].'/'.Auth::user()->user_name)}}">{{$data['letter_no']}}</a></td>
                                <td>{{$data['title']}}</td>
                                <td>{{strlen($data['detail']) > 100 ? substr($data['detail'],0,100).'.....' : $data['detail']}}</td>
                                <td>{{$data['created_at']}}</td>
                                <th>{{$data['from_sub_depart_name']}}</th>
                                <td>လိပ်မူ</td>
                                <td><a href="{{url('sub_depart/file/download/'.$data['attach_file'])}}" class="btn btn-primary">Download</a></td>
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
            </div>
          </div>
        <br>
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

        removeShowEntryOnDataTable("paginate");
        let table = $("#paginate").DataTable();
        let form=document.querySelector("form");
    
        $(document).on('click','.all_income_letter',function(){ // all income letters
            form.reset();
            table.clear().draw();
            let url="{{url('sub_depart/simple/all/income-letter')}}";
            $.ajax({
                url : url,
                type : "get",
                dataType : "json"
            }).done(function(response){
                response.map((data, index) => {
                    let no = index + 1;
                    let date=data['date'];
                    let auth_sub_depart_name="{{Auth::user()->user_name}}";
                    let url="{{url('sub_depart/single/letter')}}/"+data['id']+"/"+auth_sub_depart_name;
                    let letter_no=`<a href="${url}">${data['letter_no']}</a>`;
                    let title=data['title'];
                    let detail=data['detail'].length > 40 ? data['detail'].substring(0,40)+'.....' : data['detail'];
                    let created=data['created_at'];
                    let from=data['from_sub_depart_name'];
                    let level="လိပ်မူ";
                    let path="{{url('sub_depart/file/download')}}/"+data['attach_file'];
                    let download=`<a href="${path}" class="btn btn-primary">Download</a>`;
                    table.row.add([no,date,letter_no,title,detail,created,from,level,download]).draw();
                });
            }).fail(function(error){
                console.log(error);
            });
        });

        $(document).on('click','.daily_income_letter',function(){ // daily income data
            form.reset();
            table.clear().draw();
            let url="{{url('sub_depart/simple/income-letter')}}";
            $.ajax({
                url : url,
                type : "get",
                dataType : "json"
            }).done(function(response){
                response.map((data, index) => {
                    let no = index + 1;
                    let date=data['date'];
                    let auth_sub_depart_name="{{Auth::user()->user_name}}";
                    let url="{{url('sub_depart/single/letter')}}/"+data['id']+"/"+auth_sub_depart_name;
                    let letter_no=`<a href="${url}">${data['letter_no']}</a>`;
                    let title=data['title'];                    
                    let detail=data['detail'].length > 40 ? data['detail'].substring(0,40)+'.....' : data['detail'];
                    let created=data['created_at'];
                    let from=data['from_sub_depart_name'];
                    let level="လိပ်မူ";
                    let path="{{url('sub_depart/file/download')}}/"+data['attach_file'];
                    let download=`<a href="${path}" class="btn btn-primary">Download</a>`;
                    table.row.add([no,date,letter_no,title,detail,created,from,level,download]).draw();
                });
            }).fail(function(error){
                console.log(error);
            });
        });

        $(document).on('submit','#search',function(e){ // search income letter
          table.clear().draw();
          e.preventDefault();
          let form_data = new FormData(this);
          let url = "{{url('sub_depart/search/income_letter')}}";
            $.ajax({
              url: url,
              type: "post",
              data: form_data,
              dataType: "json",
              processData: false,
              contentType: false,
            }).done(function(response) {
              console.log(response);
                  response.map((data, index) => {
                      let no = index + 1;
                      let date=data['date'];
                      let auth_sub_depart_name="{{Auth::user()->user_name}}";
                      let url="{{url('sub_depart/single/letter')}}/"+data['id']+"/"+auth_sub_depart_name;
                      let letter_no=`<a href="${url}">${data['letter_no']}</a>`;
                      let title=data['title'];
                      let detail=data['detail'].length > 40 ? data['detail'].substring(0,40)+'.....' : data['detail'];
                      let created=data['created_at'];
                      let from=data['from_sub_depart_name'];
                      let level="လိပ်မူ";
                      let path="{{url('sub_depart/file/download')}}/"+data['attach_file'];
                      let download=`<a href="${path}" class="btn btn-primary">Download</a>`;
                      table.row.add([no,date,letter_no,title,detail,created,from,level,download]).draw();
                  });
          }).fail(function(error){
              console.log(error);
          });
        });
    </script>
@stop