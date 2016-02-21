<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', env('SITE_TITLE'))</title>
	<meta charset="utf-8">
	<meta name="description" content="@yield('description')" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<link rel="shortcut icon" href="{{ URL::to('/images/favicon.png') }}">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ URL::to('/css/app.css') }}">
	@yield('extra-css')

	@yield('extra-head')
</head>
<body class="@yield('body-class')">
	<div class="body-wrapper @yield('wrapper-class')">

	@if( Auth::check() )
		<div class="fixed-action-btn horizontal click-to-toggle hide-on-small-only" style="top: 45px; right: 24px;">
		    <a class="btn-floating btn-large teal lighten-2">
		      <i class="large mdi-navigation-menu"></i>
		    </a>
		    <ul>
			  <li>
			  	<a href="{{ URL::to('logout') }}" class="btn-floating red lighten-2 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Logout">
			  		<i class="material-icons">exit_to_app</i>
			  	</a>
			  </li>

			  <li>
			  	<a href="{{ URL::route('list.create') }}" class="btn-floating orange lighten-2 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Create New List">
			  		<i class="material-icons">add</i>
			  	</a>
			  </li>

			  <li>
			  	<a href="{{ URL::route('list.index') }}" class="btn-floating green lighten-2 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Your Lists">
			  		<i class="material-icons">list</i>
			  	</a>
			  </li>
		    </ul>
		</div>

		<div class="fixed-action-btn click-to-toggle hide-on-med-and-up" style="bottom: 45px; right: 24px;">
		    <a class="btn-floating btn-large teal lighten-2">
		      <i class="large mdi-navigation-menu"></i>
		    </a>
		    <ul>
			  <li>
			  	<a href="{{ URL::to('logout') }}" class="btn-floating red lighten-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Logout">
			  		<i class="material-icons">exit_to_app</i>
			  	</a>
			  </li>

			  <li>
			  	<a href="{{ URL::route('list.create') }}" class="btn-floating orange lighten-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Create New List">
			  		<i class="material-icons">add</i>
			  	</a>
			  </li>

			  <li>
			  	<a href="{{ URL::route('list.index') }}" class="btn-floating green lighten-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Your Lists">
			  		<i class="material-icons">list</i>
			  	</a>
			  </li>
		    </ul>
		</div>
	@endif