@extends('layouts.default')

@section('title') {{ $list->title }} @endsection
@section('body-class') show-list @endsection
@section('wrapper-class') valign-wrapper @endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">{{ $list->title }}</div>     
                    <ul class="collection">

                        @foreach( $list->tasks as $task )
                            <li class="collection-item">
                                Alvin
                                <a href="#!" class="secondary-content"><i class="material-icons">send</i></a>
                            </li>
                        @endforeach
                     
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
