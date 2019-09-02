@extends('layout')

@section('content')
    <h1>Contact!</h1>

    @can('home.secret')
        <p>
            <a href="{{ route('secret') }}">Secret contact details!</a>
        </p>
    @endcan
@endsection