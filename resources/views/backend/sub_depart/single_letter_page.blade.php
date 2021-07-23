@extends('layouts.app')
@section('title','DEPARTMENT DASHBOARD')
@section('content')
<div class="content">
         <div class="container-fluid" id="print_page">
           <div class="row">
            <div class="col-md-12">
                    <div class="container mt-5">
                            <div class="row">
                              <div class="col-md-1"></div>
                              <div class="col-md-10">
                                <div class="card">
                                  <div class="card-body">
                                    <table class="w-100">
                                      <tr>
                                        <td><p class="float-right">စာအမှတ် : {{$letter_data['letter_no']}}</p></td>
                                      </tr>
                                      <tr>
                                        <td><p class="float-right">ရက်စွဲ : {{$letter_data['date']}}</p></td>
                                      </tr> 
                                      <tr>
                                        <td><p>သို့</p></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <table>
                                            <tr>
                                              <td></td>
                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$letter_data['to_sub_depart_name']}}</td>
                                            </tr>
                                          </table>
                                          <br>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <table>
                                            <tr>
                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;အကြောင်းအရာ ။&nbsp;&nbsp;&nbsp;။ </td>
                                              <td>{{$letter_data['title']}}</td>
                                            </tr>
                                          </table>
                                          <br>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <table>
                                            <tr>
                                              <td></td>
                                              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ရည်ညွှန်းစာ။&nbsp;&nbsp;&nbsp;။ {{$letter_data['purpose_letter']}}</td>
                                            </tr>
                                          </table>
                                          <br>
                                        </td>
                                      </tr>
                                      <tr>
                                          <td>
                                              <table>
                                                  <tr>
                                                      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$letter_data['detail']}}</td>
                                                  </tr>
                                              </table>
                                          </td>
                                      </tr>
                                      <br>
                                      <tr>
                                        <td>ပူးတွဲပါ။&nbsp;&nbsp;&nbsp;။ <a href="{{url('sub_depart/file/download/'.$letter_data['attach_file'])}}">Download</a><br></td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <br>
                                          <table>
                                            <tr>
                                              <td>မိတ္ထူဌာန</td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <ul>
                                                @if(count($copy_departs) > 0)
                                                    @foreach($copy_departs as $data)
                                                       <li>{{$data}}</li>
                                                    @endforeach
                                                @endif
                                                </ul>
                                              </td>
                                            </tr>
                                          </table>
                                          <br>
                                        </td>
                                      </tr>
                                                  
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-1"></div>
                            </div>
                          </div>
            </div>
           </div>
         </div>
       </div>
       <div class="row">
          <div class="col-md-10 mx-auto mb-5" style="margin-top: -20px;">
          <a href="#" class="btn btn-primary float-right" id="print_page_data">Print</a>
       </div>
@stop
@section('js')
    <script>
        $(function(){
            $(document).on('click','#print_page_data',function(){
                var printContents = document.getElementById('print_page').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = "<br><br><br><br><br><br><br>"+printContents;
                window.print();
                document.body.innerHTML = originalContents;
            });
        });
    </script>
@stop