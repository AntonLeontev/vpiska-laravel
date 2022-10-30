@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
    <div class="wrapper">
         <div class="content">
            <div class="authorization">
               <div class="container">
                  <div class="authorization__row">
                     <div class="authorization__logo">
                        <a href="{{ route('home') }}">
                            <img src={{ Vite::image('logo.png') }} alt="logo">
                        </a>
                     </div>
                     <form action="query/register_user.php" method="post" id="register">
                        <div class="registr__form">
                           <div class="registr__name"><input type="text" placeholder="Имя" name="name" required></div>
                           <div class="registr__surname"><input type="text" placeholder="Фамилия" name="surname" required></div>
                           <div class="registr__email"><input type="email" placeholder="E-mail" name="email" required></div>
                           <div class="registr__password"><input type="password" placeholder="Пароль" name="pass" required></div>
                           <div class="registr__repassword"><input type="password" placeholder="Повторите пароль" name="repass" required></div>

                           <div class="registr__testq">
                                {{-- //TODO placeholder, value --}}
                              <input type="text" placeholder=" (ответ цифрой)" name="qq" title="ответ укажите цифрой !" required>
                              <input type="hidden" name="qtype" value="">
                           </div>

                        </div>
                        <div class="registr_confirm">
                           <div class="create__submit__button">
                              <button type="submit">Регистрация</button>
                           </div>
                           <div class="registr__checkbox">
                              <input type="checkbox" id="registe" required>
                              {{-- //TODO href на статику --}}
                              <label for="registe">Согласен на обработку и распространение <a href="">персональных данных</a>, а так же с <a href="">политикой конфиденциальности.</a></label>
                           </div>
                        </div>
                     </form>

                     <div class="title__button ">
                        <div class="autorization__button">
                           <a href="{{ route('login') }}">Уже есть аккаунт? Авторизация</a>
                        </div>
                        <div class="title__button__style ">
                           <a href="auth.php">Регистрация и авторизация по вк</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
      </div>
@endsection
