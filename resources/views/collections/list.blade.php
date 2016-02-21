<li class="collection-item">
	<div>
		<a href="{{ URL::route('list.show', $list->id ) }}" class="red-text text-lighten-2">{{ $list->title }}

			@if( $list->global ) 
				<em>({{ str_replace( URL::to('/'), '', URL::route('showBySlug', $list->slug) ) }})</em> 
			@else
				<em>({{ str_replace( URL::to('/'), '', URL::route('showByUserSlug', $list->slug, $list->user->name) ) }})</em>
			@endif 
		</a>
		<a href="{{ URL::route('list.show', $list->id ) }}" class="secondary-content"><i class="material-icons red-text text-lighten-2">send</i></a>
	</div>
</li>
