<x-common.modal id="select_city">
    <h3 class="close__title">Выберите ваш город</h3>
    <div class="select__row">
        <div class="select__input">
            {{-- //TODO form action --}}
            <form action="../assets/query/update_city.php" method="POST" id="select_cit">
                <div class="input__select">
                    <input autocomplete="off" list="modal_select_city" name="modal_select_city" type="text"
                        id="select_city_modal" oninput="select_city_modal_header()" placeholder="Выберите город"
                        required>
                </div>
                <input type="hidden" value="" name="u_id">
                <ul id="modal_select_city">

                </ul>
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
                        <a href="/assets/vk.php">
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
                    <?php
                    $nums = ['один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'];
                    $num1 = rand(1, 9);
                    $num2 = rand(1, 9);
                    $qtype = $num1 . $num2;
                    $qq = $nums[$num1 - 1] . ' + ' . $nums[$num2 - 1];
                    ?>
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
                                    <option value="0">Мужской</option>
                                    <option value="1">Женский</option>
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

                                {{-- <input type="text" placeholder="<?php echo $qq; ?>" name="qq"
                                    title="ответ укажите цифрой !" required>
                                <input type="hidden" name="qtype" value="<?php echo $qtype; ?>"> --}}
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
                            <a href="/assets/vk.php ">
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
                        @auth
                            <h4>Город</h4>
                        @endauth
                        @guest
                            <h4>Выберите город</h4>
                        @endguest
                    </a>
                </div>

            </div>
            @auth
                <a href="../assets/balance.php">
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
                <a href="../assets/weed.php">
                    <div class="header__message">
                        <div class="message__row">
                            <div class="message__status">
                                <p id="weed">notif</p>
                            </div>
                            <div class="message__img"><img src="{{ Vite::image('icons/weed.png') }}" alt="message">
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
                            {{-- //TODO add user photo link --}}
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
