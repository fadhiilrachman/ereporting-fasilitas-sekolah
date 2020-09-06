@extends('layouts.app')

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            Pengaturan
        </h1>
    </div>
    <div class="row row-cards">
        <div class="col-12 col-lg-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-4 text-center">
                                <img src="{{ asset('/avatar/default.png') }}" alt="avatar" class="img-fluid">
                            </div>
                            <h4 class="card-title">{{ $user->name }}</h4>
                            <div class="card-subtitle">
                                <p><i class="fe fe-mail"></i> {{ $user->email }}</p>
                                <p><i class="fe fe-user"></i> {{ $role->role_name }}</p>
                            </div>
                            <div class="mt-5 d-flex align-items-center">
                                <div class="ml-auto">
                                    <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-primary"><i class="fe fe-log-out"></i> Keluar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
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
            <form class="card" method="POST" action="{{ url('settings/update-email') }}">
                @csrf
                <div class="card-body">
                    <h3 class="card-title">Ganti Email</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="email">Alamat email</label>
                                <input type="email" id="email" name="email" autocomplete class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan alamat email baru">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Perbarui Email</button>
                </div>
            </form>
            <form class="card" method="POST" action="{{ url('settings/update-password') }}">
                @csrf
                <div class="card-body">
                    <h3 class="card-title">Ganti Password</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label" for="password">Password lama</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password lama anda" value="">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="new_password">Password baru</label>
                                <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Password baru anda" value="">
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="new_password-confirm">Konfirmasi password baru</label>
                                <input type="password" id="new_password-confirm" name="new_password_confirm" class="form-control @error('new_password') is-invalid @enderror" placeholder="Konfirmasi password baru anda" value="">
                                @error('new_password_confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('new_password_confirm') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Perbarui Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
