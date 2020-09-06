@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Proses Laporan</h1>
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
            <form class="card" method="POST" action="{{ url('report/process') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Tanggal Laporan</label>
                                <div class="row gutters-xs">
                                    <div class="col-sm-12 col-md-12 col-lg-3">
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
                                    <div class="col-sm-12 col-md-12 col-lg-3">
                                        <input type="text" class="form-control @error('tanggal_laporan_end') is-invalid @enderror" name="tanggal_laporan_end" placeholder="Masukkan akhir tanggal laporan">
                                        @error('tanggal_laporan_end')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('tanggal_laporan_end') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <span class="col-auto">
                                        <button class="btn btn-primary" type="submit">Proses</button>
                                    </span>
                                </div>
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
require(['jquery', 'jquery-ui', 'jquery-ui-i18n', 'validate'], function() {
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
    $.datepicker.setDefaults($.datepicker.regional['id']);
});
</script>
@endpush