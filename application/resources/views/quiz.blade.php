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
       <form id="data-form">
        @csrf
        <input type="hidden" id="quiz_code" value="{{$quiz_code}}" name="quiz_code">
            <div class="card">
                <div class="card-body">
                    <div class="row" id="loading-quiz">
                        <div class="col text-center">
                        <h1><i class="mdi mdi-spin mdi-loading"></i></h1>
                        <h5>loading...</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" id="question_list">
                            
                        </div>
                        <div class="col-lg-12">
                            <div style="font-size: 80%;color: #f32f53;" id="error-answer"></div><br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" id="saveBtn" id="" class="btn btn-lg btn-primary">Next <i class=" ri-arrow-right-line align-middle ms-2"></i> </button>
                <a href="{{route('home')}}" id="homeBtn"  class="btn btn-lg btn-outline-secondary">Back to Home <i class=" ri-home-7-line align-middle ms-2"></i> </a><br><br>
                <div id="countdown">
                    <label for="">Sisa Waktu  <span class="minutes">00</span> : <span class="seconds">00</span></label>
                </div>
            </div>
       </form>
    </div>

</div>
<script>
    $(document).ready(function(){
        var countDownDate = new Date("{{$timeout}}").getTime();
        var x = setInterval(function() {
            var now = new Date().getTime();
        
            var distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            $('#countdown').html('<label for="">Sisa Waktu : '+minutes+':'+seconds+'</label>');
            if (distance < 0) {
                clearInterval(x);
                $('#countdown').html('<label for="">Waktu Habis</label>');
                loadQuiz();

            }
        }, 1000);

		$('#example').countdown({
			date: "{{$timeout}}",
			offset: +2, 
			day: 'Day',
			days: 'Days',
			hideOnComplete: true
		}, function (container) {
            loadQuiz();
            $('.minutes').html('00');
            $('.seconds').html('00')
		});
        loadQuiz();
        $('#btnHome').hide();
        $('#data-form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                method:'POST',
                url:"{{route('quiz.store')}}",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(res){
                    $('#btnHome').hide();
                    $('#saveBtn').attr('disabled',true);
                    $('#saveBtn').html('loading ...');
                    $('#error-answer').html("");
                    $('#input[name="answer"]').removeClass( "is-invalid" );
                },
                success:function(res){
                    $('#upload-excel-progress').hide();
                    $('#saveBtn').show();
                    $('#closeModal').show();
                    $('#saveBtn').attr('disabled',false);
                    $('#saveBtn').html('Next <i class=" ri-arrow-right-line align-middle ms-2"></i> ');

                    if (res.status == 'success') {
                        $('#data-form').trigger('reset');
                        loadQuiz();
                    } else {
                        $('#error-answer').html("pilih salah satu jawaban");
                        $('#input[name="answer"]').addClass( "is-invalid" );
                        
                    }
                },
                error:function(res){
                    $('#saveBtn').attr('disabled',false);
                    $('#saveBtn').html('Next <i class=" ri-arrow-right-line align-middle ms-2"></i> ');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan sistem',
                    });

                }
            });

        })
    })
    function loadQuiz() {
        var quiz_code = $('#quiz_code').val();
        $.ajax({
            method:'GET',
            url:"{{route('quiz.load')}}",
            data:{
                'quiz_code':'{{$quiz_code}}'
            },
            dataType:'JSON',
            beforeSend:function(res){
                $('#loading-quiz').show();
                $('#saveBtn').attr('disabled',true);
                $('#saveBtn').html('loading..');
                $('#btnHome').hide();
                $('#question_list').html('');
            },
            success:function(res){
                $('#loading-quiz').hide();
                $('#saveBtn').attr('disabled',false);
                $('#question_list').html(res.question_list);
                if (res.status == 'finish') {
                    $('#saveBtn').html('Next <i class=" ri-arrow-right-line align-middle ms-2"></i> ');
                    $('#saveBtn').hide();
                    $('#btnHome').show();
                    $('#example').hide();
                }else{
                    $('#saveBtn').html('Next <i class=" ri-arrow-right-line align-middle ms-2"></i> ');
                    $('#saveBtn').show();
                    $('#btnHome').hide();
                }
            },
            error:function(res){
                $('#saveBtn').attr('disabled',false);
                $('#saveBtn').html('Next <i class=" ri-arrow-right-line align-middle ms-2"></i> ');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan sistem',
                });
            }
        })
    }
</script>
@endsection
