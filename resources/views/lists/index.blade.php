@extends('layouts.default')


@section('body-class') welcome @endsection
@section('wrapper-class') valign-wrapper @endsection

@section('content')
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
		        			{{ $list->title }} @if( $list->global ) <em>(Global)</em> @endif
		        			<a href="{{ URL::route('list.show', $list->id ) }}" class="secondary-content"><i class="material-icons">send</i></a>
		        		</div>
		        	</li>
		        @empty
		        	<li class="collection-item">No lists yet :( <a href="{{ URL::route('list.create') }}">Create a new list?</a></li>
		        @endforelse
			</ul>
		</div>
	</div>



@endsection