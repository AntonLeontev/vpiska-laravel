@extends('layouts.app')

@section('title')
    Создание мероприятия
@endsection

@section('content')
    <div class="content">

			@guest
					<x-common.alert>Войдите чтобы создать новое мероприятие</x-common.alert>
			@endguest
			@auth
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
                            <p><a href="/"><img src="{{Vite::image('icons/close.svg')}}" alt="close"></a></p>
                        </div>
                    </div>

                    <div class="activity__form activity__form--mobile">

                        <form action="{{route('events.store')}}" method="POST" enctype="multipart/form-data" id=""
                            autocomplete="disabled">
                            <fieldset 
															@unlessuserActivated(auth()->user())
																disabled
															@enduserActivated

															@hasTooManyEvents(auth()->user())
																disabled
															@endhasTooManyEvents
														>
                                <div class="activity__location">

                                    <div class="info__time">
                                        <div class="time__title">
                                            <p>Дата и время меропрития</p>
                                        </div>
                                        <div class="time__input">
                                            <div class="input__date">
                                                <input type="date" id="create_date" name="create_date"
                                                    placeholder="31/12/2022" required>
                                            </div>
                                            <div class="input__time">
                                                <input type="text" id="create_time" class="create_time"
                                                    name="create_time" placeholder="00:00 - 18:00" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="button_next" onclick="create_activity_1()">
                                        <p>Далее</p>
                                    </div>

                                </div>
                                <div class="activity__info">

                                    <div class="location__title">
                                        <p>Адрес мероприятия</p>
                                    </div>
                                    <div class="location__input">
                                        <div class="input__city">
                                            <input autocomplete="off" list="city_create_mob" type="text"
                                                id="create_city_mob" name="city_create_mob" placeholder="Город"
                                                oninput="create_city_aj_mob()" required>
                                        </div>
                                        <ul id="city_create_mob">
                                        </ul>
                                        {{-- //TODO City tips --}}
                                        <div class="input__street">
                                            <input type="text" autocomplete="off" id="create_street" name="create_street"
                                                placeholder="Улица" required>
                                        </div>
                                        <div class="input__home">
                                            <input type="text" autocomplete="off" id="create_home" name="create_home"
                                                placeholder="Дом" required>
                                        </div>

                                    </div>


                                    <div class="button_next" onclick="create_activity_2()">
                                        <p>Далее</p>
                                    </div>

                                </div>
                                <div class="activity__description">

                                    <div class="info__users">
                                        <div class="users__title">
                                            <p>Укажите максимальное количество участников мероприятия</p>
                                        </div>
                                        <div class="users__input">
                                            <div class="input__number">
                                                <input type="number" id="create_number" name="create_number" min="1"
                                                    max="30" placeholder="Кол-во человек" required>
                                            </div>
                                            <div class="input__price">
                                                <span>Цена за вход с каждого участника</span>
                                                <input type="number" id="create_price" name="create_price" min="0"
                                                    max="14999" placeholder="Цена" required>
                                                <span>При входе на мероприятие, Участники сообщают Создателю цифровой код,
                                                    который можно активировать на странице <a
                                                        href="{{route('balance')}}">баланса</a> и
                                                    вывести средства на Ваш счёт</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="button_next" onclick="create_activity_3()">
                                        <p>Далее</p>
                                    </div>

                                </div>




                                <div class="loader__none" id="loader">
                                    <div class="inner one"></div>
                                    <div class="inner two"></div>
                                    <div class="inner three"></div>
                                </div>

                                <div class="activity__number">

                                    <div class="decsription__title">
                                        <div class="description__main__title">
                                            <p>Заполните описание мероприятия и добавьте изображения о нем</p>
                                        </div>
                                        <div class="description__text">
                                            <div class="description__textarea">
                                                <textarea name="create_description" id="create_description" placeholder="Описание мероприятия"></textarea>
                                            </div>
                                        </div>
                                        <div class="description__additional">
                                            <p>Необязательно к заполнению</p>
                                        </div>
                                    </div>
                                    <div class="description__button">
                                        {{-- <style>
                                            .description__gallery {
                                                display: unset;
                                            }
                                        </style> --}}
                                        <div class="description__gallery">
                                            <label for="js-file">
                                                <div class="description__add">
                                                    <div class="add__image"><img src="{{Vite::image('icons/plus.svg')}}"
                                                            alt="add"></div>
                                                    <div class="add__text">
                                                        <p><b>Добавить фото</b></p>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <input id="js-file" type="file" name="file[]"
                                                        class="memememememe" multiple accept=".jpg,.jpeg,.png">
                                                </div>
                                            </label>
                                            <script>
                                                $("#js-file-vvvoff").change(function() {
                                                    if (window.FormData === undefined) {
                                                        alert("В вашем браузере загрузка файлов не поддерживается");
                                                    } else {
                                                        let $fileUpload = $("input[type=file]");
                                                        if (parseInt($fileUpload.get(0).files.length) > 5) {
                                                            alert("Максимальное число загружаемых файлов за раз не более 5-ти");
                                                        } else {
                                                            let formData = new FormData();
                                                            $.each($("#js-file")[0].files, function(key, input) {
                                                                formData.append("file[]", input);
                                                            });
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "/upload_image.php",
                                                                cache: false,
                                                                contentType: false,
                                                                processData: false,
                                                                data: formData,
                                                                dataType: "json",
                                                                beforeSend: function() {
                                                                    $('#loader').addClass('loader');
                                                                },
                                                                success: function(msg) {
                                                                    $('#loader').removeClass('nnn');
                                                                    msg.forEach(function(row) {
                                                                        if (row.error == "") {
                                                                            $("#js-file-list").append(row.data);
                                                                        } else {
                                                                            alert(row.error);
                                                                        }
                                                                    });
                                                                    $("#js-file").val("");
                                                                }
                                                            });
                                                        }
                                                    }
                                                });

                                                function remove_img(target) {
                                                    $(target).parent().remove();
                                                }
                                            </script>

                                            <div class="img__list" id="js-file-list"></div>
                                        </div>

                                    </div>

                                    <div class="button_next" onclick="create_activity_4()">
                                        <p>Далее</p>
                                    </div>

                                    <!--   <div class="button_next" onclick="create_activity_4()"><p>Далее</p></div>   -->
                                </div>
                                <div class="actvity__submit">

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
                                            <input type="text" name="create_phone" class="create_phone"
                                                id="create_phone" placeholder="+7 (___) ___-__-__" required>
                                        </div>
                                    </div>
                                    <div class="submit__button">
                                        <div class="create__submit__button">
                                            <button type="submit">Подтвердить</button>
                                        </div>
                                    </div>


                                    <div class="submit__checkbox">
                                        <input type="checkbox" id="rules" name="scales" required checked>
                                        <label class="checkbox" for="rules">Согласен с <a
                                                href="{{route('policy')}}">политикой
                                                конфидециальности</a>, а так же <a
                                                href="{{route('processing')}}">обработку</a>
                                            и <a
                                                href="{{route('dissemination')}}">распространение</a>
                                            персональных данных.</label>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                    </div>



                    <div class="activity__form activity__form--desktop">


                        <form action="{{route('events.store')}}" method="POST" enctype="multipart/form-data"
                            id="" autocomplete="disabled">
                            <fieldset 
															@unlessuserActivated(auth()->user())
																disabled
															@enduserActivated

															@hasTooManyEvents(auth()->user())
																disabled
															@endhasTooManyEvents
														>
                                <div class="activity__location">
                                    <div class="location__title">
                                        <p>Адрес мероприятия</p>
                                    </div>
                                    <div class="location__input">
                                        <div class="input__city"><input autocomplete="off" list="city_create"
                                                type="text" id="create_city" name="create_city" placeholder="Город"
                                                oninput="create_city_aj()" required></div>
                                        <ul id="city_create">
                                        </ul>
                                        {{-- <script>
                                            function create_city_aj() {
                                                $('#city_create').show();
                                                let create_city = $("#create_city").val();
                                                $.ajax({
                                                    type: "POST",
                                                    url: "query/select_city_create.php",
                                                    cache: false,
                                                    data: {
                                                        select_city: create_city
                                                    },
                                                    success: function(result_city) {
                                                        $("#city_create").empty();
                                                        $("#city_create").append(result_city);
                                                    }
                                                });
                                            }

                                            function sel_cit_cre(data_cre) {
                                                $('#create_city').val(data_cre);
                                                $('#city_create').hide();
                                            }
                                        </script> --}}
                                        <div class="input__street"><input type="text" autocomplete="off"
                                                id="create_street" name="create_street" placeholder="Улица" required>
                                        </div>
                                        <div class="input__home"><input type="text" autocomplete="off"
                                                id="create_home" name="create_home" placeholder="Дом" required></div>
                                        <div class="button_next" onclick="create_activity_1()">
                                            <p>Далее</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="activity__info">
                                    <div class="info__users">
                                        <div class="users__title">
                                            <p>Кол-во человек и цена мероприятия</p>
                                        </div>
                                        <div class="users__input">
                                            <div class="input__number"><input type="number" id="create_number"
                                                    name="create_number" min="1" max="30"
                                                    placeholder="Кол-во человек" required></div>
                                            <div class="input__price"><input type="number" id="create_price"
                                                    name="create_price" min="0" max="14999" placeholder="Цена"
                                                    required></div>
                                        </div>
                                    </div>
                                    <div class="info__time">
                                        <div class="time__title">
                                            <p>Дата и время меропрития</p>
                                        </div>
                                        <div class="time__input">
                                            <div class="input__date"><input type="date" autocomplete="off"
                                                    id="create_date" name="create_date" placeholder="дд/мм/гггг"
                                                    required></div>
                                            <div class="input__time"><input type="text" class="create_time"
                                                    id="create_time" name="create_time" placeholder="00:00 - 18:00"
                                                    required></div>
                                        </div>
                                    </div>
                                    <div class="button_next" onclick="create_activity_2()">
                                        <p>Далее</p>
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
                                                    <div class="add__image"><img src="{{Vite::image('icons/plus.svg')}}"
                                                            alt="add"></div>
                                                    <div class="add__text">
                                                        <p><b>Добавить фото</b></p>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                </div>
                                            </label>
                                            <script>
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
                                                                formData.append("file[]", input);
                                                            });
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "/upload_image.php",
                                                                cache: false,
                                                                contentType: false,
                                                                processData: false,
                                                                data: formData,
                                                                dataType: "json",
                                                                beforeSend: function() {
                                                                    $('#loader').addClass('loader');
                                                                },
                                                                success: function(msg) {
                                                                    console.log(msg);
                                                                    $('#loader').removeClass('nnn');
                                                                    msg.forEach(function(row) {
                                                                        console.log('+');
                                                                        console.log(row);
                                                                        if (row.error == "") {
                                                                            $("#js-file-list2").append(row.data);
                                                                            $("#js-file-list").append(row.data);
                                                                        } else {
                                                                            alert(row.error);
                                                                        }
                                                                    });
                                                                    $("#js-file").val("");
                                                                }
                                                            });

                                                        }
                                                    }
                                                });

                                                function remove_img(target) {
                                                    $(target).parent().remove();
                                                }
                                            </script>
                                            <style>
                                                .img__list {
                                                    display: unset !important;
                                                }
                                            </style>
                                            <div class="img__list" id="js-file-list2"></div>
                                        </div>

                                        <div class="description__text">
                                            <div class="description__textarea">
                                                <textarea name="create_description" id="create_description" placeholder="Описание мероприятия"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="button_next" onclick="create_activity_3()">
                                        <p>Далее</p>
                                    </div>
                                </div>

                                <div class="loader__none" id="loader">
                                    <div class="inner one"></div>
                                    <div class="inner two"></div>
                                    <div class="inner three"></div>
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
                                        <div class="input__phone"><input type="text" name="create_phone"
                                                class="create_phone" placeholder="+7 (___) ___-__-__" required></div>
                                    </div>
                                    <div class="submit__button">
                                        <div class="create__submit__button">
                                            <button type="submit">Подтвердить</button>
                                        </div>
                                    </div>
                                    <!--   <div class="button_next" onclick="create_activity_4()"><p>Далее</p></div>   -->
                                </div>
                                <div class="actvity__submit">
                                    <div class="submit__checkbox">
                                        <input type="checkbox" id="rules" name="scales" required checked>
                                        <label class="checkbox" for="rules">Согласен с <a
                                                href="{{route('policy')}}">политикой
                                                конфидециальности</a>, а так же <a
                                                href="{{route('processing')}}">обработку</a>
                                            и <a
                                                href="{{route('dissemination')}}">распространение</a>
                                            персональных данных.</label>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input[type=date]').focusout(function() {



            //alert('ok');
            var dateB = moment();
            var dateC = moment($(this).val());

            // console.log(dateC.year());
            if (dateC.year() < moment().year()) {
                // return ;
            }

            var df = dateC.diff(dateB, 'days');

            console.log('Разница в ', dateC.diff(dateB, 'days'), 'дней');

            if (df < 0) {

                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка...',
                    text: 'Дата должна быть миниум сегодняшней',
                })
                $(this).val(moment().format('YYYY MM DD'));
            }

            if (df > 3) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка...',
                    text: 'Дата должна быть не более чем на 3 дня больше сегодняшней',
                })
                $(this).val(moment().format('YYYY MM DD'));



            }

        })
    </script>
		@endauth
@endsection
