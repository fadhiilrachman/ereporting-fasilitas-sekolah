@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Data Fasilitas</h1>
    </div>
    <div class="row row-cards">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <p class="float-right">
                        <a href="javascript:void(0);" class="btn btn-info" id="create-new">Buat fasilitas baru</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="facilities-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Ruang</th>
                                    <th>Nama Fasilitas</th>
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
    <div class="modal fade" id="facilities-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="facilitiesModal"></h4>
                </div>
                <form id="facilitiesForm" name="facilitiesForm" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" name="facilities_id" id="facilities_id">
                        <div class="form-group">
                            <label for="room_id" class="col-sm-4 control-label">Ruang</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="room_id" name="room_id" required=""></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="facilities_name" class="col-sm-4 control-label">Nama Fasilitas</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="facilities_name" name="facilities_name" placeholder="Masukkan nama fasilitas" value="" maxlength="255" required="">
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
    
    if ($("#facilitiesForm").length > 0) {
        $("#facilitiesForm").validate( {
            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Mengirim...');
                $.ajax({
                    data: $('#facilitiesForm').serialize(),
                    url: "{{ url('json/master/facilities/store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#facilitiesForm').trigger("reset");
                        $('#facilities-modal').modal('hide');
                        $('#btn-save').html('Simpan Perubahan');
                        var oTable = $('#facilities-table').dataTable();
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
require(['jquery', 'selectize', 'datatables'], function($, selectize) {
    $('#facilities-table').DataTable({
        buttons: [
            'print'
        ],
        processing: true,
        serverSide: true,
        ajax: "{{ url('json/master/facilities') }}",
        columns: [
            { title: 'No.', data: null, orderable: false, render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'room_name', name: 'room_name' },
            { data: 'facilities_name', name: 'facilities_name' },
            { title: 'Aksi', data: null, visible: true, orderable: false, searchable: false }
        ],
        createdRow: function(row, data, index) {
            $('td', row).eq(0).html(index + 1);
            if (data['facilities_id']) {
                var id = data['facilities_id'],
                    html = '';
                html += '<button type="button" data-id="'+id+'" class="edit-facilities btn btn-warning btn-icon btn-rounded"><i class="fe fe-edit-2"></i></button>';
                html += ' <button type="button" data-id="'+id+'" class="delete-facilities btn btn-icon btn-primary btn-danger"><i class="fe fe-trash"></i></button>';
                $('td', row).eq(-1).html(html);
            }
        }
    });

    $('select[name="room_id"]').html($('<option></option>').text('-- Pilih --').attr({
        disabled: 'disabled',
        selected: 'selected',
        value: ''
    }));
    $('#room_id').selectize();

    $('#create-new').click(function () {
        $('#room_id')[0].selectize.clear();
        $('#room_id')[0].selectize.clearOptions();
        $('#room_id')[0].selectize.renderCache['option'] = {};
        $('#room_id')[0].selectize.renderCache['item'] = {};
        $.get("{{ url('json/master/facilities/rooms') }}", function (data) {
            $('select[name="room_id"]').html($('<option></option>').text('-- Pilih --').attr({
                disabled: 'disabled',
                selected: 'selected'
            }));
            var d=[];
            for (row in data) {
                d.push({
                    'value': data[row].room_id,
                    'text': data[row].room_name
                });
            }
            $('#room_id')[0].selectize.addOption(d);
        });
        $('#btn-save').val("create-facilities");
        $('#facilities_id').val('');
        $('#facilitiesForm').trigger("reset");
        $('#facilitiesModal').html("Tambah fasilitas baru");
        $('#facilities-modal').modal('show');
    });

    $('body').on('click', '.edit-facilities', function () {
        var facilities_id = $(this).data('id');
        $.get("{{ url('json/master/facilities/edit/') }}/" + facilities_id, function (data) {
            $('#name-error').hide();
            $('#facilitiesModal').html("Ubah fasilitas");
            $('#btn-save').val("edit-facilities");
            $('#facilities-modal').modal('show');
            $('#facilities_id').val(data.facilities_id);
            $('#facilities_name').val(data.facilities_name);
            $('#room_id')[0].selectize.clear();
            $('#room_id')[0].selectize.clearOptions();
            $('#room_id')[0].selectize.renderCache['option'] = {};
            $('#room_id')[0].selectize.renderCache['item'] = {};
            $.get("{{ url('json/master/facilities/rooms') }}", function (datax) {
                var d=[];
                for (row in datax) {
                    if(data.room_id==datax[row].room_id) {
                        d.push({
                            'value': datax[row].room_id,
                            'text': datax[row].room_name,
                            'selected': true
                        });
                        sel_id=datax[row].room_id;
                    } else {
                        d.push({
                            'value': datax[row].room_id,
                            'text': datax[row].room_name,
                            'selected': false
                        });
                    }
                }
                $('#room_id')[0].selectize.addOption(d);
                $('#room_id')[0].selectize.setValue(sel_id);
            });
        });
    });

    $('body').on('click', '.delete-facilities', function () {
        var facilities_id = $(this).data("id");
        is_ok = confirm("Anda yakin ingin menghapus?");
        if(is_ok) {
            $.ajax({
                type: "POST",
                url: "{{ url('json/master/facilities/delete/') }}/" + facilities_id,
                success: function (data) {
                    $('#facilities-table').dataTable().fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        } else {
            $('#facilities-table').dataTable().fnDraw(false);
        }
    });
});
</script>
@endpush