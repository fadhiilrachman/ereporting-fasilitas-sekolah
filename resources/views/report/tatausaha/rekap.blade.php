@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Rekap Laporan</h1>
    </div>
    <div class="row row-cards">
        <div class="col">
            <form class="card" method="GET">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Laporan</label>
                                <div class="row gutters-xs">
                                    <div class="col-sm-12 col-md-12 col-lg-5">
                                        <input type="text" class="form-control @error('tanggal_laporan_start') is-invalid @enderror" name="tanggal_laporan_start" placeholder="Masukkan awal tanggal laporan">
                                        @error('tanggal_laporan_start')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_laporan_start') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <span class="col-auto" style="margin-top: 6px;">
                                        sampai
                                    </span>
                                    <div class="col-sm-12 col-md-12 col-lg-5">
                                        <input type="text" class="form-control @error('tanggal_laporan_end') is-invalid @enderror" name="tanggal_laporan_end" placeholder="Masukkan akhir tanggal laporan">
                                        @error('tanggal_laporan_end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_laporan_end') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Status Laporan</label>
                                <div class="row gutters-xs">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <select name="status" id="status" class="form-control custom-select">
                                            <option value="semua">Semua</option>
                                            <option value="accepted">Diterima</option>
                                            <option value="rejected">Ditolak</option>
                                            <option value="under_review">Ditinjau</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="form-group">
                                <label class="form-label">Urutkan Laporan</label>
                                <div class="row gutters-xs">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <select name="sort_by" id="sort_by" class="form-control custom-select">
                                            <option value="desc">Terbaru</option>
                                            <option value="asc">Terlama</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="rekap-table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Pelapor</th>
                                            <th>Ruang</th>
                                            <th>Nama Fasilitas</th>
                                            <th>Kerusakan</th>
                                            <th>Dilaporkan Pada</th>
                                            <th>Status Laporan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="7">Mengambil data&hellip;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
require(['jquery', 'selectize', 'jquery-ui', 'jquery-ui-i18n', 'validate'], function($, selectize) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var dateNow = '<?=date('Y-m-d');?>';
    $('input[name=tanggal_laporan_start]').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: dateNow,
        showButtonPanel: true,
        inline: true
    });
    $('input[name=tanggal_laporan_end]').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: dateNow,
        showButtonPanel: true,
        inline: true
    });
    $('input[name=tanggal_laporan_start]').prop('max', dateNow);
    $('input[name=tanggal_laporan_start]').prop('value', dateNow);
    $('input[name=tanggal_laporan_end]').prop('min', dateNow);
    $('input[name=tanggal_laporan_end]').prop('value', dateNow);
    $('#status, #sort_by').selectize({});
    $.datepicker.setDefaults($.datepicker.regional['id']);
});
require(['jquery', 'datatables', 'moment', 'moment_id'], function() {
    var dataTable = $('#rekap-table').DataTable({
        buttons: [
            'print'
        ],
        processing: true,
        serverSide: false,
        language: {
            "emptyTable": "Tidak ada laporan"
        },
        ajax: "{{ url('json/report/rekap') }}",
        columns: [
            { title: 'No', data: null },
            { data: 'name', name: 'name' },
            { data: 'room_name', name: 'room_name' },
            { data: 'facilities_name', name: 'facilities_name' },
            { title: 'Kerusakan', data: null },
            { data: 'created_at', name: 'created_at',
                render: function ( data, type, row ) {
                    return (moment(data).format('LLL'));
                }
            },
            { data: 'status', name: 'status', visible: true, orderable: false, searchable: false,
                render: function ( data, type, row ) {
                    switch (data) {
                        case 'under_review':
                            return '<span class="tag tag-orange">Sedang ditinjau</span>';
                            break;
                        case 'accepted':
                            return '<span class="tag tag-green">Diterima</span>';
                            break;
                        case 'rejected':
                            return '<span class="tag tag-red">Ditolak</span>';
                            break;
                    
                        default:
                            return '&nbsp;';
                            break;
                    }
                }
            },
        ],
        createdRow: function(row, data, index) {
            if (data['report_id']) {
                $('td', row).eq(0).html(index + 1);
                var criteria_1 = data['criteria_1'],
                    criteria_2 = data['criteria_2'],
                    criteria_3 = data['criteria_3'],
                    criteria_4 = data['criteria_4'],
                    criteria_5 = data['criteria_5'],
                    html = '';
                html='<ol type="1">';
                if(criteria_1!==null) html+= '<li>' + criteria_1 + '</li>';
                if(criteria_2!==null) html+= '<li>' + criteria_2 + '</li>';
                if(criteria_3!==null) html+= '<li>' + criteria_3 + '</li>';
                if(criteria_4!==null) html+= '<li>' + criteria_4 + '</li>';
                if(criteria_5!==null) html+= '<li>' + criteria_5 + '</li>';
                html+='</ol>';
                $('td', row).eq(4).html(html);
            }
        }
    });
    $("input[name=tanggal_laporan_start], input[name=tanggal_laporan_end], select[name=status], select[name=sort_by]").change(function() {
        $.ajax({
            url: '{{ url('json/report/rekap') }}',
            type: 'GET',
            data: $('form.card').serialize(),
            success: function(data) {
                dataTable.clear().rows.add(data.data).draw();
            }
        });
    });
});
</script>
@endpush