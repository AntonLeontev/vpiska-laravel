<x-common.modal id="select_city">
    <h3 class="close__title">Выберите ваш город</h3>
    <div class="select__row">
        <div class="select__input">
            <form action="{{route('change_city')}}"
            method="POST" id="select_cit" class="select_city_form">
            @csrf
                <input type="hidden" value="{{session('city_fias_id')}}" name="city_fias_id" id="city_fias_id">
                <div class="input__select">
                    <input autocomplete="off" list="modal_select_city" name="city_name" type="text"
                        id="select_city_input" value="{{session('city_name')}}" class="select_city_input" placeholder="Выберите город" required>
                </div>
                @auth
                    <input type="checkbox" id="make_default" name="make_default">
                    <label class="checkbox" for="make_default">Сделать городом по-умолчанию</label>
                @endauth
                <div class="edit__submit__button">
                    <button type="submit">Подтвердить</button>
                </div>
            </form>
        </div>
    </div>
</x-common.modal>
@guest
    <x-common.modal id="register_2">
        <div class="tabs">

            <input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
            <label for="tab-btn-1">Авторизация</label>

            <input type="radio" name="tab-btn" id="tab-btn-2" value="">
            <label for="tab-btn-2">Регистрация</label>

            <div id="content-1">

                <form action="/login" method="post" id="login" class="form_auth">
                    @csrf
                    <div class="auth__form">
                        <div class="auth__email">
                            <input type="email" placeholder="E-mail" name="email" required>
                        </div>
                        <div class="auth__password">
                            <input type="password" placeholder="Пароль" name="password" required>
                        </div>
                    </div>
                    <div class="auth_confirm">
                        <div class="create__submit__button">
                            <button type="submit">Подтвердить</button>
                        </div>
                    </div>
                    <div class="title__button">
                        <a href="{{route('vk-redirect')}}">
                            <div class="title__button__style">
                                <div class="style__image">
                                    <img src="{{ Vite::image('vk.svg') }}" alt="auth__button">
                                </div>
                                <div class="style__text">
                                    <p>Авторизация через Вконтакте</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="auth__remember">
                        <a href="#recovery_password">Забыли пароль?</a>
                    </div>
                </form>
            </div>
            <div id="content-2">
                <div class="authorization__row">
                    <form action="/register" method="post" id="register" class="form_auth">
                        @csrf
                        <div class="registr__form">
                            <div class="registr__name">
                                <input type="text" placeholder="Имя" name="first_name" required>
                            </div>
                            <div class="registr__surname">
                                <input type="text" placeholder="Фамилия" name="last_name">
                            </div>
                            <div class="registr__sex">
                                <select name="sex" required>
                                    <option disabled selected>Выберете ваш пол</option>
                                    <option value="male">Мужской</option>
                                    <option value="female">Женский</option>
                                </select>
                            </div>
                            <div class="registr__email">
                                <input type="email" placeholder="E-mail" name="email" required>
                            </div>
                            <div class="registr__password">
                                <input type="password" placeholder="Пароль" name="password" required>
                            </div>
                            <div class="registr__repassword">
                                <input type="password" placeholder="Повторите пароль" name="password_confirmation" required>
                            </div>
                            <div class="registr__testq">

                            </div>
                        </div>
                        <div class="registr_confirm">
                            <div class="submit__checkbox">
                                <input type="checkbox" id="rules" name="scales" required checked>
                                <label class="checkbox" for="rules">
                                    Согласен с
                                    <a href="{{ route('policy') }}">
                                        политикой конфидециальности
                                    </a>, а так же
                                    <a href="{{ route('processing') }}">обработку</a>
                                    и
                                    <a href="{{ route('dissemination') }}">распространение</a> персональных данных.
                                </label>
                            </div>
                            <div class="create__submit__button">
                                <button id="register" type="submit">Подтвердить</button>
                            </div>
                        </div>
                        <div class="title__button ">
                            <a href="{{route('vk-redirect')}}">
                                <div class="title__button__style ">
                                    <div class="style__image ">
                                        <img src="{{ Vite::image('vk.svg') }}" alt="auth__button ">
                                    </div>
                                    <div class="style__text ">
                                        <p>Регистрация через Вконтакте</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-common.modal>
    <x-common.modal id="recovery_password">
        <h3 class="close__title">Восстановление пароля</h3>
        <div class="select__row">
            <div class="select__input">
                <form action="{{ route('password.email') }}" method="POST" class="form_auth" id="rec_password">
                    @csrf
                    <div class="res_password">
                        <input type="email" placeholder="E-mail" name="email" required="">
                    </div>
                    <div class="edit__submit__button">
                        <button type="submit">Восстановить</button>
                    </div>
                </form>
            </div>
        </div>
    </x-common.modal>
@endguest
<div class="header">
    <div class="container">
        <div class="header__row">
            <div class="header__location">
                <div class="location__img"><img src="{{ Vite::image('icons/loc.svg') }}" alt="location"></div>
                <div class="location__title">
                    <a href="#select_city">
                        <h4>{{session('city_name') ?? 'Выберите город'}}</h4>
                    </a>
                </div>

            </div>
            @auth
                <a href="{{route('balance')}}">
                    <div class="header__balance">
                        <div class="balance__row">
                            <div class="balance__status">
                                <p>{{ auth()->user()->balance }}</p>
                            </div>
                            <div class="balance__img"><img src="{{ Vite::image('icons/wallet.svg') }}" alt="balance">
                            </div>
                        </div>
                    </div>
                </a>
            @endauth
            <a href="/">
                <div class="header__logo">
                    <img src="{{ Vite::image('logo.png') }}" width="200" height="80" alt="logo" />
                </div>
            </a>
            @auth
                <a href="{{ route('users.events') }}">
                    <div class="header__message">
                        <div class="message__row">
                            <div class="message__status">
                                <p id="weed">{{ auth()->user()->notifications }}</p>
                            </div>
                            <div class="message__img">
                                <img src="{{ Vite::image('icons/bell.png') }}" alt="message">
                            </div>
                        </div>
                    </div>
                </a>
            @endauth
            <div class="header__profile">
                @auth
                    <a href="/users/{{ auth()->user()->id }}">
                        <div class="profile__row">
                            <div class="profile__name">
                                <p>{{ auth()->user()->first_name }}</p>
                            </div>
                            <div class="profile__img"><img src="{{ auth()->user()->photo_path }}" alt="profile_photo">
                            </div>
                        </div>
                    </a>
                @endauth
                @guest
                    <a href="#register_2">
                        <div class="profile__row">
                            <div class="profile__name">
                                <p>Войти</p>
                            </div>
                        </div>
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>
