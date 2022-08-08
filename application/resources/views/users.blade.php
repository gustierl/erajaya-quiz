@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Pengguna</h4>
            @role('Admin')
            <div class="page-title-right">
                <button id="addUser" type="button" class="btn btn-success glow mr-1 mb-1"><i class="ri-add-circle-line"></i><strong> Tambah Data Pengguna</strong></button>
            </div>
            @endrole
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="table-responsive">
                        <table  id="datatable" class="table table-bordered dt-responsive nowrap data-table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Peran</th>
                                    <th>Tanggal</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--login form Modal -->
<div id="inlineForm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33"></h4>
                <button type="button" class="btn btn-light waves-effect waves-light" data-bs-toggle="modal" >
                    <i class=" ri-close-fill"></i></button>
            </div>
            <form id="data-form" name="data-form">
            {{ csrf_field() }}
            <input type="hidden" name="code" id="code" class="form-control" >
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Nama Pengguna: </label>
                            <div class="controls">
                                <input type="text" name="name" class="form-control" id="name" >
                                <div class="invalid-feedback" id="error-name"></div><br>

                            </div>
                        </div>
                        <div class="form-group" id="email-error">
                            <label>Email: </label>
                            <div class="controls">
                                <input type="email" name="email" class="form-control" id="email" >
                                <div class="invalid-feedback" id="error-email"></div><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Peran : </label>
                            <div class="controls">
                                <select class="form-select" name="role" id="role">
                                    <option selected disabled value="">Pilih Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                                <div class="invalid-feedback" id="error-role"></div><br>
                            </div>
                        </div>
                        <div class="form-group" id="password-error">
                            <label id="lbl-password">Password : </label>
                            <div class="controls">
                                <input type="password" name="password" class="form-control" id="password" maxlength="12" minlength="8" >
                                <div class="invalid-feedback" id="error-password"></div><br>
                            </div>
                        </div>
                        <div class="form-group" id="password_confirmation-error">
                            <label id="lbl-password_confirmation">Konfirmasi Password  : </label>
                            <div class="controls">
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" maxlength="12" minlength="8" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="saveBtn" class="btn btn-primary ml-1">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('.message-success').hide('true');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        $('#addUser').click(function () {

            $('#saveBtn').html("Simpan");

            $('#error-name').html('');
            $('#name').removeClass('is-invalid');

            $('#error-email').html('');
            $('#email').removeClass('is-invalid');

            $('#error-role').html('');
            $('#role').removeClass('is-invalid');

            $('#error-password').html('');
            $('#password').removeClass('is-invalid');

            $('#password-error').show(true);
            $('#password_confirmation-error').show(true);
            $('#lbl-password').show(true);
            $('#lbl-password_confirmation').show(true);

            $('#myModalLabel33').html('Buat Pengguna Baru');
            $('#data-form').trigger("reset");
            $('#inlineForm').modal('show');
        });

        $('body').on('click', '.edit-data', function () {
            var code = $(this).data('id');
            $('#status').val(2);

            $.get("{{ route('user.index') }}" +'/' + code +'/edit', function (data) {
                $('#myModalLabel33').html("Edit Pengguna");
                $('#inlineForm').modal('show');
                $('#role').val(data.role).trigger('change');
                $('#code').val(code)
                $('#email').val(data.email)
                $('#name').val(data.name);
                $('#password-error').hide(true);
                $('#password_confirmation-error').hide(true);
                $('#lbl-password').hide(true);
                $('#lbl-password_confirmation').hide(true);
                $('#email').attr('disabled',true);
                $('#saveBtn').html("Update Data");
            })
        });

        $('body').on('click', '.delete-data', function(){
            var code = $(this).data('id');
            var nama = $(this).data('name');
            Swal.fire({
            title: 'Anda yakin Ingin menghapus "'+nama+'" ?',
            text: "Data akan dihapus secara permanen",
            icon: 'warning',
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                type: "DELETE",
                url: "{{ route('user.store') }}"+'/'+code,
                success: function (data) {
                    table.draw();
                    Swal.fire({
                            icon:'success',
                            title: 'Terhapus',
                            html: 'Data user sudah terhapus',
                            timer: 2000,
                        });
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
            }
            })
        });
        $('#data-form').on('submit', function(event){
            event.preventDefault();
           
            $.ajax({
                url:"{{ route('user.store') }}",
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(data){
                    $('#saveBtn').attr('disabled',true);
                    $('#saveBtn').html('Proses ...');

                    $('#error-name').html('');
                    $('#name').removeClass('is-invalid');

                    $('#error-email').html('');
                    $('#email').removeClass('is-invalid');

                    $('#error-role').html('');
                    $('#role').removeClass('is-invalid');

                    $('#error-password').html('');
                    $('#password').removeClass('is-invalid');
                },
                success:function(data)
                {
                    $('#saveBtn').html('Simpan');
                    $('#saveBtn').attr('disabled',false);
                    if(data.status == 'success') {
                        $('#inlineForm').modal('hide');
                        Swal.fire({
                            icon:'success',
                            title: 'Update',
                            html: 'Data diperbaharui dari database',
                            timer: 2000,
                        });
                        table.draw();
                    }
                    if(data.status == 'failed') {
                        if(data.message.name){
                            $('#error-name').html(data.message.name[0]);
                            $('#name').addClass('is-invalid');
                        }
                        if(data.message.password){
                            $('#error-password').html(data.message.password[0]);
                            $('#password').addClass('is-invalid');
                        }
                        if(data.message.email){
                            $('#error-email').html(data.message.email[0]);
                            $('#email').addClass('is-invalid');
                        }
                        if(data.message.role){
                            $('#error-role').html(data.message.role[0]);
                            $('#role').addClass('is-invalid');
                        }
                    }
                },error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan sistem',
                    });
                    $('#saveBtn').attr('disabled',false);
                    $('#saveBtn').html('Simpan ');
                }
            })
        });
    });
</script>
@endsection
