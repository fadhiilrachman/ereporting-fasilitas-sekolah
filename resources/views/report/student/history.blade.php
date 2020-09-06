@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Riwayat Lapor</h1>
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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="history-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Ruang</th>
                                    <th>Nama Fasilitas</th>
                                    <th>Kerusakan</th>
                                    <th>Dilaporkan Pada</th>
                                    <th>Status Laporan</th>
                                    <th></th>
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
@endsection

@push('scripts')
<script>
require(['jquery', 'validate'], function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('body').on('click', '#cabut-laporan', function() {
        var report_id = $(this).data("id");
        is_ok = confirm("Anda yakin ingin mencabut laporan ini?");
        if(is_ok) {
            $.ajax({
                type: "POST",
                url: "{{ url('json/report/revoke/') }}/" + report_id,
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        } else {
            $('#history-table').dataTable().fnDraw(false);
        }
    });
});
require(['datatables', 'moment', 'moment_id'], function() {
    $('#history-table').DataTable({
        buttons: [
            'print'
        ],
        processing: true,
        serverSide: false,
        ajax: "{{ url('json/report/history') }}",
        columns: [
            { title: 'No', data: null },
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
                            return '-';
                            break;
                    }
                }
            },
            { title: '',  data: null, visible: true, orderable: false, searchable: false}
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
                $('td', row).eq(3).html(html);
                //
                switch (data['status']) {
                    case 'under_review':
                        html='<a href="javascript:;" data-id="'+data['report_id']+'" id="cabut-laporan" class="btn btn-pill btn-outline-danger btn-sm">Cabut Laporan</a>';
                        break;
                        
                    default:
                        html='-';
                        break;
                }
                $('td', row).eq(-1).html(html);
            }
        }
    });
});
</script>
@endpush