@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="card auth-card">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Create Account</h2>
            <p class="text-muted mb-0">Register for a Tech Store account</p>
        </div>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    required
                >

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

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

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    required
                >
            </div>

            <button class="btn btn-dark w-100 py-2" type="submit">
                Register
            </button>
        </form>

        <div class="text-center mt-4">
            <span class="text-muted">Already have an account?</span>
            <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>
@endsection
