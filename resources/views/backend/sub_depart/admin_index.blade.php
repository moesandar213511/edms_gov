@extends('layouts.app')
@section('title','DEPARTMENT DASHBOARD')
@section('content')
<div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats text-center" style="height:180px;">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">ဝင်စာပေါင်း</p>
                  <h4 class="card-title h3">{{$income_letter_qty}}</h4>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <a href="{{url('sub_depart/simple/income-letter')}}">Show All</a>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats text-center" style="height:180px;">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                      <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">ထွက်စာပေါင်း</p>
                  <h4 class="card-title h3">{{$outcome_letter_qty}}</h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <a href="{{url('sub_depart/simple/outcome-letter')}}">Show All</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats text-center" style="height:180px;">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">ထွက်စာ အသစ်ဖန်တီးခြင်း</p>
                  <h4 class="card-title"></h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                        <a href="#" data-toggle="modal" data-target="#myModalhtut">Click</a>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">ဌာနခွဲများ</p>
                  <h4 class="card-title">၁၆</h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                        <a href="sub_department.html">Click</a>
                  </div>
                </div>
              </div>
            </div> -->
           
          </div>

      
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
                                <td><a onclick="stateChange({{$data['id']}})" href="{{url('sub_depart/single/letter/'.$data['id'].'/'.Auth::user()->user_name)}}">{{$data['letter_no']}}</a></td>
                                <td>{{$data['title']}}</td>
                                <td>{{strlen($data['detail']) > 100 ? substr($data['detail'],0,100).'.....' : $data['detail']}}</td>
                                <td>{{$data['created_at']}}</td>
                                <th>{{$data['from_sub_depart_name']}}</th>
                                <td>လိပ်မူ</td>
                                <td><a onclick="stateChange({{$data['id']}})" href="{{url('sub_depart/file/download/'.$data['attach_file'])}}" class="btn btn-primary">Download</a></td>
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

        <!-- The Modal -->
   <div class="modal" id="myModalhtut">
      <div class="modal-dialog">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">ထွက်စာအမျိုးအစား</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">
            <h1>
              <a href="{{url('sub_depart/simple/output-letter/create')}}" class="btn btn-primary h2">ရိုးရိုးထွက်စာ</a>
              <a href="{{url('sub_depart/important/output-letter/create')}}" class="btn btn-primary h2">အရေးကြီးထွက်စာ</a>
            </h1>
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
          </div>
          
        </div>
      </div>
    </div>


    <!-- The Modal -->
   <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">ဌာနခွဲ</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">
              <b>ဌာနချုပ်အမည် ။&nbsp;&nbsp;&nbsp;&nbsp;။ </b>၀န်ကြီးဌာန <br>
              <b>ဌာနချုပ်ဖုန်း ။&nbsp;&nbsp;&nbsp;&nbsp;။ </b>၀၉ ၇၃၂၅၆၆၀၄ <br>
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          
        </div>
      </div>
    </div>
@stop
@section('js')
<script>
  
  removeShowEntryOnDataTable("paginate");
  var stateChange=function(id){
    let url="{{url('sub_depart/is-read/state-change')}}/"+id;
    $.ajax({
      url : url,
      type : "get"
    }).fail(function(error){
      console.log(error);
    });
  }
</script>
@stop