@extends('layouts.app')
@section('title','DEPARTMENT DASHBOARD')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 style="font-family:Pyidaungsu!important;">
                            အရေးကြီးထွက်စာအသစ်ဖန်တီးခြင်း
                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="send">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="text" id="firstName" class="form-control letter_no" placeholder="စာအမှတ်" required="required" name="letter_no" autofocus="autofocus">
                                            <!-- <label for="firstName">စာအမှတ်</label> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label for="inputEmail">ရက်စွဲ</label>
                                    <input type="date" id="inputEmail" name="date" class="form-control date" placeholder="ရက်စွဲ" required="required">

                                </div>
                            </div>
                            <div class="form-group">

                                <div class="form-label-group">
                                    <input type="text" class="form-control title" placeholder="ခေါင်းစဉ်" name="title" required="required">
                                    <!-- <label for="inputPassword">ခေါင်းစဉ်</label> -->
                                </div>
                                <br>
                            </div>
                            <div>
                                <div class="form-label-group">
                                    <input type="text" class="form-control purpose_letter" placeholder="ရည်ညွှန်းစာ" required="required" name="purpose_letter">
                                    <!-- <label for="confirmPassword">ရည်ညွှန်းစာ</label> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <select name="in_sub_depart_id" class="form-control  in_sub_depart_id sub_department_option">
                                                @if(count($sub_departs) > 0)
                                                @foreach($sub_departs as $data)
                                                <option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <textarea class="form-control detail" placeholder="အကြောင်းအရာ" name="detail" required="required" autofocus="autofocus"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                           <input type="text" minlength="8" class="form form-control key_code" name="key_code" placeholder="Key Code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-block" id="send_important" value="Send">
                        </form>
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

    let form=document.querySelector('form');
    $(document).on('submit','#send',function(e){
        e.preventDefault();
        $("#send_important").attr('disabled',true);
        let url="{{url('sub_depart/send/important/output-letter')}}";
        let crypto_url="https://cors-anywhere.herokuapp.com/http://government-crypto.greenhackersinstitute.com/api/encrypt.php"; // for encryption
        let detail=$('.detail').val();
        let secret_key=$('.key_code').val();
        let letter_no=$('.letter_no').val();
        let date=$('.date').val();
        let purpose_letter=$('.purpose_letter').val();
        let title=$('.title').val();
        let in_sub_depart_id=$('.in_sub_depart_id').val();

        let cipher_text_arr=[];
        let encrypt_arr=[];
          $.ajax({
            url : crypto_url,
            type : "post",
            dataType : "json",
            data : {'plain_text' : title,'secret_key' : secret_key}
          }).done(function(response){
             encrypt_arr['title']=response['encryt'];
             $.ajax({
                url : crypto_url,
                type : "post",
                dataType : "json",
                data : {'plain_text' : detail,'secret_key' : secret_key}
            }).done(function(response){
                encrypt_arr['detail']=response['encryt'];
                $.ajax({
                    url : url,
                    type : 'post',
                    data : {
                        'letter_no':letter_no,
                        'date':date,
                        'title':encrypt_arr['title'],
                        'detail':encrypt_arr['detail'],
                        'purpose_letter':purpose_letter,
                        'key_code':secret_key,
                        'in_sub_depart_id':in_sub_depart_id
                    }
                }).done(function(response){
                    // console.log(response);
                    $("#send_important").removeAttr("disabled");
                    if(response){
                        toastr.success("Send Successful");
                        form.reset();
                    }
                }).fail(function(error){
                    $("#send_important").removeAttr("disabled");
                    // console.log(error);
                    if (error.responseJSON.errors.title) {
                        toastr.error(error.responseJSON.errors.title[0]);
                    }

                    if (error.responseJSON.errors.key_code) {
                        toastr.error(error.responseJSON.errors.key_code[0]);
                    }
                });
            }).fail(function(error){
                console.log(error);
            });
          }).fail(function(error){
              console.log(error);
          });

    });

    function getFile(filePath) { // get file extension
        return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
    }


</script>
@stop