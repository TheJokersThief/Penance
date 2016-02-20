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

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        @if( count($errors) > 0 )
                            <ul class="red lighten-2 errors">
                                <li class="first">Errors:</li>
                                @foreach( $errors->all() as $error )
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="input-field col s12">
                          <input type="email" name="email" value="{{ $email or old('email') }}">
                          <label for="email" data-error="Error">Email</label>
                        </div>

                        <div class="input-field col s12">
                          <input type="password" name="password">
                          <label for="password" data-error="Error">Password</label>
                        </div>

                        <div class="input-field col s12">
                          <input type="password" name="password_confirmation">
                          <label for="password_confirmation" data-error="Error">Password Confirmation</label>
                        </div>

                        <div class="col s12">
                            <button type="submit" class="waves-effect waves-light btn">
                                <i class="material-icons left">refresh</i>Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col m8 col offset-m2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col m4 control-label">E-Mail Address</label>

                            <div class="col m6">
                                <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col m4 control-label">Password</label>

                            <div class="col m6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col m4 control-label">Confirm Password</label>
                            <div class="col m6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col m6 col offset-m4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i>Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
