<x-common.modal id="mobile_select_city">
        <h3>ВЫБЕРИТЕ ВАШ ГОРОД</h3>
        <div class="select__row">
            <div class="select__input">
                <form  class="select_city_form" action="{{route('change_city')}}" method="POST" id="select_cit_mob">
                    @csrf
                    <input type="hidden" value="{{session('city_fias_id')}}" name="city_fias_id" id="city_fias_id">
                    <div class="input__select">
                        <input autocomplete="off" class="select_city_input"
                            name="city_name" type="text" id="select_city_modal_mobile"
                            placeholder="Выберите город" value="{{session('city_name')}}" required>
                    </div>
                    @auth
                    <label class="checkbox" for="make_default">
                            <input type="checkbox" id="make_default" name="make_default">
                            Сделать городом по-умолчанию
                        </label>
                    @endauth
                    <div class="edit__submit__button">
                        <button type="submit">Подтвердить</button>
                    </div>
                </form>
            </div>
        </div>
</x-common.modal>

<div class="navbar">
    <div class="navbar__city">
        <a href="#mobile_select_city">
            <div class="navbar__city__row">
                <div class="navbar__city__image">
                    <img src="{{ Vite::image('icons/loc.svg') }}" alt="city">
                </div>
                <div class="navbar__city__title">
                    <p>{{session('city_name') ?? 'Город'}}</p>
                </div>
            </div>
        </a>
    </div>
    @auth
        <div class="navbar__balance">
            <a href="{{route('balance')}}">
                <div class="navbar__balance__row">
                    <div class="navbar__balance__image">
                        <img src="{{ Vite::image('icons/wallet.svg') }}" alt="balance">
                    </div>
                    <div class="navbar__balance__title">
                        <p>{{auth()->user()->balance}}</p>
                    </div>
                </div>
            </a>
        </div>
    @endauth

    <div class="navbar__logo">
        <a href="/">
            <div class="navbar__logo__row">
                <div class="navbar__logo__image">
                    <img src="{{ Vite::image('icons/vpiska.png') }}" alt="logo">
                </div>
                <div class="navbar__logo__title">
                    <p>VPISKA</p>
                </div>
            </div>
        </a>
    </div>

    @auth
        <div class="navbar__feed">
            <a href="{{route('users.events')}}">
                <div class="navbar__feed__row">
                    <div class="navbar__feed__image">
                        <img src="{{ Vite::image('icons/bell.png') }}" alt="feed">
                    </div>
                    <div class="navbar__feed__title">
                        <p id="weed_mob">0</p>
                    </div>
                </div>
            </a>
        </div>
    @endauth

    <div class="navbar__profile">
        @auth
            <a href="{{route('users.show', auth()->user()->id)}}">
                <div class="navbar__profile__row">
                    <div class="navbar__profile__image">
                        <img src="{{auth()->user()->photo_path}}" alt="profile_photo">
                    </div>
                    <div class="navbar__profile__title">
                        <p>{{auth()->user()->full_name}}</p>
                    </div>
                </div>
            </a>
        @endauth

        @guest
            <a href="#register_2">
                <div class="navbar__profile__row">
                    <div class="navbar__profile__title">
                        <p>Войти</p>
                    </div>
                </div>
            </a>
        @endguest
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="footer__row">
            <div class="footer__link">
                <ul class="footer__list">
                    <li><a href="{{route('offer')}}">Публичная оферта</a></li>
                    <li><a href="{{route('terms')}}">Пользовательское соглашение</a></li>
                    <li><a href="{{route('policy')}}">Политика конфиденциальности</a></li>
                    <li><a href="{{route('payment-security')}}">Безопасность платежей</a></li>
                </ul>
            </div>
            <div class="footer__apps">
                <div class="apps">
                    <h4 class="apps__title">Скоро в:</h4>
                    <div class="apps__images">
                        <div class="apps__playmarket">
                            <a href="#">
                                <img src="{{ Vite::image('icons/logoPlay.png') }}" alt="playmarket">
                            </a>
                        </div>
                        <div class="apps__appstore">
                            <a href="#">
                                <img src="{{ Vite::image('icons/logoStore1.png') }}" alt="appstore">
                            </a>
                        </div>
                    </div>
                    <div class="visa">
                        <img src="{{ Vite::image('payment.png') }}" alt="visa mastercard mir" width="200px">
                    </div>
                </div>
            </div>
            <div class="footer__info">
                <ul class="footer__list">
                    <li>
                        <p>All rights reserved</p>
                    </li>
                    <li>
                        <p>Perfecto Group LLC</p>
                    </li>
                    <li>
                        <p>© 2021 - 2022</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
