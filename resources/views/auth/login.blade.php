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
                <form class="card" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="card-body p-6">
                        <div class="card-title">{{ __('Masuk') }}</div>
                        @error('email')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('password')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Masukkan email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus tabindex="1">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                            Password
                            <a href="{{ route('password.request') }}" class="float-right small" tabindex="5">{{ __('Lupa password') }}</a>
                            </label>
                            <input type="password" name="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password" tabindex="2">
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <span class="custom-control-label">{{ __('Ingatkan saya') }}</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block" tabindex="4">{{ __('Masuk') }}</button>
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted">
                    Belum punya akun siswa? <a href="{{ route('register') }}" tabindex="6">Buat akun baru</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
