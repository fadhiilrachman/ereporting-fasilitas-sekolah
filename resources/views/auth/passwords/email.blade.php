@extends('layouts.auth')

@section('content')
<div class="page-single">
    <div class="container">
        <div class="row">
            <div class="col col-login mx-auto">
                <div class="text-center mb-6">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('/brand/logo.png') }}" class="h-6" alt="logo">
                    </a>
                </div>
                <form class="card" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="card-body p-6">
                        <div class="card-title">{{ __('Lupa password') }}</div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @error('email')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <p class="text-muted">Masukkan alamat email anda lalu sistem akan mengirimkan link ke email anda.</p>
                        <div class="form-group">
                            <label class="form-label" for="email">{{ __('Alamat email') }}</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan alamat email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus tabindex="1">
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block" tabindex="2">{{ __('Kirim link reset password') }}</button>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted">
                    Saya ingat, <a href="{{ route('login') }}" tabindex="3">kembali</a> ke halaman login.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
