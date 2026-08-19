@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="card auth-card">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Welcome Back</h2>
            <p class="text-muted mb-0">Login to your Tech Store account</p>
        </div>

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required
                >

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required
                >

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check mb-4">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    value="1"
                    id="remember"
                >
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            <button class="btn btn-dark w-100 py-2" type="submit">
                Login
            </button>
        </form>

        <div class="text-center mt-4">
            <span class="text-muted">Don't have an account?</span>
            <a href="{{ route('register') }}">Create account</a>
        </div>
    </div>
</div>
@endsection
