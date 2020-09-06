@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Lapor Kerusakan</h1>
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
            <form class="card" method="POST" action="{{ url('report/create-new') }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="room_id" class="control-label">Ruang</label>
                                <select class="form-control @error('room_id') is-invalid @enderror" id="room_id" name="room_id" required></select>
                                @error('room_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('room_id') }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="facilities_id" class="control-label">Fasilitas</label>
                                <select class="form-control @error('facilities_id') is-invalid @enderror" id="facilities_id" name="facilities_id" required></select>
                                @error('facilities_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('facilities_id') }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group group-criteria" style="display: none;">
                                <label class="control-label">Jenis Kerusakan</label>
                                <div class="table-responsive">
                                    <table class="table table-vcenter text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="w-1">No.</th>
                                                <th>Tingkat Kerusakan</th>
                                                <th>Jenis Kerusakan</th>
                                                <th colspan="1">Waktu Kerusakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="text-muted">1</span></td>
                                                <td>Sangat Rendah</td>
                                                <td class="criteria-1-label"></td>
                                                <td>
                                                    <div class="selectgroup selectgroup-pills">
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria1" name="criteria[0]" value="10" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Hanya sekali</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria1" name="criteria[0]" value="40" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Jarang</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria1" name="criteria[0]" value="50" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Sering</span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" onclick="javascript:document.querySelector('input#criteria1:checked').checked=false;" class="btn btn-pill btn-outline-danger btn-sm">Hapus Pilihan</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="text-muted">2</span></td>
                                                <td>Rendah</td>
                                                <td class="criteria-2-label"></td>
                                                <td>
                                                    <div class="selectgroup selectgroup-pills">
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria2" name="criteria[1]" value="10" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Hanya sekali</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria2" name="criteria[1]" value="40" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Jarang</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria2" name="criteria[1]" value="50" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Sering</span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" onclick="javascript:document.querySelector('input#criteria2:checked').checked=false;" class="btn btn-pill btn-outline-danger btn-sm">Hapus Pilihan</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="text-muted">3</span></td>
                                                <td>Sedang</td>
                                                <td class="criteria-3-label"></td>
                                                <td>
                                                    <div class="selectgroup selectgroup-pills">
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria3" name="criteria[2]" value="10" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Hanya sekali</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria3" name="criteria[2]" value="40" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Jarang</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria3" name="criteria[2]" value="50" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Sering</span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" onclick="javascript:document.querySelector('input#criteria3:checked').checked=false;" class="btn btn-pill btn-outline-danger btn-sm">Hapus Pilihan</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="text-muted">4</span></td>
                                                <td>Tinggi</td>
                                                <td class="criteria-4-label"></td>
                                                <td>
                                                    <div class="selectgroup selectgroup-pills">
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria4" name="criteria[3]" value="10" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Hanya sekali</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria4" name="criteria[3]" value="40" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Jarang</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria4" name="criteria[3]" value="50" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Sering</span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" onclick="javascript:document.querySelector('input#criteria4:checked').checked=false;" class="btn btn-pill btn-outline-danger btn-sm">Hapus Pilihan</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="text-muted">5</span></td>
                                                <td>Sangat Tinggi</td>
                                                <td class="criteria-5-label"></td>
                                                <td>
                                                    <div class="selectgroup selectgroup-pills">
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria5" name="criteria[4]" value="10" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Hanya sekali</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria5" name="criteria[4]" value="40" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Jarang</span>
                                                        </label>
                                                        <label class="selectgroup-item">
                                                            <input type="radio" id="criteria5" name="criteria[4]" value="50" class="selectgroup-input @error('criteria') is-invalid @enderror">
                                                            <span class="selectgroup-button">Sering</span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" onclick="javascript:document.querySelector('input#criteria5:checked').checked=false;" class="btn btn-pill btn-outline-danger btn-sm">Hapus Pilihan</a>
                                                </td>
                                            </tr>
                                            @error('criteria')
                                            <tr>
                                                <td colspan="5">
                                                    <div class="invalid-feedback" style="display: block !important;"><strong>{{ $errors->first('criteria') }}</strong></div>
                                                </td>
                                            </tr>
                                            @enderror
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer btn-list text-right">
                    <button type="reset" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Buat Laporan</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
<script>
require(['jquery', 'selectize', 'validate'], function($, selectize) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
    $.get("{{ url('json/report/rooms') }}", function (data) {
        for (row in data) {
            $('select[name="room_id"]').append($('<option></option>').attr('value', data[row].room_id).text(data[row].room_name));
        }
        $('#room_id, #facilities_id').selectize();
    });
    $('select[name="room_id"]').change(function(event) {
        $('.group-criteria').hide();
        $('#facilities_id')[0].selectize.clear();
        $('#facilities_id')[0].selectize.clearOptions();
        $('#facilities_id')[0].selectize.renderCache['option'] = {};
        $('#facilities_id')[0].selectize.renderCache['item'] = {};
        $('select[name="facilities_id"]').html($('<option></option>').text('-- Pilih --').attr({
            disabled: 'disabled',
            selected: 'selected',
            value: ''
        }));
        if($('select[name="room_id"]').val()!=='') {
            $.get("{{ url('json/report/facilities/') }}/" + $('select[name="room_id"]').val(), function(data) {
                var d=[];
                for (row in data) {
                    d.push({
                        'value': data[row].facilities_id,
                        'text': data[row].facilities_name
                    });
                }
                $('#facilities_id')[0].selectize.addOption(d);
            });
        }
    });
    $('body').on('change', 'select[name="facilities_id"]', function (event) {
        if($('select[name="facilities_id"]').val()!=='') {
            $('input:radio').prop('checked', false);
            $.get("{{ url('json/report/criterias/') }}/" + $('select[name="facilities_id"]').val(), function(data) {
                criteria_1=data['criteria_1'],
                criteria_2=data['criteria_2'],
                criteria_3=data['criteria_3'],
                criteria_4=data['criteria_4'],
                criteria_5=data['criteria_5'];
                $('.criteria-1-label').html(criteria_1);
                $('.criteria-2-label').html(criteria_2);
                $('.criteria-3-label').html(criteria_3);
                $('.criteria-4-label').html(criteria_4);
                $('.criteria-5-label').html(criteria_5);
                if(criteria_1 != null && criteria_1 !== undefined) {
                    $('.group-criteria').show();
                }
            });
        }
    });
    $('body').on('click', 'button[type="reset"]', function (event) {
        $('input:radio').prop('checked', false);
        $('#room_id')[0].selectize.clear();
        $('#facilities_id')[0].selectize.clear();
        $('#facilities_id')[0].selectize.clearOptions();
        $('#facilities_id')[0].selectize.renderCache['option'] = {};
        $('#facilities_id')[0].selectize.renderCache['item'] = {};
        $('.group-criteria').hide();
        $('select[name="facilities_id"]').html($('<option></option>').text('-- Pilih --').attr({
            disabled: 'disabled',
            selected: 'selected'
        }));
    });
});
</script>
@endpush