@extends('layouts.app')
@section('title','DEPARTMENT DASHBOARD')
@section('content')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-11 mx-auto">
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
                                    <th>
                                        အကြောင်းအရာ
                                    </th>
                                    <th>
                                        အသေးစိတ်
                                    </th>
                                    <th>
                                        Download
                                    </th>
                                </thead>
                                <tbody>
                                    @if(count($adjure_datas) > 0)
                                    @foreach($adjure_datas as $index=>$data)
                                    <tr>
                                        <td>{{$index+1}}</td>
                                        <td>{{$data['title']}}</td>
                                        <td style="width:320px;">{{strlen($data['description']) > 100 ? substr($data['description'],0,100).'.....' : $data['description']}}</td>
                                        <td>
                                        <button type="button" class="btn btn-sm btn-primary detail" data-id="{{$data['id']}}" data-toggle="modal" data-target="#detailData">
                                            Detail
                                        </button>
                                        </td>
                                        <td><a href="{{url('adjure/file/download/'.$data['file'])}}" class="btn btn-sm btn-primary">Download</a>
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
    removeShowEntryOnDataTable("paginate");
    let table = $("#paginate").DataTable();

    $(function(){
        $(document).on('click','.detail',function(){
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
    });
</script>
@stop