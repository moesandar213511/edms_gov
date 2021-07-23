@extends('layouts.app')
@section('title','DEPARTMENT DASHBOARD')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h4>
                    ကိုယ်ရေးအချက်လက်ပြင်ရန်
                </h4>
                <form method="POST" action="{{url('sub_depart/profile_setting/change')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$profile_setting['id']}}">
                    <div class="form-group">
                        <label for="">ဌာနခွဲအမည်</label>
                        <input type="text" name="name" value="{{$profile_setting['name']}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">ရုံးဖုန်း</label>
                        <input type="text" name="office_phone"value="{{$profile_setting['office_phone']}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">ဦးစီးအရာရှိဖုန်း</label>
                        <input type="text" name="human_phone" value="{{$profile_setting['human_phone']}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">လိပ်စာ</label>
                        <input type="text" name="address" value="{{$profile_setting['address']}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>တည်နေရာ</label>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Latitude</label>
                                <input type="text" name="latitude" value="{{$profile_setting['latitude']}}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Longitude</label>
                                <input type="text" name="longitude" value="{{$profile_setting['longitude']}}" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="form-group new_pass_input" style="display : none;">
                        <div class="form-label-group">
                            <label for="">New Password</label>
                            <input type="password" class="form-control" name="new_password" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="logo" class="btn btn-primary">Logo</label>
                        <input type="file" id="logo" name="logo">
                        <button type="button" class="btn btn-primary float-right" onclick="change_pass()">Change Password</button>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Change" class="btn-block btn btn-info btn-md">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
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
	<script>
		toastr.success("{{Session('success')}}");
	</script>
	@endif

	@error('name')
	<script>
		toastr.error("{{ $message }}");
	</script>
	@enderror

    @error('office_phone')
	<script>
		toastr.error("{{ $message }}");
	</script>
	@enderror

    @error('human_phone')
	<script>
		toastr.error("{{ $message }}");
	</script>
	@enderror

    @error('address')
	<script>
		toastr.error("{{ $message }}");
	</script>
	@enderror

    @error('logo')
	<script>
		toastr.error("{{ $message }}");
	</script>
	@enderror

    @error('new_password')
	<script>
		toastr.error("{{ $message }}");
	</script>
	@enderror

    @error('latitude')
	<script>
		toastr.error("{{ $message }}");
	</script>
	@enderror

    @error('longitude')
	<script>
		toastr.error("{{ $message }}");
	</script>
	@enderror
@stop