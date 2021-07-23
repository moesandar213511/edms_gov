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
                                    </table>
                                            <div class="row">
                                                <div class="col-md-8 mx-auto" style="font-size: 14px;">
                                                အကြောင်းအရာ ။ <span class="important_title">{{$letter_data['title']}}</span>
                                                </div>
                                            </div><br>
                                    <table>
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
                                    </table>
                                    <div class="row">
                                        <div class="col-md-12 important_detail">
                                        {{$letter_data['detail']}}
                                        </div>
                                    </div>
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
        <div class="row mx-auto">       
            <div class="col-md-7">
            <form id="decrypt">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="key_code" autocomplete="off" required class="form form-control key_code" minlength="8" placeholder="လျှို့ ဝှက်ကုဒ်">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" style="font-size:14px;" id="decrypt_submit" class="btn btm-sm btn-primary">လျှို့ ဝှက်စာဖြည်ရန်</button>
                    </div>
                </div>
            </form>
            </div>
            <div class="col-md-3 mb-5">
                <a href="#" class="btn btn-primary float-right" id="print_page_data">Print</a>
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

        $(function(){
            $(document).on('click','#print_page_data',function(){
                var printContents = document.getElementById('print_page').innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = "<br><br><br><br><br><br><br>"+printContents;
                window.print();
                document.body.innerHTML = originalContents;
            });

            let form=document.querySelector("form");
            $(document).on('submit','#decrypt',function(e){ // decrypt
                $("#decrypt_submit").attr("disabled",true);
                e.preventDefault();
                let key_code=$(".key_code").val();
                let title=$(".important_title").text();
                let detail=$(".important_detail").text();
                let crypto_url="https://cors-anywhere.herokuapp.com/http://government-crypto.greenhackersinstitute.com/api/decrypt.php"; // for decryption
                let decrypt_arr=[];
                $.ajax({
                    url: crypto_url,
                    type: "post",
                    data: {'cipher_text' : title, 'secret_key':key_code},
                    dataType: "json"
                    }).done(function(response) {
                        decrypt_arr['title']=response['decrypt'];
                        $.ajax({
                            url: crypto_url,
                            type: "post",
                            data: {'cipher_text' : detail, 'secret_key':key_code},
                            dataType: "json"
                            }).done(function(response) {
                                $("#decrypt_submit").removeAttr("disabled");
                                decrypt_arr['detail']=response['decrypt'];
                                if(decrypt_arr['title'] == "none" || decrypt_arr['detail'] == "none"){
                                    toastr.error("Please check your key code.");
                                }else{
                                    $(".important_title").text(decrypt_arr['title']);
                                    $(".important_detail").text(decrypt_arr['detail']);
                                }
                                form.reset();
                            }).fail(function(error) {
                            $("#decrypt_submit").removeAttr("disabled");
                            console.log(error);
                        });
                    }).fail(function(error) {
                       console.log(error);
                });
            });
        });
    </script>
@stop