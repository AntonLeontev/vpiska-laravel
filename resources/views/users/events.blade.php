@extends('layouts.app')

@section('title')
    Мои вписки
@endsection

@section('content')
    <div class="content">
        <div class="weed">
            <div class="container">

                <h3 class="weed__title">
                    Уведомления
                </h3>

                <div class="weed__wrapper">
                    <h3 class="weed__name">Мои мероприятия</h3>
                    <div class="weed__important">
                        @foreach ($userEvents as $event)
                            <div class="weed-item">
                                <div class="weed-item__left">
                                    <div class="weed-item__icon">
                                        <img src="{{ Vite::image('icons/active-wed.svg') }}" alt="Активное мероприятие">
                                    </div>
                                    <div class="weed-item__column">
                                        <div class="weed-item__status">
                                            Активное мероприятие
                                        </div>
                                        <div class="weed-item__info">
                                            <div class="weed-item__name">
                                                Имя: <a
                                                    href="{{ route('users.show', $event->creator_id) }}">{{ $event->creator->full_name }}</a>
                                            </div>
                                            <div class="weed-item__price">
                                                Цена: {{ $event->price }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="weed-item__right">
                                    <div class="weed-item__date">
                                        {{ $event->start_date }} {{ $event->start_time }}
                                    </div>
                                    <div class="weed-item__actions">
                                        <a href="{{ route('events.show', $event->id) }}"
                                            class="weed-item__action weed-item__action--grey">Перейти</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <h3 class="weed__name">Заявки на мои мероприятия</h3>
                    <div class="weed__important">
                        @foreach ($incomingOrders as $order)
                            <x-common.modal id="{{ $order->id }}">
                                <h4>ЗАЯВКА</h4>
                                <div class="user__modal">
                                    <div class="user__modal__photo">
                                        <img src="{{$order->customer->photo_path}}" alt="profile img">
                                    </div>
                                    <div class="user__modal__info">
                                        <div class="user__modal__name">
                                            {{$order->customer->full_name}}
                                        </div>
                                        <div class="user__modal__rating">
                                            <div class="rating-mini">
                                                <span class="active"></span>
                                                <span class="active"></span>
                                                <span class="active"></span>
                                                <span class="active"></span>
                                                <span class="active"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="" class="weed-item__action">Отказать</a> <!-- Принятие заявкм -->
                                <a href="" class="weed-item__action">Принять</a> <!-- Отклонение заявки -->
                            </x-common.modal>

                            <div class="weed-item">
                                <div class="weed-item__left">
                                    <div class="weed-item__icon">
                                        <img src="{{Vite::image('icons/inner-wed.svg')}}" alt="Новая заявка">
                                    </div>
                                    <div class="weed-item__column">
                                        <div class="weed-item__status">
                                            Новая заявка
                                        </div>
                                        <div class="weed-item__info">
                                            <div class="weed-item__name">
                                                Имя: <a href="{{route('users.show', $order->customer->id)}}">{{$order->customer->full_name}}</a>
                                            </div>
                                            <div class="weed-item__price">
                                                Цена: {{$order->event->price}} p
                                            </div>
                                        </div>

                                        <div class="weed-item__info">
                                            <div class="weed-item__name">
                                                <x-common.form action="{{route('orders.accept', $order->id)}}" method="post">
                                                    <input type="submit" class="weed-item__action" value="Принять">
                                                </x-common.form>
                                            </div>
                                            <div class="weed-item__price">
                                                <x-common.form action="{{route('orders.decline', $order->id)}}" method="post">
                                                    <input type="submit" class="weed-item__action" value="Отказать">
                                                </x-common.form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="weed-item__right">
                                    <div class="weed-item__date">
                                        {{$order->event->start_date}} {{$order->event->start_time}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <h3 class="weed__name">Мои заявки</h3>
                    <div class="weed__all">
                        @foreach ($outgoingOrders as $order)
                            <div class="weed-item">
                                <div class="weed-item__left">
                                    <div class="weed-item__icon">
                                        <img src="
                                        @if($order->status === 0)
                                        {{Vite::image('icons/inner-wed.svg')}}
                                        @elseif($order->status === 1)
                                        {{Vite::image('icons/done-wed.svg')}}
                                        @elseif($order->status === 2)
                                        {{Vite::image('icons/cancel-wed.svg')}}
                                        @endif
                                        " alt="Иконка заказа">
                                    </div>
                                    <div class="weed-item__column">
                                        <div class="weed-item__status">
                                            {{$order->status_name}}
                                        </div>
                                        <div class="weed-item__info">
                                            <div class="weed-item__name">
                                                Имя: <a href="{{route('users.show', $order->customer->id)}}">{{$order->customer->full_name}}</a>
                                            </div>
                                            <div class="weed-item__price">
                                                Цена: {{$order->event->price}} р
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="weed-item__right">
                                    <div class="weed-item__date">
                                        {{$order->event->start_date}} {{$order->event->start_time}}
                                    </div>
                                    <div class="weed-item__actions">
                                        {{-- //TODO Modal and links --}}
                                        <a href="#{{$order->event->id}}" class="weed-item__action weed-item__action--grey">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
