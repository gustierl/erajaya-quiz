@extends('layouts.app_user')
<style>
    .rule-text{
        border: 1px solid rgb(176, 176, 176);
        border-radius: 7px;
        font-size: 9pt;
        padding: 30px 20px 20px 30px;
    }
</style>
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h5 class="mt-3">Your High Score : <span style="font-size:24pt; font-weight:800;" id="highScore"><strong></strong></span></h5>
                   
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h3 class="mt-3">Erajaya Quiz</h3>
                    <div class="page-title-right">
                        <button type="button" id="btnStart" class="btn btn-primary btn-lg">Mulai Quiz <i class=" ri-login-box-line align-middle ms-2"></i></button>
                    </div>
                </div>
                <div class="rule-text mt-1">
                    <label>Peraturan Quiz : </label>
                    <ul>
                        <li>Berdoa sebelum memulai quiz</li>
                        <li>Dilarang Googling</li>
                        <li>Waktu pengerjaan soal 15 menit, ketika tombol "<strong>Mulai Quiz</strong>" di klik.</li>
                        <li>Score akan ditampilkan diakhir sesi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $.ajax({
            method:'GET',
            url:"{{route('home.score')}}",
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(res){
                $('#highScore').html('<i class="mdi mdi-spin mdi-loading"></i>');
                $('#rank').html('<i class="mdi mdi-spin mdi-loading"></i>');

            },success:function(res){
                $('#highScore').html(res.highScore);
                $('#rank').html('#'+res.rank);

            },error:function(res){
                $('#highScore').html('error');
                $('#rank').html('error');
            }

        });
        $('#btnStart').on('click', function(){
            $(this).html('Mulai quiz');
            $(this).attr('disabled',true);
            $.ajax({
                method:'POST',
                url:"{{route('quiz.create')}}",
                dataType:'JSON',
                data:{
                    '_token':"{{ csrf_token() }}"
                },
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(res){
                    $('#btnStart').attr('disabled',true);
                    $('#btnStart').html('loading...');

                },success:function(res){
                    var url = '{{ route("quiz.index", ":id") }}';
                    url = url.replace(':id', res.id);
                    window.location.href=url;

                },error:function(res){
                    $('#btnStart').attr('disabled',true);
                    $('#btnStart').html('loading...');
                }

            });
        })
    })
</script>
@endsection
