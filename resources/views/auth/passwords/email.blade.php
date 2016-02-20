@extends('layouts.default')

@section('body-class') forgot @endsection
@section('wrapper-class') valign-wrapper @endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">Reset Password</div>

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}

                        @if( count($errors) > 0 )
                            <ul class="red lighten-2 errors">
                                <li class="first">Errors:</li>
                                @foreach( $errors->all() as $error )
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="input-field col s12">
                          <input type="email" name="email" value="{{ old('email') }}">
                          <label for="email" data-error="Error">Email</label>
                        </div>

                        <div class="col s12">
                            <button type="submit" class="waves-effect waves-light btn">
                                <i class="material-icons left">email</i>Send Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
