	</div>
    <script src="{{URL::to('/js/libraries.js')}}"></script>
	<script type="text/javascript" src="{{ URL::to('/js/app.js') }}"></script>
	@yield('extra-js')

	<script type="text/javascript">
		@if( session('error') )
			$(document).ready(function(){
				Materialize.toast('{{ session('error') }}', 5000, 'red lighten-2');
			});
		@endif

		@if( session('success') )
			$(document).ready(function(){
				Materialize.toast('{{ session('success') }}', 3000, 'green lighten-2');
			});
		@endif
	</script>

	@if( Auth::check() )
		<meta name="csrf-token" content="{{ csrf_token() }}">
	@endif

</body>
</html>
