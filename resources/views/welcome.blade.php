@extends('layouts.default')


@section('body-class') welcome @endsection
@section('wrapper-class') valign-wrapper @endsection

@section('content')
	@if( Auth::check() )
		<div class="row lists">
			<div class="col s12 m8 offset-m2 l6 offset-l3">
				<ul class="collection with-header z-depth-1">
			        <li class="collection-header valign-wrapper">
			        	<h4>Your Lists</h4>
						<a href="{{ URL::route('list.create') }}" class="btn-floating waves-effect waves-light secondary-content"><i class="material-icons">add</i></a>
			        </li>
			        @forelse( Auth::user()->lists as $list )
			        	<li class="collection-item">
			        		<div>
			        			{{ $list->title }}
			        			<a href="{{ URL::route('list.show', $list->id ) }}" class="secondary-content"><i class="material-icons">send</i></a>
			        		</div>
			        	</li>
			        @empty
			        	<li class="collection-item">No lists yet :( <a href="{{ URL::route('list.create') }}">Create a new list?</a></li>
			        @endforelse
				</ul>
			</div>
		</div>
	@else
		<div class="row registration">
	        <div class="col s12 m6 l4 offset-l2 login">
	            <div class="card valign-wrapper">
	                <div class="card-content">
	                    <div class="card-title">Login</div>

	                    <form role="form" method="POST" action="{{ url('/login') }}">
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

	                        <div class="input-field col s12">
	                          <input type="password" name="password" value="{{ old('password') }}">
	                          <label for="password" data-error="Error">Password</label>
	                        </div>

	                        <div class="col s12 m6">
	                            <button type="submit" class="waves-effect waves-light btn">
	                                <i class="material-icons left">perm_identity</i>Login
	                            </button>
	                        </div>

	                        <div class="col s12 m6">
	                            <a class="waves-effect waves-light btn" href="{{ url('/password/reset') }}">Forgot?</a>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	        <div class="col s12 m6 l4 register">
	            <div class="card">
	                <div class="card-content">
	                    <div class="card-title">Register</div>

	                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
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
	                          <input type="text" name="name" value="{{ old('name') }}">
	                          <label for="name" data-error="Error">Username</label>
	                        </div>

	                        <div class="input-field col s12">
	                          <input type="email" name="email" value="{{ old('email') }}">
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

	                        <div class="col s12 m6">
	                            <button type="submit" class="waves-effect waves-light btn">
	                                <i class="material-icons left">perm_identity</i>Register
	                            </button>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	@endif


@endsection