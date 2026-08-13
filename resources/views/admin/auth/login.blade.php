@extends('layout.mainlayout')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 600px; border-radius: 10px;">

            <div class="card-body p-4">

                <div class="text-center mb-4">
                    <img src="{{ asset('website/images/logo.png') }}" alt="logo" style="max-height: 60px;">
                    <h3 class="mt-3">Sign In</h3>
                </div>

                <form action="{{ route('admin.loginAction') }}" method="POST">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Email -->
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="text" class="form-control" name="email" value="{{ $email ?? '' }}">
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" value="{{ $password ?? '' }}">
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="d-flex justify-content-between mb-3">
                        <label>
                            <input type="checkbox" name="remember" value="1" {{ !empty(old('email', $email ?? '')) ? 'checked' : '' }}>
                            Remember me
                        </label>

                        <a href="{{ route('admin.password.request') }}">Forgot?</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>

                </form>
            </div>
        </div>
    </div>
@endsection