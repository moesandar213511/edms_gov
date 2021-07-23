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
                            ထွက်စာအသစ်ဖန်တီးခြင်း
                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="send">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="text" id="firstName" class="form-control" placeholder="စာအမှတ်" required="required" name="letter_no" autofocus="autofocus">
                                            <!-- <label for="firstName">စာအမှတ်</label> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label for="inputEmail">ရက်စွဲ</label>
                                    <input type="date" id="inputEmail" name="date" class="form-control" placeholder="ရက်စွဲ" required="required">

                                </div>
                            </div>
                            <div class="form-group">

                                <div class="form-label-group">
                                    <input type="text" class="form-control" placeholder="ခေါင်းစဉ်" name="title" required="required">
                                    <!-- <label for="inputPassword">ခေါင်းစဉ်</label> -->
                                </div>
                                <br>
                            </div>
                            <div>
                                <div class="form-label-group">
                                    <input type="text" class="form-control" placeholder="ရည်ညွှန်းစာ" required="required" name="purpose_letter">
                                    <!-- <label for="confirmPassword">ရည်ညွှန်းစာ</label> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <select name="in_sub_depart_id" class="form-control sub_department_option">
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
                                            <textarea class="form-control" placeholder="အကြောင်းအရာ" name="detail" required="required" autofocus="autofocus"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-label-group">
                                            <input type="file" name="attach_file" id="pullTwaePer" hidden="hidden" accept="file_extension|image/*" class="file">
                                            <label for="pullTwaePer" class="btn btn-info text-white">ပူးတွဲပါ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12 copy_depart">
                                        <div class="form-label-group">
                                            <select name="copy_depart[]" id="matehtu" style="width: 85%;display: inline;" class="form-control">
                                                @if(count($sub_departs) > 0)
                                                @foreach($sub_departs as $data)
                                                <option value="{{$data->id}}">{{$data->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <button type="button" style="width: 10%" class="btn btn-success" id="copy_depart">
                                                <!-- <i class="fas fa-plus"></i> -->+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary btn-block" value="Send">
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
    let no = 0;
    $(document).on('click', '#copy_depart', function() {
        let select_option=document.querySelector(".sub_department_option").innerHTML;
        no++;
        $(".copy_depart").append(`
            <div class="form-label-group all-remove remove-copy-department-id_${no}">
                <select name="copy_depart[]" id="matehtu" style="width: 85%;display: inline;" class="form-control">
                    ${select_option}
                </select>
                <button type="button" style="width: 10%" class="btn btn-danger" id="remove-copy-department" data-id="${no}">
                 <!-- <i class="fas fa-plus"></i> -->-</button>
             </div>
        `);
    });

    // remove copy department
    $(document).on('click', '#remove-copy-department', function() {
        let id = $(this).data('id');
        $(".remove-copy-department-id_" + id).remove();
    });

    let extension=0;
    $('input[type="file"]').change(function(e){ // get file extension
        var fileName = e.target.files[0].name;
        extension=fileName.split('.')[1];
    });

    let file_size=0;
    $(document).on('change','.file',function(){
        file_size= this.files[0].size;
    });

    let form=document.querySelector('form');
    $(document).on('submit','#send',function(e){
        e.preventDefault();
        if(file_size/1024 < 20480 && extension != "mp4"){ // convert to kilo bytes // max - 20MB
        let form_data=new FormData(this);
        let url="{{url('sub_depart/send/simple/output-letter')}}";
        $.ajax({
            url : url,
            type : 'post',
            data : form_data,
            processData : false,
            contentType : false
        }).done(function(response){
            if(response){
                toastr.success("Send Successful");
                form.reset();
                $(".all-remove").remove();
            }
        }).fail(function(error){
            console.log(error);
            if (error.responseJSON.errors.title) {
                toastr.error(error.responseJSON.errors.title[0]);
            }

            if (error.responseJSON.errors.attach_file) {
                toastr.error(error.responseJSON.errors.attach_file[0]);
            }
        });
        }else if(extension == "mp4"){
            toastr.error("This attach file does not allow movie and video.")
        }else{
            toastr.error("This attach file you are trying to send exceed the 20 MB.")
        }
    });

    function getFile(filePath) { // get file extension
        return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
    }


</script>
@stop