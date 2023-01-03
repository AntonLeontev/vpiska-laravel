@props(['paginator'])

@if($paginator->hasPages())
	<div {{$attributes->merge()}} class="pagination">
		<div class="pagination__prev">
			<x-common.pagination.link 
				href="{{$paginator->previousPageUrl()}}" 
				disabled="{{$paginator->onFirstPage()}}"
			>
				Назад
			</x-common.pagination.link>
		</div>
		<div class="pagination__next">
			<x-common.pagination.link 
				href="{{$paginator->nextPageUrl()}}" 
				disabled="{{$paginator->onLastPage()}}"
			>
				Вперёд
			</x-common.pagination.link>
		</div>
	</div>
@endif
