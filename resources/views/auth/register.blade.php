@extends('layout')
@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf 
        {{-- @csrf = Protects against "Cross Side Request Forgery" attacks --}}
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="text" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Confirm password</label>
            <input type="text" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Register!</button>
    </form>
@endsection