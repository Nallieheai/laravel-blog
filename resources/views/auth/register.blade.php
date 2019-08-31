@extends('layout')
@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    {{-- @csrf = Protects against "Cross Side Request Forgery" attacks --}}
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}"
            class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" required>

        @if ($errors->has('name'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>

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
        <label>Confirm password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary btn-block">Register!</button>
</form>
@endsection