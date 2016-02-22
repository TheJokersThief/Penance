@extends('layouts.default')

@section('title') Create A List @endsection
@section('body-class') create-list @endsection
@section('wrapper-class') valign-wrapper @endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">New List</div>

                    <form role="form" method="POST" action="{{ URL::route('list.store') }}">
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
                          <input type="text" name="title" value="{{ old('title') }}">
                          <label for="title">List Title</label>
                        </div>

                        <div class="input-field col s12">
                          <input type="text" name="slug" value="{{ old('slug') }}">
                          <label for="slug">Slug (alphanumeric only) <i class="material-icons right tooltipped" data-position="top" data-delay="50" data-tooltip="A slug is the human-readable part of the URL. The slug for 'http://todo.netsoc.co/todo' is 'todo' or for 'http://todo.netsoc.co/evan/todo' is also 'todo'.">info</i></label>
                        </div>

                        <div class="col s12 m6">
					      <input type="checkbox" class="filled-in" id="filled-in-box" {{ (old('global') == "on" ? "checked" : "") or "checked" }} name="global" />
					      <label for="filled-in-box">Global Slug <i class="material-icons right tooltipped" data-position="bottom" data-delay="50" data-tooltip="Whether your new list will appear at /My-List (Global) or /Username/My-List (NOT Global)">info</i></label>
					    </div>

                        <div class="col s12 m6">
                            <button type="submit" class="waves-effect waves-light btn">
                                <i class="material-icons left">add</i>Create List
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
