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
                <form class="card" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div class="card-body p-6">
                        <div class="card-title">{{ __('Reset Password') }}</div>
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
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" placeholder="Masukkan password" name="password" value="{{ old('password') }}" required autocomplete="new-password" autofocus tabindex="1">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" placeholder="Masukkan konfirmasi password" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="new-password" tabindex="2">
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block" tabindex="3">{{ __('Reset Password') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
