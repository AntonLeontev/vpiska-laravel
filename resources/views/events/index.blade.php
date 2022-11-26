@extends('layouts.app')

@section('title', 'Мероприятия')

@section('content')
    <div class="content">
        <div class="find">
            <div class="container">
                <div class="find__row">
                    <div class="find__title">
                        <h3>Поиск вписки</h3>
                    </div>
                    @if($events->isEmpty())
						<div class="find__text">
                            <h3>В вашем городе, никто не собирает компанию <br>
                                но вы можете сами её <a href="{{route('events.create')}}">собрать</a></h3>
                        </div>
                    @endif
                    <div class="find__cards">
                        @foreach ($events as $event)
                            <a class="find__link" href="{{ route('events.show', $event->id) }}">
                                <div class="find-card">
                                    <div class="find-card__user">
                                        <div class="find-card__image">
                                            <img src="{{$event->creator->photo_path}}" alt="user">
                                        </div>
                                        <div class="find-card__title">
                                            <div class="find-card__main">
                                                <p>Организатор:</p>
                                            </div>
                                            <div class="find-card__description">
                                                {{ $event->creator->full_name }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="find-card__address">
                                        <div><span>Рейтинг:</span></div>



                                        <div class="rating-mini">
                                            <span class="active"></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>

                                    </div>
                                    <div class="find-card__date">
                                        <p>
                                            <span>Начало:</span> {{ $event->starts_at }}
                                        </p>
                                    </div>

                                    <div class="find-card__time">
                                        <p>
                                            <span>Конец:</span> {{ $event->ends_at }}
                                        </p>
                                    </div>

                                    <div class="find-card__address find-card__address--none">
                                        <p>
                                            <span>Адрес:</span> г {{ $event->city_name }}, {{ $event->full_street }},
                                            дом {{ $event->building }}
                                        </p>
                                    </div>
                                    <div class="find-card__busy">
                                        <p>
                                            <span>Свободно мест:</span>
                                            {{ $event->max_members - ($event->orders->whereIn('status', [1, 3])->count() ?? 0) }}
                                            из {{$event->max_members}}
                                        </p>
                                    </div>

                                    <div class="find-card__busy">
                                        <p>
                                            <span>Цена:</span> {{ $event->price }} р
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
