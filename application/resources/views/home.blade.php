@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total User</p>
                        <h4 class="mb-2" id="totalUser"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="ri-user-line font-size-24"></i>  
                        </span>
                    </div>
                </div>                                            
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total Pertanyaan</p>
                        <h4 class="mb-2" id="totalQuestion"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="ri-questionnaire-line font-size-24"></i>  
                        </span>
                    </div>
                </div>                                            
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Total Quiz</p>
                        <h4 class="mb-2" id="totalQuiz"></h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-primary rounded-3">
                            <i class="ri-bookmark-line font-size-24"></i>  
                        </span>
                    </div>
                </div>                                            
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5>Rank Quiz :</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No </th>
                            <th>ID Soal </th>
                            <th>Nama</th>
                            <th>Total Score</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody id="rank">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $.ajax({
            method:'GET',
            url:"{{route('home.admin')}}",
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(res){
                $('#totalUser').html('<i class="mdi mdi-spin mdi-loading"></i>');
                $('#totalQuestion').html('<i class="mdi mdi-spin mdi-loading"></i>');
                $('#totalQuiz').html('<i class="mdi mdi-spin mdi-loading"></i>');

            },success:function(res){
                $('#totalUser').html(res.totalUser);
                $('#totalQuestion').html(res.totalQuestion);
                $('#totalQuiz').html(res.totalQuiz);
                var result = '';
                var number =0;
                $.each(res.rank, function( key, value ) {
                    number++;
                    result ='<tr>'+
                            '<td>'+number+'</td>'+
                            '<td>'+value['quiz_code']+'</td>'+
                            '<td>'+value['name']+'</td>'+
                            '<td>'+value['total_score']+'</td>'+
                            '<td>'+value['created_at']+'</td>'+
                            '</tr>';
                            $('#rank').append(result);

                });
            },error:function(res){
                $('#totalUser').html('error');
                $('#totalQuestion').html('error');
                $('#totalQuiz').html('error');
            }

        });
    })
</script>
@endsection
