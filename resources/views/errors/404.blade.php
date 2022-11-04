@extends('layouts.app')

@section('title')
		Страница 404
@endsection

@section('content')
		<div class="content">
			<div class="authorization__title ">
				<div class="title__main ">
					<div class="error404">
						<div class="error404_digits">404</div>
						<div class="error404_text">Такой страницы не существует или она удалена</div>
						<div><a href="{{route('home')}}" class="error404_button">На главную</a></div>
					</div>
				</div>
			</div>
		</div>
@endsection
