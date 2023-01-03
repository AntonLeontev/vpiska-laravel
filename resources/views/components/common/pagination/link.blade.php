@props(['disabled' => true])

@if($disabled) 
	<span class="pagination__link__disabled">
		{{ $slot }}
	</span>
@else
	<a class="pagination__link" {{ $attributes->merge() }}>
		{{ $slot }}
	</a>
@endif
