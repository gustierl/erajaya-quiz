@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">List Quiz</h4>
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
                                    <th>ID Soal </th>
                                    <th>Nama</th>
                                    <th>Total Score</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
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
<script type="text/javascript">
    $(function () {
        $('.message-success').hide('true');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('quiz.list') }}",
            columns: [
                {data: 'quiz_code', name: 'quiz_code'},
                {data: 'name', name: 'name'},
                {data: 'total_score', name: 'total_score'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        $('body').on('click', '.view-data', function () {
            var id = $(this).data('id');
            var url = '{{ route("quiz.detail", ":id") }}';
            url = url.replace(':id', id);
            window.location.href=url;
        })
       
    });
</script>
@endsection
