@extends('layouts.app')

@section('title')
		Страница 500
@endsection

@section('content')
		<div class="content">
			<div class="authorization__title ">
				<div class="title__main ">
					<div class="error404">
						<div class="error404_digits">500</div>
						<div class="error404_text">Произошла ошибка</div>
						<div><a href="{{route('home')}}" class="error404_button">На главную</a></div>
					</div>
				</div>
			</div>
		</div>
@endsection
