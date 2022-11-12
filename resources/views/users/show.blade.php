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
                        <form action="{{route('users.update', $user->id)}}" method="post">
                            @csrf
                            <div class="edit__name__input"><input type="text" placeholder="Ваше имя" name="first_name" value="{{ $user->first_name }}" required></div>
                            <div class="edit__surname__input"><input type="text" placeholder="Ваша фамилия" name="last_name" value="{{ $user->last_name }}"></div>
                            <input type="hidden" name="city_fias_id" value="{{$user->city_fias_id}}">
                            <div class="edit__city__input"><input class="select_city_input" type="text" placeholder="Ваш город" name="city_name" value="{{ $user->city_name }}"></div>
                            <div class="edit__date__input"><input type="date" placeholder="Ваша дата рождения" name="birth_date" value="{{$user->birth_date}}"></div>
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
                                        <img src="{{$user->photo_path}}" alt="фото профиля">
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
                                        <p><b>Дата рождения:</b> {{$user->birth_date}}</p>
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
                                            <form class="form_logout" action="/logout" method="POST">
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

                            <div class="gallery__add">
                                <div class="gallery__add__text">
                                    <p><b>Фотографии отсутсвуют</b></p>
                                </div>
                            </div>

                            @auth
                                @if (auth()->user()->id === $user->id)
                                    <div class="gallery__card">
                                        <img src="/uploads/tmp/" alt="profile photo">
                                        <a href="../assets/query/delete_photo.php?id=&page=">
                                            <img src="{{ Vite::image('icons/delete.svg') }}" alt="delete">
                                        </a>
                                    </div>
                                    <label for="js-file">
                                        <div class="gallery__add">
                                            <div class="add__image"><img src="{{ Vite::image('icons/create.png') }}"
                                                    alt="add"></div>
                                            <div class="gallery__add__text">
                                                <p><b>Добавить фото</b></p>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <input id="js-file" type="file" name="file[]" class="memememememe" multiple
                                                accept=".jpg,.jpeg">
                                        </div>
                                    </label>
                                    <script>
																			// TODO Photo upload
                                        $("#js-file").change(function() {
                                            if (window.FormData === undefined) {
                                                alert("В вашем браузере загрузка файлов не поддерживается");
                                            } else {
                                                let $fileUpload = $("input[type=file]");
                                                if (parseInt($fileUpload.get(0).files.length) > 5) {
                                                    alert("Максимальное число загружаемых файлов за раз не более 5-ти");
                                                } else {
                                                    let formData = new FormData();
                                                    $.each($("#js-file")[0].files, function(key, input) {
                                                        let iduser = "{{ $user->id }}";
                                                        formData.append("file[]", input);
                                                        formData.append("userId", iduser);
                                                    });
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "/profile_upload.php",
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false,
                                                        data: formData,
                                                        dataType: "json",
                                                        success: function(msg) {
                                                            location.reload();
                                                        }
                                                    });
                                                }
                                            }
                                        });

                                        function remove_img(target) {
                                            $(target).parent().remove();
                                        }
                                    </script>
                                @endif
                            @endauth

                        </div>
                    </div>
                    @auth
                        @if (auth()->user()->id === $user->id)
                            <div class="user__rating__mobile">
                                <a href="{{route('logout')}}">
                                    <div class="user__exit__mobile">
                                        <button>
                                            <p>Выйти из профиля</p>
                                        </button>
                                    </div>
                                </a>
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
