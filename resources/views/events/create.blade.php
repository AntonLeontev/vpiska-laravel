@extends('layouts.app')

@section('title')
    Создание мероприятия
@endsection

@section('content')
    <div class="content">

        @unlessuserActivated(auth()->user())
            <x-common.alert>Ваш аккаунт не активирован. Вы не можете создать мероприятие</x-common.alert>
        @enduserActivated

        @hasTooManyEvents(auth()->user())
            <x-common.alert>У вас уже есть активное мероприятие. Вы не можете создать новое</x-common.alert>
        @endhasTooManyEvents




        <div class="activity">
            <div class="container">
                <div class="activity__row">
                    <div class="activity__title">
                        <div class="title__info">
                            <p><b>Создание</b></p>
                        </div>
                        <div class="title__info__mobile">
                            <p><b>Создание</b></p>
                        </div>
                        <div class="title__close">
                            <p><a href="/"><img src="{{ Vite::image('icons/close.svg') }}" alt="close"></a></p>
                        </div>
                    </div>

                    <x-common.form class="form-row" action="{{route('temporaryImage.store')}}" method="POST" enctype="multipart/form-data">
                        <input id="js-file" type="file" class="input_file_temp hidden" name="images[]" multiple>
                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                    </x-common.form>



                    <div class="activity__form activity__form--desktop">

                    @userActivated(auth()->user()) 
                        @unlesshasTooManyEvents(auth()->user())  
                            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data"
                                autocomplete="disabled" class="form_event-create">
                                @csrf
                                <input type="hidden" name="creator_id" value="{{auth()->user()->id}}">
                                <div class="activity__location">
                                    <div class="location__title">
                                        <p>Адрес мероприятия</p>
                                    </div>
                                    <div class="location__input">
                                        <input type="hidden" name="utc_offset">
                                        <input type="hidden" name="city_fias_id">
                                        <div class="input__city">
                                            <input class="select_city_input-desc" autocomplete="off" list="city_create"
                                            type="text" id="select_city_input" name="city_name" placeholder="Город"
                                            required>
                                        </div>
                                        <input type="hidden" name="street_fias_id">
                                        <input type="hidden" name="street_type">
                                        <div class="input__street">
                                            <input class="select_street_input-desc" type="text" autocomplete="off" id="select_street_input" name="street" placeholder="Улица" required>
                                        </div>
                                        <input type="hidden" name="building_fias_id">
                                        <div class="input__home">
                                            <input class="select_building_input-desc" type="text" autocomplete="off" id="select_building_input" name="building" placeholder="Дом" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="activity__info">
                                    <div class="info__users">
                                        <div class="users__title">
                                            <p>Кол-во человек и цена мероприятия</p>
                                        </div>
                                        <div class="users__input">
                                            <input type="hidden" name="fee" value="{{config('vpiska.fees.default', 70)}}">
                                            <div class="input__number"><input type="number" id="create_number"
                                                    name="max_members" min="2" max="30"
                                                    placeholder="Кол-во человек" required></div>
                                            <div class="input__price"><input type="number" id="create_price"
                                                    name="price" min="0" max="14999" placeholder="Цена"
                                                    required></div>
                                        </div>
                                    </div>
                                    <div class="info__time">
                                        <div class="time__title">
                                            <p>Дата и время меропрития</p>
                                        </div>
                                        <div class="time__input">
                                            <div class="input__date"><input type="date" autocomplete="off"
                                                    id="create_date" name="date" placeholder="дд/мм/гггг"
                                                    required></div>
                                            <div class="input__time"><input type="text" class="create_time"
                                                    id="create_time-desktop" name="time" placeholder="19:00 - 23:00"
                                                    required></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="activity__description">
                                    <div class="decsription__title">
                                        <div class="description__main__title">
                                            <p>Заполните описание мероприятия и добавьте изображения о нем</p>
                                        </div>
                                        <div class="description__additional">
                                            <p>Необязательно к заполнению</p>
                                        </div>
                                    </div>
                                    <div class="description__button">
                                        <div class="description__gallery">
                                            <label for="js-file">
                                                <div class="description__add">
                                                    <div class="add__image">
                                                        <img src="{{ Vite::image('icons/plus.svg') }}" alt="add">
                                                    </div>
                                                    <div class="add__text">
                                                        <p><b>Добавить фото</b></p>
                                                    </div>
                                                </div>
                                            </label>
                                            
                                        </div>
                                        
                                        <div class="description__text">
                                            <div class="description__textarea">
                                                <textarea name="description" id="create_description" placeholder="Описание мероприятия"></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="img__list gallery__main" id="js-file-list2">
                                        <div class="gallery__card gallery__card_template">
                                            <img src="" alt="event photo">
                                                <div class="btn__image-delete">
                                                    <img src="{{ Vite::image('icons/delete.svg') }}" alt="delete">
                                                </div>
                                        </div>
                                        @if (auth()->user()->tempImages->count() > 0)
                                            @foreach (auth()->user()->tempImages as $image)
                                                <div class="gallery__card">
                                                    <img src="/storage/{{$image->path}}" alt="event photo">
                                                        <div class="btn__image-delete" data-action="{{route('temporaryImage.destroy', $image->id)}}" data-token="{{csrf_token()}}" data-user_id="{{$image->user_id}}">
                                                            <img src="{{ Vite::image('icons/delete.svg') }}" alt="delete">
                                                        </div>
                                                </div>
                                                <input type="hidden" name="images[]" value="{{$image->path}}">
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="activity__number">
                                    <div class="number__title">
                                        <div class="number__main__title">
                                            <p>Введите телефон для связи с вами</p>
                                        </div>
                                        <div class="number__additional">
                                            <p>Его увидят только одобренные Вами пользователи</p>
                                        </div>
                                    </div>
                                    <div class="number__input">
                                        <div class="input__phone">
                                            <input type="text" name="user_phone" class="create_phone" 
                                            placeholder="+7 (___) ___-__-__" 
                                            id="phone_desktop" required></div>
                                    </div>
                                    <div class="submit__button">
                                        <div class="create__submit__button">
                                            <button type="submit">Подтвердить</button>
                                        </div>
                                    </div>
                                    <!--   <div class="button_next" onclick="create_activity_4()"><p>Далее</p></div>   -->
                                </div>
                                <x-common.checkbox class="submit__checkb" name="scales" check="true">
                                    Согласен с 
                                    <a href="{{ route('policy') }}">политикой конфидециальности</a>,
                                    а так же на <a href="{{ route('processing') }}">обработку</a>
                                    и <a href="{{ route('dissemination') }}">распространение</a>
                                    персональных данных
                                </x-common.checkbox>
                            </form>
                        @endhasTooManyEvents
                    @enduserActivated
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
