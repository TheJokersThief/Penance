@extends('layouts.default')

@section('title') {{ $list->title }} @endsection
@section('body-class') show-list @endsection
@section('wrapper-class') valign-wrapper @endsection

@section('extra-js')
    <script type="text/javascript">
        $(document).ready( function(){
            initTaskList( '{{ Crypt::encrypt($list->id) }}');
        });
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">{{ $list->title }}
                        <a class="waves-effect waves-light chip right green lighten-2" id="show-done" data-bind="click: toggleShowDone">Show Done</a>
                        <a class="waves-effect waves-light chip right red lighten-2" id="hide-done" data-bind="click: toggleShowDone">Hide Done</a>
                    </div>     
                     @if( $list->global )
                        <p class="chip url-chip"><a data-bind="click: copyToClipboard" id="URL">{{ URL::route('showBySlug', $list->slug) }}</a></p>
                    @else
                        <p class="chip url-chip"><a data-bind="click: copyToClipboard" id="URL">{{ URL::route('showByUserSlug', $list->slug, $list->user->name) }}</a></p>
                    @endif

                    <ul class="collection">

                        <!-- ko foreach: tasks -->
                            <li class="collection-item" data-bind="attr: {taskid: id}">
                                <div class="col s2 ">
                                    <!-- ko if: (done == 1) -->
                                        <input type="checkbox" class="filled-in" data-bind="attr: {id:id}, event: {change: $parent.updateTask}, checkedValue: done, checked: done" />
                                    <!-- /ko -->

                                    <!-- ko if: (done == 0) -->
                                        <input type="checkbox" class="filled-in" data-bind="attr: {id:id}, event: {change: $parent.updateTask}" />
                                    <!-- /ko -->

                                    <label data-bind="attr: {for:id}"></label>
                                </div>
                                <div class="col s10">
                                    <a class="right waves-effect waves-light close-this red-text" data-bind="click: $parent.deleteTask">&times;</a>
                                    <textarea data-bind="value: description, event: {mouseup: $parent.stripLines, change: $parent.updateTask}" rows="1" ></textarea> 
                                    <!-- <p data-bind="text: description"></p> -->
                                </div>
                            </li>
                        <!-- /ko -->

                        <li class="loading collection-item progress">
                          <div class="indeterminate"></div>
                        </li>
                     
                    </ul>

                    <div class="new-task">
                        New Task:
                        <textarea data-bind="event: {mouseup: createTask}" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Press enter to add new task"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
