@extends('layout')
@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf
    {{-- @csrf = Protects against "Cross Side Request Forgery" attacks --}}

    <div class="form-group">
        <label>Email</label>
        <input type="text" name="email" value="{{ old('email') }}"
            class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" required>

        @if ($errors->has('email'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}"
            required>

        @if ($errors->has('password'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
    </div>

    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" name="remember" class="form-check-input" value="{{ old('remember') ? 'checked' : '' }}">
            <label for="remember" class="form-check-label">
                Remember me!
            </label>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Login!</button>
</form>

<a href="{{ route('register') }}">Don't have an account? Create one here!</a>
@endsection