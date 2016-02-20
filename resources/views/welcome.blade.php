@extends('layouts.default')

@section('content')
<h1>Test</h1>

@if( Auth::check() )
    YOU ARE LOGGED IN 
@endif


@endsection