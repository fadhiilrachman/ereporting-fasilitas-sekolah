@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Data Jenis Kerusakan</h1>
    </div>
    <div class="row row-cards">
        <div class="col">
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <p class="float-right">
                        <a href="javascript:void(0);" class="btn btn-info" id="create-new">Buat baru</a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="criterias-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Ruang</th>
                                    <th>Nama Fasilitas</th>
                                    <th>Kerusakan</th>
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
    <div class="modal fade" id="criterias-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="criteriasModal"></h4>
                </div>
                <form id="criteriasForm" name="criteriasForm" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" name="criteria_id" id="criteria_id">
                        <div class="form-group">
                            <label for="room_id" class="col-sm-4 control-label">Ruang</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="room_id" name="room_id" required=""></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="facilities_id" class="col-sm-4 control-label">Fasilitas</label>
                            <div class="col-sm-12">
                                <select class="form-control" id="facilities_id" name="facilities_id" required=""></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="criteria_1" class="col-sm-6 control-label">Kerusakan Sangat Rendah</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="criteria_1" name="criteria_1" placeholder="Masukkan kerusakan sangat rendah" value="" maxlength="255" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="criteria_2" class="col-sm-6 control-label">Kerusakan Rendah</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="criteria_2" name="criteria_2" placeholder="Masukkan kerusakan rendah" value="" maxlength="255" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="criteria_3" class="col-sm-6 control-label">Kerusakan Sedang</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="criteria_3" name="criteria_3" placeholder="Masukkan kerusakan sedang" value="" maxlength="255" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="criteria_4" class="col-sm-6 control-label">Kerusakan Tinggi</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="criteria_4" name="criteria_4" placeholder="Masukkan kerusakan tinggi" value="" maxlength="255" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="criteria_5" class="col-sm-6 control-label">Kerusakan Sangat Tinggi</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="criteria_5" name="criteria_5" placeholder="Masukkan kerusakan sangat tinggi" value="" maxlength="255" required="">
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
    
    if ($("#criteriasForm").length > 0) {
        $("#criteriasForm").validate( {
            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Mengirim...');
                $.ajax({
                    data: $('#criteriasForm').serialize(),
                    url: "{{ url('json/master/criterias/store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#criteriasForm').trigger("reset");
                        $('#criterias-modal').modal('hide');
                        $('#btn-save').html('Simpan Perubahan');
                        $('#criterias-table').dataTable().fnDraw(false);
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
    $('#criterias-table').DataTable({
        buttons: [
            'print'
        ],
        processing: true,
        serverSide: true,
        ajax: "{{ url('json/master/criterias') }}",
        columns: [
            { title: 'No.', data: null, orderable: false, render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'room_name', name: 'room_name' },
            { data: 'facilities_name', name: 'facilities_name' },
            { title: 'Kerusakan', data: null },
            { title: 'Aksi', data: null, visible: true, orderable: false, searchable: false }
        ],
        createdRow: function(row, data, index) {
            if (data['criteria_id']) {
                var id = data['criteria_id'],
                    criteria_1 = data['criteria_1'],
                    criteria_2 = data['criteria_2'],
                    criteria_3 = data['criteria_3'],
                    criteria_4 = data['criteria_4'],
                    criteria_5 = data['criteria_5'],
                    html = '';
                html += '<button type="button" onclick="javascript:void(0);" data-id="'+id+'" class="edit-criterias btn btn-warning btn-icon btn-rounded"><i class="fe fe-edit-2"></i></button>';
                html += ' <button type="button" onclick="javascript:void(0);" data-id="'+id+'" class="delete-criterias btn btn-icon btn-primary btn-danger"><i class="fe fe-trash"></i></button>';
                $('td', row).eq(-1).html(html);
                html='<ol type="1">';
                html+= '<li>' + criteria_1 + '</li>';
                html+= '<li>' + criteria_2 + '</li>';
                html+= '<li>' + criteria_3 + '</li>';
                html+= '<li>' + criteria_4 + '</li>';
                html+= '<li>' + criteria_5 + '</li>';
                html+='</ol>';
                $('td', row).eq(-2).html(html);
            }
        }
    });

    $('select[name="room_id"]').html($('<option></option>').text('-- Pilih --').attr({
        disabled: 'disabled',
        selected: 'selected',
        value: ''
    }));
    $('select[name="facilities_id"]').html($('<option></option>').text('-- Pilih --').attr({
        disabled: 'disabled',
        selected: 'selected',
        value: ''
    }));
    $('#room_id, #facilities_id').selectize();

    $('select[name="room_id"]').change(function(event) {
        $('#facilities_id')[0].selectize.clear();
        $('#facilities_id')[0].selectize.clearOptions();
        $('#facilities_id')[0].selectize.renderCache['option'] = {};
        $('#facilities_id')[0].selectize.renderCache['item'] = {};
        $('select[name="facilities_id"]').html($('<option></option>').text('-- Pilih --').attr({
            disabled: 'disabled',
            selected: 'selected',
            value: ''
        }));
        $.get("{{ url('json/master/criterias/facilities/') }}/" + $('select[name="room_id"]').val(), function(data) {
            var d=[];
            for (row in data) {
                d.push({
                    'value': data[row].facilities_id,
                    'text': data[row].facilities_name
                });
            }
            $('#facilities_id')[0].selectize.addOption(d);
        });
    });

    $('#create-new').click(function () {
        $('#btn-save').val("create-criterias");
        $('#criteria_id').val('');
        $('#criteria_1').val('');
        $('#criteria_2').val('');
        $('#criteria_3').val('');
        $('#criteria_4').val('');
        $('#criteria_5').val('');
        $('#criteriasForm').trigger("reset");
        $('#criteriasModal').html("Tambah baru");
        $('#criterias-modal').modal('show');
        $('#room_id')[0].selectize.clear();
        $('#room_id')[0].selectize.clearOptions();
        $('#room_id')[0].selectize.renderCache['option'] = {};
        $('#room_id')[0].selectize.renderCache['item'] = {};
        $('#facilities_id')[0].selectize.clear();
        $('#facilities_id')[0].selectize.clearOptions();
        $('#facilities_id')[0].selectize.renderCache['option'] = {};
        $('#facilities_id')[0].selectize.renderCache['item'] = {};
        $('select[name="room_id"]').html($('<option></option>').text('-- Pilih --').attr({
            disabled: 'disabled',
            selected: 'selected',
            value: ''
        }));
        $('select[name="facilities_id"]').html($('<option></option>').text('-- Pilih --').attr({
            disabled: 'disabled',
            selected: 'selected',
            value: ''
        }));
        $.get("{{ url('json/master/criterias/rooms') }}", function (data) {
            var d=[];
            for (row in data) {
                d.push({
                    'value': data[row].room_id,
                    'text': data[row].room_name
                });
            }
            $('#room_id')[0].selectize.addOption(d);
        });
    });

    $('body').on('click', '.edit-criterias', function () {
        var criteria_id = $(this).data('id');
        $.get("{{ url('json/master/criterias/edit/') }}/" + criteria_id, function (data) {
            $('#name-error').hide();
            $('#criteriasModal').html("Ubah jenis kerusakan");
            $('#btn-save').val("edit-criterias");
            $('#criterias-modal').modal('show');
            $('#criteria_id').val(data.criteria_id);
            $('#criteria_1').val(data.criteria_1);
            $('#criteria_2').val(data.criteria_2);
            $('#criteria_3').val(data.criteria_3);
            $('#criteria_4').val(data.criteria_4);
            $('#criteria_5').val(data.criteria_5);
            $('#room_id')[0].selectize.clear();
            $('#room_id')[0].selectize.clearOptions();
            $('#room_id')[0].selectize.renderCache['option'] = {};
            $('#room_id')[0].selectize.renderCache['item'] = {};
            $('#facilities_id')[0].selectize.clear();
            $('#facilities_id')[0].selectize.clearOptions();
            $('#facilities_id')[0].selectize.renderCache['option'] = {};
            $('#facilities_id')[0].selectize.renderCache['item'] = {};
            $.get("{{ url('json/master/criterias/rooms') }}", function(datax) {
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
            $.get("{{ url('json/master/criterias/facilities/') }}/" + data.room_id, function(datax) {
                var d=[];
                for (row in datax) {
                    if(data.facilities_id==datax[row].facilities_id) {
                        d.push({
                            'value': datax[row].facilities_id,
                            'text': datax[row].facilities_name,
                            'selected': true
                        });
                        sel_id=datax[row].facilities_id;
                    } else {
                        d.push({
                            'value': datax[row].facilities_id,
                            'text': datax[row].facilities_name,
                            'selected': false
                        });
                    }
                }
                $('#facilities_id')[0].selectize.addOption(d);
                $('#facilities_id')[0].selectize.setValue(sel_id);
            });
        });
    });

    $('body').on('click', '.delete-criterias', function () {

        var criteria_id = $(this).data("id");
        is_ok = confirm("Anda yakin ingin menghapus?");

        if(is_ok) {
            $.ajax({
                type: "POST",
                url: "{{ url('json/master/criterias/delete/') }}/" + criteria_id,
                success: function (data) {
                    $('#criterias-table').dataTable().fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        } else {
            $('#criterias-table').dataTable().fnDraw(false);
        }
    });
});
</script>
@endpush