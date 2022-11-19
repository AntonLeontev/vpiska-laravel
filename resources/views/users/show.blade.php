@extends('layouts.app')

@section('title', $user->full_name)


@section('content')
    <div class="content">
        @auth
            @if (auth()->user()->id === $user->id)
                <x-common.modal id="edit_profile">
                    <div class="edit__profile__title">
                        <p>Редактирование профиля</p>
                    </div>
                    <div class="edit__profile">
                        <form action="{{ route('users.update', $user->id) }}" method="post">
                            @csrf
                            <div class="edit__name__input"><input type="text" placeholder="Ваше имя" name="first_name"
                                    value="{{ $user->first_name }}" required></div>
                            <div class="edit__surname__input"><input type="text" placeholder="Ваша фамилия" name="last_name"
                                    value="{{ $user->last_name }}"></div>
                            <input type="hidden" name="city_fias_id" value="{{ $user->city_fias_id }}">
                            <div class="edit__city__input"><input class="select_city_input" type="text"
                                    placeholder="Ваш город" name="city_name" value="{{ $user->city_name }}"></div>
                            <div class="edit__date__input"><input type="date" placeholder="Ваша дата рождения"
                                    name="birth_date" value="{{ $user->birth_date }}"></div>
                            <div class="edit__submit__button"><button type="submit">Подтвердить</button></div>
                        </form>
                    </div>
                </x-common.modal>
            @endif
        @endauth

        <div class="cabinet">
            <div class="container">
                <div class="cabinet__row">
                    <div class="cabinet__title">
                        @auth
                            @if (auth()->user()->id === $user->id)
                                <div class="cabinet__title__settings">
                                    <a href="#edit_profile">
                                        <img src="{{ Vite::image('icons/settings.png') }}" alt="settings">
                                    </a>
                                </div>
                            @endif
                        @endauth

                        <div class="cabinet__title__text">ПРОФИЛЬ</div>
                        <a href="/">
                            <div class="cabinet__title__close">
                                <img src="{{ Vite::image('icons/close.svg') }}" alt="close">
                            </div>
                        </a>
                    </div>

                    <div class="cabinet__user">
                        <div class="all_user_cabinet">
                            <div class="user__1">
                                <div class="user__block">
                                    <div class="user__photo">
                                        <img src="{{ $user->photo_path }}" alt="фото профиля">
                                    </div>
                                    <div class="user__name__mobile">
                                        <p><b>{{ $user->full_name }}</b></p>
                                    </div>
                                </div>
                                <div class="user__info">
                                    <div class="user__name">
                                        <p><b>{{ $user->full_name }}</b></p>
                                    </div>
                                    <div class="user__birthday">
                                        <p><b>Дата рождения:</b> {{ $user->birth_date }}</p>
                                    </div>
                                    <div class="user__sex">
                                        <p><b>Пол:</b> {{ $user->sex }}</p>
                                    </div>
                                    <div class="user__sex">
                                        <p><b>Город:</b> {{ $user->city_name }}</p>
                                    </div>

                                    <div class="user__sex">
                                        <p><b>Рейтинг:</b> </p>
                                    </div>

                                </div>
                            </div>
                            <div class="user__2">
                                @auth
                                    @if (auth()->user()->id === $user->id)
                                        <div class="cabinet__title__settings__pc">
                                            <a href="#edit_profile">
                                                <img src="{{ Vite::image('icons/settings.png') }}" alt="settings">
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                            <div class="user__3">
                                @auth
                                    @if (auth()->user()->id === $user->id)
                                        <div class="user__rating">
                                            <form class="form_logout" action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <div class="user__exit">
                                                    <button type='submit'>
                                                        <p>Выйти из профиля</p>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>

                    <div class="cabinet__gallery">
                        <div class="gallery__title">
                            <p>Ваша галерея</p>
                        </div>
                        <div class="gallery__main">
                            @if ($user->images->count() <= 0)
                                <div class="gallery__add gallery__add_empty">
                                    <div class="gallery__add__text">
                                        <p><b>Фотографии отсутсвуют</b></p>
                                    </div>
                                </div>
                            @else
                                @foreach ($user->images as $image)
                                    <div class="gallery__card">
                                        <img src="/storage/{{$image->path}}" alt="profile photo">
                                        @auth
                                            @if (auth()->user()->id === $user->id)
                                                <button class="btn__image-delete" data-action="{{route('userImage.destroy', $image->id)}}" data-token="{{csrf_token()}}" data-user_id="{{$user->id}}">
                                                    <img src="{{ Vite::image('icons/delete.svg') }}" alt="delete">
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                @endforeach
                            @endif

                            @auth
                                @if (auth()->user()->id === $user->id)
                                    <label for="js-file">
                                        <div class="gallery__add">
                                            <div class="add__image">
                                                <img src="{{ Vite::image('icons/create.png') }}" alt="add">
                                            </div>
                                            <div class="gallery__add__text">
                                                <p><b>Добавить фото</b></p>
                                            </div>
                                        </div>
                                        <x-common.form class="form-row" action="{{route('userImage.store')}}" method="POST" enctype="multipart/form-data">
                                            <input id="js-file" type="file" class="input_file_user hidden" name="images[]" multiple>
                                            <input type="hidden" id="js-user_id" name="user_id" value="{{$user->id}}">
                                        </x-common.form>
                                    </label>
                                @endif
                            @endauth

                        </div>
                    </div>
                    @auth
                        @if (auth()->user()->id === $user->id)
                            <div class="user__rating__mobile">
                                <form class="form_logout" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <div class="user__exit__mobile">
                                        <button type='submit'>
                                            <p>Выйти из профиля</p>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <div class="reviews__title">
                        <p>Отзывы</p>
                    </div>
                    {{-- //TODO Reviews --}}



                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
