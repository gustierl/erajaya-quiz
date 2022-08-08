@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h5>Soal</h5>
            <div class="page-title-right">
                <button type="button" id="btnCreateQuestion" class="btn btn-primary"><i class=" fa fa-plus"></i> Buat Soal Baru</button>
                <button type="button" id="uploadExcel" class="btn btn-dark"><i class=" fa fa-upload"></i> Upload Soal Baru</button>
            </div>
        </div>
    </div>
</div>
<div class="row" >
    <div class="col-xl-12" id="dataQuestion">
        <div class="card">
            <div class="card-body">
                <div>
                    <center>
                        <h1 class="mdi mdi-spin mdi-loading"></h1> Loading
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- sample modal content -->
 <div id="inlineForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Buat Soal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="data-form" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <input class="form-check-input" type="hidden" name="question_code" id="question_code">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="control-label">Pertanyaan</label>
                        <textarea class="form-control" name="question_name" id="question_name" cols="30" rows="2"></textarea>
                        <div class="invalid-feedback" id="error-name"></div><br>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Pilihan & Jawaban</label>
                        <div style="font-size: 80%;color: #f32f53;" id="error-answer"></div><br>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="answer" id="optionRadios1">
                            <input type="text" class="form-control" name="option_one" id="valueOptionRadios1">
                            <div class="invalid-feedback" id="error-option_one"></div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="answer" id="optionRadios2">
                            <input type="text" class="form-control" name="option_two" id="valueOptionRadios2">
                            <div class="invalid-feedback" id="error-option_two"></div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="answer" id="optionRadios3">
                            <input type="text" class="form-control" name="option_three" id="valueOptionRadios3">
                            <div class="invalid-feedback" id="error-option_three"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Score</label>
                        <input class="form-control" type="text" name="score" id="score">
                        <div class="invalid-feedback" id="error-score"></div><br>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Status</label>
                        <select name="status" class="form-select" id="status_question">
                            <option value="AKTIF">AKTIF</option>
                            <option value="TIDAK AKTIF">TIDAK AKTIF</option>
                        </select>
                        <div class="invalid-feedback" id="error-status"></div><br>
                    </div>
                    <button style="float:right;" type="submit" id="saveBtnUploadExcel" class="btn btn-primary ml-1">Simpan</button>
                    <br><br>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Data Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="upload-form-excel" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="fallback">
                        <input name="file" class="form-control" id="file" type="file">
                        <small>File harus berformat .xlsx </small>
                        <div class="invalid-feedback" id="error-file"></div><br>
                    </div><br>
                    <div id="upload-excel-progress">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                        <center><small>Processing ...</small></center>
                    </div>
                    <button style="float:right;" type="submit" id="saveBtnUploadExcel" class="btn btn-primary ml-1">Upload</button>
                    <br><br>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function(){
        dataQuestion();
        $('#btnCreateQuestion').on('click',function(){
            $('#upload-pdf-progress').hide();
            $('#data-form').trigger("reset");
            $('#inlineForm').modal('show');
        });
        $('#uploadExcel').click(function(){
            $('#upload-excel-progress').hide();
            $('#myModal').modal('show');
            $('#upload-form-excel').trigger('reset');

        });
        $('#valueOptionRadios1').on('keyup',function(){
            $('#optionRadios1').val($(this).val());
        });
        $('#valueOptionRadios2').on('keyup',function(){
            $('#optionRadios2').val($(this).val());
        });
        $('#valueOptionRadios3').on('keyup',function(){
            $('#optionRadios3').val($(this).val());
        });
        $('#score').on('keypress',function(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))

		    return false;
		  return true;
        });
        $('body').on('click', '.btnEditQuestion', function () {
            var question_code = $(this).data('id');
            var url = '{{ route("question.edit", ":id") }}';
            url = url.replace(':id', question_code);
            $('#upload-pdf-progress').hide();
            $('#data-form').trigger("reset");
            $('#inlineForm').modal('show');

            $.get(url, function (data) {
                $('#myModalLabel33').html("Edit Soal");
                $('#inlineForm').modal('show');
                $('#question_name').val(data.question_name);
                $('#question_code').val(data.question_code);
                $('#valueOptionRadios1').val(data.option_one);
                $('#valueOptionRadios2').val(data.option_two);
                $('#valueOptionRadios3').val(data.option_three);
                $('#optionRadios1').val(data.option_one);
                $('#optionRadios2').val(data.option_two);
                $('#optionRadios3').val(data.option_three);
                $('#score').val(data.score);
                $('#status_question').val(data.status);
                if (data.option_one == data.answer) {
                    $('#optionRadios1').prop('checked',true);
                }
                if (data.option_two == data.answer) {
                    $('#optionRadios2').prop('checked',true);
                }
                if (data.option_three == data.answer) {
                    $('#optionRadios3').prop('checked',true);
                }

            })

        });
        $('#data-form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                method:'POST',
                url:"{{route('question.store')}}",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(res){
                    $('#upload-excel-progress').show();


                    $('#error-question_name').html( "" );
                    $('#question_name').removeClass( "is-invalid" );

                    $('#error-option_one').html( "" );
                    $('#valueOptionRadios1').removeClass( "is-invalid" );

                    $('#error-option_two').html( "" );
                    $('#valueOptionRadios2').removeClass( "is-invalid" );

                    $('#error-option_three').html( "" );
                    $('#valueOptionRadios3').removeClass( "is-invalid" );

                    $('#error-answer').html( "" );
                    $('#input[name="answer"]').removeClass( "is-invalid" );

                    $('#error-score').html( "" );
                    $('#score').removeClass( "is-invalid" );

                    $('#error-status').html( "" );
                    $('#status_question').removeClass( "is-invalid" );

                    $('#saveBtn').hide();
                    $('#closeModal').hide();
                    $('#saveBtn').attr('disabled',false);
                    $('#saveBtn').html('Loading');

                },
                success:function(res){
                    $('#upload-excel-progress').hide();
                    $('#saveBtn').show();
                    $('#closeModal').show();
                    $('#saveBtn').attr('disabled',false);
                    $('#saveBtn').html('Simpan');

                    if (res.status == 'success') {
                        $('#inlineForm').modal('hide');
                        dataQuestion();

                        Swal.fire({
                            icon:'success',
                            title: 'Berhasil',
                            html: 'Data tersimpan didatabase',
                            timer: 2000,
                        })
                    } else {
                        if (res.message.question_name) {
                            $('#error-question_name').html(res.message.question_name[0]);
                            $('#question_name').addClass( "is-invalid" );
                        }
                        if (res.message.option_one) {
                            $('#error-option_one').html(res.message.option_one[0]);
                            $('#valueOptionRadios1').addClass( "is-invalid" );
                        }
                        if (res.message.option_two) {
                            $('#error-option_two').html(res.message.option_two[0]);
                            $('#valueOptionRadios2').addClass( "is-invalid" );
                        }
                        if (res.message.option_three) {
                            $('#error-option_three').html(res.message.option_three[0]);
                            $('#valueOptionRadios3').addClass( "is-invalid" );
                        }
                        if (res.message.answer) {
                            $('#error-answer').html(res.message.answer[0]);
                            $('input[name="answer"]').addClass( "is-invalid" );
                        }
                        if (res.message.score) {
                            $('#error-score').html(res.message.score[0]);
                            $('#score').addClass( "is-invalid" );
                        }
                        if (res.message.status) {
                            $('#error-status').html(res.message.status[0]);
                            $('#status_question').addClass( "is-invalid" );
                        }
                    }

                },
                error:function(res){
                    $('#upload-excel-progress').hide();
                    $('#saveBtn').show();
                    $('#closeModal').show();
                    $('#saveBtn').attr('disabled',false);
                    $('#saveBtn').html('Simpan');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan sistem',
                    });

                }
            });

        })
        $('#upload-form-excel').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('question.upload') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend:function(data){
                        $( '#file' ).removeClass('is-invalid');
                        $( '#error-file' ).html('');
                        $('#saveBtnUploadExcel').attr('disabled',true);
                        $('#saveBtnUploadExcel').html('Loading');
                        $('#saveBtnUploadExcel').hide();
                        $('#upload-excel-progress').show();
                    },
                    success:function(data){
                        if (data.status == 200) {
                            $('#uploadFormExcel').modal('hide');
                            Swal.fire({
                                icon:'success',
                                title: 'Upload Berhasil',
                                html: 'File Berhasil Dupload',
                            })
                            $('#myModal').modal('hide');
                            dataQuestion();

                        } else if(data.status == 400) {
                            if(data.message.file){
                                $( '#file' ).addClass('is-invalid');
                                $( '#error-file' ).html(data.message.file[0]);
                            }

                        }
                        $('#saveBtnUploadExcel').show();
                        $('#saveBtnUploadExcel').attr('disabled',false);
                        $('#saveBtnUploadExcel').html('Upload');
                        $('#upload-excel-progress').hide();
                    },
                    error:function(data){
                        $('#saveBtnUploadExcel').show();
                        $('#saveBtnUploadExcel').attr('disabled',false);
                        $('#saveBtnUploadExcel').html('Upload');
                        $('#upload-excel-progress').hide();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan sistem',
                        });
                    }
                })
            })
    })

    function dataQuestion() {
        var html;

        $.ajax({
            method:'GET',
            url:"{{route('question.data')}}",
            dataType:'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(res){
                html =' <div class="card">'+
                    '<div class="card-body">'+
                    '<div>'+
                    '<center>'+
                    '<h1 class="mdi mdi-spin mdi-loading"></h1> Loading'+
                    '</center>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                $('#dataQuestion').html(html);
            },
            success:function(res){
                $('#dataQuestion').empty();
                if (res.status =='success') {
                    var resut;
                    result = '';
                    $.each(res.data, function( key, value ) {
                        result =' <div class="card">'+
                            '<div class="card-body ">'+
                                '<div class="row">'+
                                    '<div class="col-8">'+
                                        '<h5>'+value['question_name']+' ?</h5>'+
                                        '<label> Jawaban : </label><br>'+
                                        '<div class="form-check">'+
                                        '<input class="form-check-input" type="radio" disabled '+(value['option_one'] === value['answer'] ? 'checked' : '')+' ><label>'+value['option_one']+'</label>'+
                                        '</div>'+
                                        '<div class="form-check">'+
                                        '<input class="form-check-input" type="radio" disabled '+(value['option_two'] === value['answer'] ? 'checked' : '')+' ><label>'+value['option_two']+'</label>'+
                                        '</div>'+
                                        '<div class="form-check">'+
                                        '<input class="form-check-input" type="radio" disabled '+(value['option_three'] === value['answer'] ? 'checked' : '')+' ><label>'+value['option_three']+'</label>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div style="text-align:right;" class="col-4">'+
                                        '<button  style="margin-bottom:7px;" type="button" class="btn btn-outline-light btnEditQuestion" data-id="'+value['question_code']+'"><i class=" ri-pencil-fill "></i> Edit</button><br>'+
                                        '<small> ID : '+value['question_code']+'</small><br>'+
                                        '<small> Status : '+value['status']+'</small><br>'+
                                        '<small> Score : </small><br>'+
                                        '<h4>'+value['score']+'</h4>'
                                    '</div>'+
                                '</div>'
                            '</div>'+
                            '</div>';
                            $('#dataQuestion').append(result);

                    })
                } else {
                    html =' <div class="card">'+
                    '<div class="card-body">'+
                    '<div>'+
                    '<center>'+
                    '<h1 class="mdi mdi-spin mdi-loading"></h1> Loading'+
                    '</center>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                    $('#dataQuestion').html(html);
                }
            },
            error:function(res){
                html =' <div class="card">'+
                    '<div class="card-body">'+
                    '<div>'+
                    '<center>'+
                    '<h1 class="mdi mdi-spin mdi-loading"></h1> Loading'+
                    '</center>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                $('#dataQuestion').html(html);
            }
        });
    }
</script>
@endsection
