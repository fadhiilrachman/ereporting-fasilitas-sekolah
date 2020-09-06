@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Data Ruang</h1>
    </div>
    <div class="row row-cards">
        <div class="col">
            <div class="card">
                <div class="card-body"> 
                    <p class="float-right">
                        <a href="javascript:void(0);" class="btn btn-info" id="create-new">Buat ruang baru</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="rooms-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Ruang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5">Mengambil data&hellip;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="room-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="roomModal"></h4>
                </div>
                <form id="roomForm" name="roomForm" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" name="room_id" id="room_id">
                        <div class="form-group">
                            <label for="room_name" class="col-sm-4 control-label">Nama Ruang</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="room_name" name="room_name" placeholder="Masukkan nama ruang" value="" maxlength="255" required="">
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
    
    if ($("#roomForm").length > 0) {
        $("#roomForm").validate( {
            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Mengirim...');
                $.ajax({
                    data: $('#roomForm').serialize(),
                    url: "{{ url('json/master/rooms/store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#roomForm').trigger("reset");
                        $('#room-modal').modal('hide');
                        $('#btn-save').html('Simpan Perubahan');
                        var oTable = $('#rooms-table').dataTable();
                        oTable.fnDraw(false);
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
require(['datatables'], function() {
    $('#rooms-table').DataTable({
        buttons: [
            'print'
        ],
        processing: true,
        serverSide: true,
        ajax: "{{ url('json/master/rooms') }}",
        columns: [
            { title: 'No', data: 'room_id' },
            { data: 'room_name', name: 'room_name' },
            { title: 'Aksi', data: null, visible: true, orderable: false, searchable: false },
        ],
        createdRow: function(row, data, index) {
            $('td', row).eq(0).html(index + 1);
            if (data['room_id']) {
                var id = data['room_id'],
                    html = '';
                html += '<button type="button" onclick="javascript:void(0);" data-id="'+id+'" class="edit-room btn btn-warning btn-icon btn-rounded"><i class="fe fe-edit-2"></i></button>';
                html += ' <button type="button" onclick="javascript:void(0);" data-id="'+id+'" class="delete-room btn btn-icon btn-primary btn-danger"><i class="fe fe-trash"></i></button>';
                $('td', row).eq(-1).html(html);
            }
        }
    });

    $('#create-new').click(function () {
        $('#btn-save').val("create-room");
        $('#room_id').val('');
        $('#roomForm').trigger("reset");
        $('#roomModal').html("Tambah ruang baru");
        $('#room-modal').modal('show');
    });
 
    $('body').on('click', '.edit-room', function () {
        var room_id = $(this).data('id');
        $.get("{{ url('json/master/rooms/edit/') }}/" + room_id, function (data) {
            $('#name-error').hide();
            $('#roomModal').html("Ubah ruang");
            $('#btn-save').val("edit-room");
            $('#room-modal').modal('show');
            $('#room_id').val(data.room_id);
            $('#room_name').val(data.room_name);
        });
    });

    $('body').on('click', '.delete-room', function () {
        var room_id = $(this).data("id");
        is_ok = confirm("Anda yakin ingin menghapus?");
        if(is_ok) {
            $.ajax({
                type: "POST",
                url: "{{ url('json/master/rooms/delete/') }}/" + room_id,
                success: function (data) {
                    $('#rooms-table').dataTable().fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        } else {
            $('#rooms-table').dataTable().fnDraw(false);
        }
    });
});
</script>
@endpush