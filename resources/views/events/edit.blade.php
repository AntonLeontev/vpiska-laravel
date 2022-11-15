@extends('layouts.app')

@section('title')
    Редактирование мероприятия
@endsection

@section('content')
    <div class="content">


        <div class="activity">
            <div class="container">
                <div class="activity__row">
                    <div class="activity__title">
                        <div class="title__info">
                            <p><b>Редактирование</b></p>
                        </div>
                        <div class="title__info__mobile">
                            <p><b>Редактирование</b></p>
                        </div>
                        <div class="title__close">
                            <p><a href="/"><img src="{{ Vite::image('icons/close.svg') }}" alt="close"></a></p>
                        </div>
                    </div>

                    <div class="activity__form activity__form--mobile">

                        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
                            id="" autocomplete="disabled">
                            <fieldset>
                                <div class="activity__location">
                                    @csrf
                                    <input type="hidden" name="creator_id" value="{{$event->creator_id}}">
                                    <div class="info__time">
                                        <div class="time__title">
                                            <p>Дата и время меропрития</p>
                                        </div>
                                        <div class="time__input">
                                            <div class="input__date">
                                                <input type="date" id="create_date" name="date"
                                                    placeholder="10.12.2022" value="{{$event->full_start_date}}" required>
                                            </div>
                                            <div class="input__time">
                                                <input type="text" id="create_time-mobile" class="create_time"
                                                    name="time" placeholder="19:00 - 22:00"
                                                    value="{{$event->startTime}}" required>
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
                                            <input type="hidden" name="city_fias_id" 
                                            value="{{$event->city_fias_id}}">
                                            <input autocomplete="off" list="city_create_mob" type="text"
                                                id="create_city_mob" name="city_name" placeholder="Город"
                                                class="select_city_input-mob" value="{{$event->city_name}}" required>
                                        </div>
                                        <div class="input__street">
                                            <input type="hidden" name="street_fias_id" value="{{$event->street_fias_id}}">
                                            <input type="hidden" name="street_type" value="{{$event->street_type}}">
                                            <input type="text" autocomplete="off" id="create_street" name="street"
                                                placeholder="Улица" class="select_street_input-mob"
                                                value="{{$event->street}}" required>
                                        </div>
                                        <div class="input__home">
                                            <input type="hidden" name="building_fias_id" 
                                            value="{{$event->building_fias_id}}">
                                            <input type="text" autocomplete="off" class="select_building_input-mob" id="create_home" name="building" placeholder="Дом" required value="{{$event->building}}">
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
                                                <input type="number" id="create_number" name="max_members" min="1" max="30" placeholder="Кол-во человек"
                                                value="{{$event->max_members}}" required>
                                            </div>
                                            <div class="input__price">
                                                <span>Цена за вход с каждого участника</span>
                                                <input type="hidden" name="fee" value="{{$event->fee}}">
                                                <input type="number" id="create_price" name="price" min="0"
                                                    max="14999" placeholder="Цена"  value="{{$event->price}}" required>
                                                <span>При входе на мероприятие, Участники сообщают Создателю цифровой код,
                                                    который можно активировать на странице <a
                                                        href="{{ route('balance') }}">баланса</a> и
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
                                                <textarea name="description" id="create_description" placeholder="Описание мероприятия">{{$event->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="description__additional">
                                            <p>Необязательно к заполнению</p>
                                        </div>
                                    </div>
                                    <div class="description__button">
                                        <div class="description__gallery">
                                            <label for="js-file">
                                                <div class="description__add">
                                                    <div class="add__image"><img src="{{ Vite::image('icons/plus.svg') }}"
                                                            alt="add"></div>
                                                    <div class="add__text">
                                                        <p><b>Добавить фото</b></p>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <input id="js-file" type="file" name="image[]"
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
                                            <input type="text" name="user_phone" class="create_phone"
                                                id="phone_mobile" placeholder="+7 (___) ___-__-__"
                                                value="{{$event->phone}}" required>
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
                                                href="{{ route('policy') }}">политикой
                                                конфидециальности</a>, а так же <a
                                                href="{{ route('processing') }}">обработку</a>
                                            и <a href="{{ route('dissemination') }}">распространение</a>
                                            персональных данных.</label>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                    </div>



                    <div class="activity__form activity__form--desktop">


                        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
                            autocomplete="disabled">
                            <fieldset>
                            @csrf
                            <input type="hidden" name="creator_id" value="{{$event->creator_id}}">
                                <div class="activity__location">
                                    <div class="location__title">
                                        <p>Адрес мероприятия</p>
                                    </div>
                                    <div class="location__input">
                                        <input type="hidden" name="city_fias_id"  value="{{$event->city_fias_id}}">
                                        <div class="input__city">
                                            <input class="select_city_input-desc" autocomplete="off" list="city_create"  value="{{$event->city_name}}"
                                            type="text" id="select_city_input" name="city_name" placeholder="Город"
                                            required>
                                        </div>
                                        <input type="hidden" name="street_fias_id" value="{{$event->street_fias_id}}">
                                        <input type="hidden" name="street_type" value="{{$event->street_type}}">
                                        <div class="input__street">
                                            <input class="select_street_input-desc" type="text" autocomplete="off" id="select_street_input" name="street" placeholder="Улица"
                                            value="{{$event->street}}" required>
                                        </div>
                                        <input type="hidden" name="building_fias_id" 
                                        value="{{$event->building_fias_id}}">
                                        <div class="input__home">
                                            <input class="select_building_input-desc" type="text" autocomplete="off" value="{{$event->building}}"
                                            id="select_building_input" name="building" placeholder="Дом" required>
                                        </div>
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
                                            <input type="hidden" name="fee" value="{{$event->fee}}">
                                            <div class="input__number">
                                                <input type="number" id="create_number" name="max_members" min="2" max="30" value="{{$event->max_members}}"
                                                    placeholder="Кол-во человек" required>
                                            </div>
                                            <div class="input__price">
                                                <input type="number" id="create_price"
                                                    name="price" min="0" max="14999" placeholder="Цена"
                                                    value="{{$event->price}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="info__time">
                                        <div class="time__title">
                                            <p>Дата и время меропрития</p>
                                        </div>
                                        <div class="time__input">
                                            <div class="input__date">
                                                <input type="date" autocomplete="off"
                                                    id="create_date" name="date" placeholder="дд/мм/гггг"
                                                    value="{{$event->full_start_date}}" required>
                                            </div>
                                            <div class="input__time">
                                                <input type="text" class="create_time" id="create_time-desktop" name="time" placeholder="19:00 - 23:00"
                                                value="{{$event->start_time}} - {{$event->end_time}}" required></div>
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
                                                    <div class="add__image"><img src="{{ Vite::image('icons/plus.svg') }}"
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
                                            <div class="img__list" id="js-file-list2"></div>
                                        </div>

                                        <div class="description__text">
                                            <div class="description__textarea">
                                                <textarea name="description" id="create_description" placeholder="Описание мероприятия">{{$event->description}}</textarea>
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
                                        <div class="input__phone">
                                            <input type="text" name="user_phone" class="create_phone" 
                                            placeholder="+7 (___) ___-__-__" id="phone_desktop"
                                            value="{{$event->phone}}" required>
                                        </div>
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
                                                href="{{ route('policy') }}">политикой
                                                конфидециальности</a>, а так же <a
                                                href="{{ route('processing') }}">обработку</a>
                                            и <a href="{{ route('dissemination') }}">распространение</a>
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
    {{-- <script>
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
    </script> --}}
@endsection
