@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ config('app.name') }}</h1>
    </div>
    <div class="row row-cards">
        @if ($role->role_name == 'Tata Usaha')
            <div class="col-sm-4">
                <div class="card">
                  <div class="card-status bg-blue"></div>
                    <div class="card-body text-center">
                        <div class="h5">Total laporan masuk</div>
                        <div class="display-4 font-weight-bold mb-4" id="total_laporan_masuk">{{ $total_laporan_masuk }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                  <div class="card-status bg-success"></div>
                    <div class="card-body text-center">
                        <div class="h5">Total laporan telah diproses</div>
                        <div class="display-4 font-weight-bold mb-4" id="total_laporan_diproses">{{ $total_laporan_diproses }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                  <div class="card-status bg-warning"></div>
                    <div class="card-body text-center">
                        <div class="h5">Total laporan belum diproses</div>
                        <div class="display-4 font-weight-bold mb-4" id="total_laporan_belum_diproses">{{ $total_laporan_belum_diproses }}</div>
                    </div>
                </div>
            </div>
        @endif
        @if ($role->role_name == 'Siswa')
            <div class="col-sm-3">
                <div class="card">
                  <div class="card-status bg-blue"></div>
                    <div class="card-body text-center">
                        <div class="h5">Total laporan dibuat</div>
                        <div class="display-4 font-weight-bold mb-4" id="total_laporan_dibuat">{{ $total_laporan_dibuat }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                  <div class="card-status bg-warning"></div>
                    <div class="card-body text-center">
                        <div class="h5">Total laporan sedang ditinjau</div>
                        <div class="display-4 font-weight-bold mb-4" id="total_laporan_ditinjau">{{ $total_laporan_ditinjau }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                  <div class="card-status bg-success"></div>
                    <div class="card-body text-center">
                        <div class="h5">Total laporan diterima</div>
                        <div class="display-4 font-weight-bold mb-4" id="total_laporan_diterima">{{ $total_laporan_diterima }}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                  <div class="card-status bg-red"></div>
                    <div class="card-body text-center">
                        <div class="h5">Total laporan ditolak</div>
                        <div class="display-4 font-weight-bold mb-4" id="total_laporan_ditolak">{{ $total_laporan_ditolak }}</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
require(['jquery'], function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function cek_ajax() {
        $.ajax({
            url: "{{ url('live-ajax') }}",
            type: "GET",
            dataType: "json",
            success: function(res) {
    @if ($role->role_name == 'Tata Usaha')
                $("#total_laporan_masuk").html(res['total_laporan_masuk']);
                $("#total_laporan_diproses").html(res['total_laporan_diproses']);
                $("#total_laporan_belum_diproses").html(res['total_laporan_belum_diproses']);
    @endif
    @if ($role->role_name == 'Siswa')
                $("#total_laporan_dibuat").html(res['total_laporan_dibuat']);
                $("#total_laporan_ditinjau").html(res['total_laporan_ditinjau']);
                $("#total_laporan_diterima").html(res['total_laporan_diterima']);
                $("#total_laporan_ditolak").html(res['total_laporan_ditolak']);
    @endif
            }
        });
    }
    setInterval(() => {
        cek_ajax();
    }, 1000);
});
</script>
@endpush