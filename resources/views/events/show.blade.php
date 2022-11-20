@extends('layouts.app')

@section('title', 'Вечеринка')

@section('content')
    <div class="content">
        <div class="activity">
            <div class="container">
                @auth
                    <x-common.modal id="modal_order">
                        <h4>Оплата вписки</h4>
                        <h4>Стоимость - {{ $event->price }} р + Комиссия - {{$event->fee}} р</h4>

                        <x-common.form action="{{route('orders.store')}}" method="POST">
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="customer_id" value="{{ auth()->user()->id }}">
                            <div class="submit__checkbox">
                                <label class="checkbox" for="rules">
                                    <input type="checkbox" id="rules" name="scales" required checked>
                                    Согласен с <a href="{{route('policy')}}">политикой
                                        конфидециальности</a>, а так же <a
                                        href="{{route('processing')}}">обработку</a> и <a
                                        href="{{route('dissemination')}}">распространение</a>
                                    персональных данных.
                                </label>
                            </div>
                            @if (auth()->user()->balance > $event->price)
                                <label class="pay_from_account">
                                    <input type="checkbox" class="pay_from_account_checkbox" name="pay_from_account"
                                        id="pay_from_account">
                                    Оплатить со счета (на счету {{ auth()->user()->balance }} р)
                                </label>
                            @endif
                            <br>
                            <button type="submit" class="mobile__order btn">Вписаться</button>
                        </x-common.form>
                    </x-common.modal>
                @endauth
            </div>
            <div class="activity__row">
                <div class="activity__title">
                    <div class="title__info">
                        <p><b>Мероприятие</b></p>
                    </div>
                    <div class="title__close">
                        <p><a href="/">X</a></p>
                    </div>
                </div>
                <div class="activity__inforamtion__main">
                    <div class="inforamtion__body">
                        <div class="information__user">
                            <div class="information__user__image"><img src="{{ $event->creator->photo_path }}"
                                    alt="user"></div>
                            <div class="information__user__title">
                                <div class="user__title__main">
                                    <p>Организатор: <a
                                            href="{{ route('users.show', $event->creator->id) }}">{{ $event->creator->full_name }}</a>
                                    </p>
                                </div>
                                <div class="user__title__description">
                                    <div>Рейтинг: </div>
                                    <div class="rating-mini">
                                        <span class="active"></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="information__time">
                            <div class="information__time__date">
                                <p><b>Дата: </b>{{ $event->start_date }}</p>
                            </div>
                            <div class="information__time__main">
                                <p><b>Время: </b>{{ $event->start_time }}</p>
                            </div>
                        </div>
                        <div class="information__address">
                            <div class="information__address__city">
                                <p><b>Адрес:</b> г.{{ $event->city_name }},</p>
                            </div>
                            <div class="information__address__full">
                                <p>ул. {{ $event->street }}, дом №{{ $event->building }}</p>
                            </div>
                        </div>
                        <div class="description__main">
                            <p>{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
                @guest
                    @isFilled ($event)
                    <x-common.alert>Свободных мест на мероприятие нет</x-common.alert>
                    @endif
                @endguest

                @auth
                    @isCreator($event)
                        <x-common.alert>Вы организатор этого мероприятия</x-common.alert>

                        @php
                            $hasOrders = $event->orders->count() > 0;
                        @endphp
                        <div class="creator_controls">
                            <a @class([
                                'creator_controls__edit',
                                'creator_controls__edit_disabled' => $hasOrders,
                            ]) @if (!$hasOrders)
                                href="{{ route('events.edit', $event->id) }}"
                                @endif
                                >Редактировать</a>
                                <form action="{{route('events.delete', $event->id)}}" method="delete" id="form__event-cancel" confirmable="confirmable">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <button class="creator_controls__cancel">
                                        Отменить
                                    </button>
                                </form>
                        </div>
                    @endisCreator

                    @isOrdered($event)
                        <x-common.alert>
                            @isPaid($event)
                                Вы подавали заявку на вписку. Заявка оплачена
                                @if ($event->currentUserOrder()->status === 0)
                                    и на одобрении организатора
                                @elseif ($event->currentUserOrder()->status === 1)
                                    и одобрена
                                @elseif ($event->currentUserOrder()->status === 2)
                                    и отклонена. Деньги вернулись на счет
                                @endif
                            @else
                                Вы подавали заявку на вписку. Заявка не оплачена. Оплатите заявку
                            @endisPaid
                        </x-common.alert>
                    @else
                        @isFilled ($event)
                        <x-common.alert>Свободных мест на мероприятие нет</x-common.alert>
                        @endif
                    @endisOrdered

                @endauth

                {{-- Мобильные кнопки оплаты или отмены --}}
                @unlessisPaid($event)
                    <a @guest
                        href="#register_2" @endguest @auth
                        href="#modal_order" @endauth>
                        <div class="button__pay">
                            <div class="pay__image">
                                <img src="{{ Vite::image('icons/create.png') }}" alt="pay">
                            </div>
                            <div class="pay__text">
                                <p>
                                    @guest
                                        ВПИСАТЬСЯ
                                    @endguest
                                    @auth
                                        @unlessisOrdered($event)
                                            ВПИСАТЬСЯ
                                        @else
                                            ОПЛАТИТЬ
                                        @endisOrdered
                                    @endauth
                                </p>
                            </div>
                            <div class="pay__sum">
                                <p>{{ $event->price }} р</p>
                            </div>
                        </div>
                    </a>
                @else
                    @if ($event->currentUserOrder()->status < 2)
                        <div class="button__cancel cancel_order_button" data-user_id="{{ auth()->user()->id }}"
                            data-event_id="{{ $event->id }}">
                            <div class="pay__text">
                                <p>
                                    ОТМЕНИТЬ
                                </p>
                            </div>
                        </div>
                    @endif
                @endisPaid
            
                <div class="activity__main">
                    <div class="main__gallery">
                        <div class="main__title">
                            <p>Галерея</p>
                        </div>
                        <div class="main__photos">
                            <div class="slider-photos">
                                @if ($event->images->count() === 0)
                                    <ul>
                                        <li><img src="{{Vite::image('plugs/event/2.jpg')}}" alt="Фото мероприятия"></li>
                                    </ul>
                                @else
                                    <div class="carousel">
                                        @foreach ($event->images as $photo)
                                            <img src="/storage/{{ $photo->path }}" alt="Фото мероприятия">
                                        @endforeach
                                    </div>
                                    <div class="carousel-controls">
                                        <button type="button" class="slick-prev">
                                            <img src="{{Vite::image('icons/prev.svg')}}" alt="prev">
                                        </button>
                                        <span class="carousel-count">1/{{ $event->images->count() }}</span>
                                        <button type="button" class="slick-next">
                                            <img src="{{Vite::image('icons/next.svg')}}" alt="next">
                                        </button>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="main__chat">
                        @auth
                            <div class="chat__title">
                                <p>Общий чат</p>
                            </div>
                            <div class="chat__main" 
                            data-user_id="{{ auth()->user()->id }}" 
                            data-user_name="{{auth()->user()->full_name}}"
                            data-user_avatar="{{ auth()->user()->photo_path }}"
                            data-user_link="{{ route('users.show', auth()->user()->id) }}"
                            data-chat_id="{{$event->id}}"
                            >
                                <div id="chatbro">
                                    <button id="chatbroOpenChat">Войти в общий чат</button>

                                </div>
                            </div>
                        @endauth
                    </div>
                </div>

                <div class="activity__application">
                    <div class="application__title">
                        <div class="title__1">
                            <p>Уже вписались</p>
                        </div>
                        <div class="title__2">
                            {{-- //TODO Filter accepted orders --}}
                            <p>{{ $event->orders->where('status', 1)->count() ?? 0 }}/{{ $event->max_members }}</p>
                        </div>
                    </div>
                    <div class="application__main" id="application__main">

                        @unlessisCreator ($event)
                            @unlessisFilled ($event)
                                @isPaid ($event)
                                    <a href="#">
                                        <div class="application__card__pay">
                                            <div class="add__image">
                                                <img src="{{Vite::image('icons/create.png')}}" alt="add">
                                            </div>
                                            <div class="add__text">
                                                <p><b>
                                                    @if ($event->currentUserOrder->status === 0)
                                                        На рассмотрении
                                                    @elseif ($event->currentUserOrder->status === 1)
                                                        Одобрена
                                                    @elseif ($event->currentUserOrder->status === 2)
                                                        Отклонена
                                                    @endif
                                                </b></p>
                                            </div>
                                            @if ($event->currentUserOrder->status < 2)
                                                <div class="add__text cancel_order_button" data-user_id="{{auth()->user()->id}}" data-activity_id="{{$event->id}}">Отменить</div>
                                            @endif
                                        </div>
                                    </a>
                                @else
                                    <a 
                                    @guest
                                        href="#register_2"
                                    @endguest  
                                    @auth
                                        href="#modal_order"
                                    @endauth 
                                    >
                                        <div class="application__card__pay">
                                            <div class="add__image">
                                                <img src="{{Vite::image('icons/create.png')}}" alt="add">
                                            </div>
                                            <div class="add__text">
                                                <p><b>
                                                    @guest
                                                        Вписаться
                                                    @endguest
                                                    @auth
                                                        @isOrdered($event)
                                                            Оплатить
                                                        @else
                                                            Вписаться
                                                        @endisOrdered
                                                    @endauth  
                                                </b></p>
                                            </div>
                                            <div class="add__text">
                                                <p><b>{{$event->price}} р</b></p>
                                            </div>
                                        </div>
                                    </a>
                                @endisPaid
                            @endisFilled
                        @endisCreator


                        @foreach ($event->orders->where('status', 1) as $order)
                            <a href="{{route('users.show', $order->customer->id)}}">
                                <div class="application__card">
                                    <div class="application__photo"><img src="{{$order->customer->photo_path}}" alt="user"></div>
                                    <div class="application__name">
                                        <p>{{$order->customer->full_name}}</p>
                                    </div>
                                    <div class="application__edit">
                                        <p>
                                            @guest
                                                <div class="rating-mini">
                                                    <span class="active"></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                            @endguest
                                            @auth
                                                @if ($order->customer->id === auth()->user()->id)
                                                <div class="add__text cancel_order_button" data-user_id="{{$order->customer->id}}" data-activity_id="{{$event->id}}">
                                                    Отменить
                                                </div>
                                                @else
                                                    <div class="rating-mini">
                                                        <span class="active"></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                        <span></span>
                                                    </div>
                                                @endif
                                            @endauth
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @auth
                        {{-- <x-common.modal id="">
                            @if ($event->currentUserOrder()->status == 0)
                                <h4>Ожидает одобрения</h4>
                            @elseif ($event->currentUserOrder()->status == 1)
                                <h4>Заявка одобрена</h4>
                                <h5>Информация...</h5>
                                <h6>Код - </h6>
                            @elseif ($event->currentUserOrder()->status == 2)
                                <h4>Заявку отклонили</h4>
                            @endif
                        </x-common.modal> --}}
                    @endauth
                </div>

            <button id="share-button">Позвать друзей</button>
        </div>
    </div>
@endsection
