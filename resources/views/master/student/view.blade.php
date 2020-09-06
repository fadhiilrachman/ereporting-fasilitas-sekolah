@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Data Siswa</h1>
    </div>
    <div class="row row-cards">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p class="float-right">
                        <a href="javascript:void(0);" class="btn btn-info" id="create-new">Buat siswa baru</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="student-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6">Mengambil data&hellip;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="student-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="studentModal"></h4>
                </div>
                <form id="studentForm" name="studentForm" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Nama Siswa</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama siswa" value="" maxlength="255" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan alamat email" value="" maxlength="255" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" value="" required="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="btn-save" value="create">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
require(['jquery', 'validate'], function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    if ($("#studentForm").length > 0) {
        $("#studentForm").validate( {
            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Mengirim...');
                $.ajax({
                    data: $('#studentForm').serialize(),
                    url: "{{ url('json/master/student/store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#studentForm').trigger("reset");
                        $('#student-modal').modal('hide');
                        $('#btn-save').html('Simpan Perubahan');
                        $('#student-table').dataTable().fnDraw(false);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Simpan Perubahan');
                    }
                });
            }
        });
    }
});
require(['datatables', 'moment', 'moment_id'], function() {
    moment.lang('id');
    $('#student-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('json/master/student') }}",
        columns: [
            { title: 'No', data: 'user_id', visible: true, orderable: false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'user_id', name: 'Aksi', visible: true, orderable: false, searchable: false },
        ],
        createdRow: function(row, data, index) {
            $('td', row).eq(0).html(index + 1);
            if (data['user_id']) {
                var id = data['user_id'],
                    html = '';
                html += '<button type="button" onclick="javascript:void(0);" data-id="'+id+'" class="edit-student btn btn-warning btn-icon btn-rounded"><i class="fe fe-edit-2"></i></button>';
                html += ' <button type="button" onclick="javascript:void(0);" data-id="'+id+'" class="delete-student btn btn-icon btn-primary btn-danger"><i class="fe fe-trash"></i></button>';
                $('td', row).eq(-1).html(html);
            }
        }
    });

    $('#create-new').click(function () {
        $('#btn-save').val("create-student");
        $('#user_id').val('');
        $("#password").attr("required", "required");
        $('#studentForm').trigger("reset");
        $('#studentModal').html("Tambah siswa baru");
        $('#student-modal').modal('show');
    });

    $('body').on('click', '.edit-student', function () {
        var id = $(this).data('id');
        $.get("{{ url('json/master/student/edit/') }}/" + id, function (data) {
            $('#name-error').hide();
            $('#studentModal').html("Ubah siswa");
            $('#btn-save').val("edit-student");
            $('#student-modal').modal('show');
            $('#user_id').val(data.user_id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $("#password").removeAttr("required");
        });
    });

$('body').on('click', '.delete-student', function () {
    var id = $(this).data("id");
    is_ok = confirm("Anda yakin ingin menghapus?");
    if(is_ok) {
        $.ajax({
            type: "POST",
            url: "{{ url('json/master/student/delete/') }}/" + id,
            success: function (data) {
                $('#student-table').dataTable().fnDraw(false);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    } else {
        $('#student-table').dataTable().fnDraw(false);
    }
});
});
</script>
@endpush