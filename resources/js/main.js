import $ from "jquery";
import Swal from "sweetalert2";
import "suggestions-jquery";

function create_activity_1() {
    if (
        $("#create_date").val().length == 0 ||
        $("#create_time").val().length == 0
    ) {
        Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Заполните все поля!",
        });
    } else {
        document.getElementsByClassName("activity__location")[0].style.display =
            "none";
        document.getElementsByClassName("activity__info")[0].style.display =
            "flex";
    }
}

function create_activity_2() {
    if (
        $("#create_city_mob").val().length == 0 ||
        $("#create_street").val().length == 0 ||
        $("#create_home").val().length == 0
    ) {
        Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Заполните все поля !",
        });
    } else {
        document.getElementsByClassName("activity__info")[0].style.display =
            "none";
        document.getElementsByClassName(
            "activity__description"
        )[0].style.display = "flex";
    }
}

function create_activity_3() {
    if ($("#create_number").val() > 30) {
        Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Максимальное чилсо участников 30 !",
        });
        return;
    }

    if ($("#create_price").val() < 0 || $("#create_price").val() > 14999) {
        Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Цена должна быть в диапазоне от 0 до 14999 !",
        });
        return;
    }

    if (
        $("#create_number").val().length == 0 ||
        $("#create_price").val().length == 0
    ) {
        Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Заполните все поля !",
        });
    } else {
        document.getElementsByClassName(
            "activity__description"
        )[0].style.display = "none";
        document.getElementsByClassName("img__list")[0].style.display = "none";
        document.getElementsByClassName("activity__number")[0].style.display =
            "flex";
    }
}

function create_activity_4() {
    if ($("#create_description").val().length == 0) {
        Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Заполните все поля !",
        });
    } else {
        document.getElementsByClassName("activity__number")[0].style.display =
            "none";
        document.getElementsByClassName("actvity__submit")[0].style.display =
            "flex";
    }
}

$("input").focus(function () {
    $(".navbar").addClass("hide");
});

$("input").focusout(function () {
    $(".navbar").removeClass("hide");
});

document.addEventListener("chatLoaded", function (event) {
    let chat = event.chat;

    // Switch mode button
    let btn = document.getElementById("chatbroOpenChat");
    if (btn) {
        btn.onclick = chat.maximizeChat.bind(chat);
    }
});

window.onload = function () {
    let chatbroChat = document.querySelector(".chatbro_chat");
    if (chatbroChat) {
        if (window.innerWidth <= 525) {
            chatbroChat.classList.add("chat__main--mob");
        } else {
            chatbroChat.classList.add("chat__main--desktop");
        }
    }
};

$(document).ready(function () {
    if ($(".carousel").length) {
        $(".carousel").slick({
            infinite: true,
            prevArrow: $(".slick-prev"),
            nextArrow: $(".slick-next"),
        });

        $(".carousel").on(
            "beforeChange",
            function (event, slick, currentSlide, nextSlide) {
                $(".carousel-count").html(
                    nextSlide + 1 + "/" + slick.slideCount
                );
            }
        );
    }

    // $.fn.setCursorPosition = function (pos) {
    //     if ($(this).get(0).setSelectionRange) {
    //         $(this).get(0).setSelectionRange(pos, pos);
    //     } else if ($(this).get(0).createTextRange) {
    //         var range = $(this).get(0).createTextRange();
    //         range.collapse(true);
    //         range.moveEnd("character", pos);
    //         range.moveStart("character", pos);
    //         range.select();
    //     }
    // };

    // $.mask.definitions["h"] = "[0-2]";
    // $.mask.definitions["m"] = "[0-5]";

    // $(".create_phone").mask("+7 (999) 999-99-99");
    // $(".create_time").mask("h9:m9 - h9:m9");

    // $("#withdraw_card")
    //     .click(function () {
    //         $(this).setCursorPosition(0);
    //     })
    //     .mask("9999 9999 9999 9999");

    // $("#withdraw_number")
    //     .click(function () {
    //         $(this).setCursorPosition(0);
    //     })
    //     .mask("+79999999999");

    // /*----------------- Кнопки отмены заказа -----------------*/
    // $(".cancel_order_button").click(function (event) {
    //     event.preventDefault();
    //     const target = event.target.closest(".cancel_order_button");

    //     Swal.fire({
    //         title: "Действительно хотите отменить заявку? Комиссия не возвращаается",
    //         showDenyButton: true,
    //         confirmButtonText: "Да",
    //         denyButtonText: "Нет",
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             cancelOrder(target);
    //         }
    //     });

    //     function cancelOrder(target) {
    //         $.ajax({
    //             url: "/assets/query/cancel_order.php",
    //             method: "POST",
    //             dataType: "json",
    //             data: {
    //                 user_id: target.dataset.user_id,
    //                 event_id: target.dataset.event_id,
    //             },
    //             success: (data) => {
    //                 if (data.state === "ok") {
    //                     $(".cancel_order_button").remove();
    //                     $(".message_for_user").remove();

    //                     Swal.fire({
    //                         icon: "success",
    //                         title: "Успешно",
    //                         text: data.message,
    //                     });
    //                 }

    //                 if (data.state === "error") {
    //                     Swal.fire({
    //                         icon: "error",
    //                         title: "Ошибка",
    //                         text: data.message,
    //                     });
    //                 }
    //             },
    //         });
    //     }
    // });

    /*------------------- Кнопки управления мероприятием -------------------*/
    $("#form__event-cancel").on("submit", function (event) {
        event.preventDefault();
        let form = event.target.closest("form");
        Swal.fire({
            title: "Действительно хотите удалить мероприятие?",
            showDenyButton: true,
            confirmButtonText: "Да",
            denyButtonText: "Нет",
        }).then((result) => {
            if (result.isConfirmed) {
                form.removeAttribute("confirmable");
                formSubmitHandler(event);
            }
        });
    });

    /*------------- form submit handler --------------*/
    $(document).on("submit", "form", formSubmitHandler);

    function formSubmitHandler(event) {
        event.preventDefault();
        let form = event.target.closest("form");
        if (form.hasAttribute("confirmable")) {
            return;
        }

        $.ajax({
            type: $(form).attr("method"),
            url: $(form).attr("action"),
            data: $(form).serialize(),
            success: (data) => {
                if (data.status === "ok") {
                    redirect(data.redirect);
                    return;
                }

                if (data.status === "message") {
                    Swal.fire({
                        text: data.message,
                    });
                    return;
                }
                console.log(data);
            },
            error: handleError,
        });
    }

    function fireError(message) {
        Swal.fire({
            titleText: "Ошибка",
            text: message,
            icon: "error",
        });
    }

    function redirect(url) {
        if (url === "reload") {
            location.reload();
            return;
        }

        if (url === "") return;

        location.replace(url);
    }

    function handleError(data) {
        if (data.responseJSON.errors === undefined) {
            if (data.responseJSON.message) {
                fireError(data.responseJSON.message);
                console.log(data);
                return;
            }
        }

        let errors = data.responseJSON.errors;
        let message = "";
        for (let text in errors) {
            message += errors[text].join(`\n`) + `\n`;
        }

        if (!message) {
            message = "Попробуйте перезагрузить страницу";
        }

        fireError(message);
        console.log(data);
    }

    /*--------------- Share Button -----------------*/
    let shareButton = document.getElementById("share-button");
    if (shareButton) {
        shareButton.addEventListener("click", function () {
            if (navigator.share) {
                navigator
                    .share({
                        title: "Успей посетить мероприятие!",
                        text: "Пошли со мной на это классное мероприятие!",
                        url: window.location.href,
                    })
                    .then(function () {
                        Swal.fire({
                            icon: "success",
                            title: "Успешно!",
                            text: "Вы успешно поделились ссылкой!",
                            showConfirmButton: false,
                            timer: 2500,
                        });
                    });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Ошибка...",
                    text: "Вы не можете поделиться с данного браузера!",
                });
            }
        });
    }

    /*--------------user photo upload----------------*/
    $(".input_file_user").on("change", function (event) {
        let form = event.target.closest("form");
        let fileUpload = $(form).find("input[type=file]");

        if (parseInt(fileUpload.get(0).files.length) > 5) {
            Swal.fire({
                text: "Максимальное число загружаемых файлов не более 5-ти",
                icon: "warning",
            });
            return;
        }

        $.ajax({
            type: $(form).attr("method"),
            url: $(form).attr("action"),
            data: new FormData(form),
            processData: false,
            contentType: false,
            success: (data) => {
                if (data.status !== "ok") {
                    Swal.fire({
                        text: "Ошибка загрузки",
                        icon: "error",
                    });
                    return;
                }

                let empty = form
                    .closest(".gallery__main")
                    .querySelector(".gallery__add_empty");
                if (empty) empty.remove();

                data.images.forEach((image) => {
                    document
                        .querySelector(".gallery__main")
                        .append(createCard(image));
                });
            },
            error: handleError,
        });
    });

    function createCard(imageData) {
        let div = document.createElement("div");
        div.className = "gallery__card";
        div.innerHTML = `<img src="/storage/${imageData.path}" alt="profile photo">`;
        div.innerHTML += `<div 
        class="btn__image-delete" data-action="${imageData.deletePath}" data-token="${imageData.token}"
        data-user_id="${imageData.userId}">
        <img src="http://127.0.0.1:5173/resources/images/icons/delete.svg" alt="delete">
        </div>`;
        return div;
    }

    function createInput(imageData) {
        let input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("value", imageData.path);
        input.setAttribute("name", "images[]");
        return input;
    }

    /*--------------temp photo upload----------------*/
    $(".input_file_temp").on("change", function (event) {
        let form = event.target.closest("form");
        let fileUpload = $(form).find("input[type=file]");

        if (parseInt(fileUpload.get(0).files.length) > 5) {
            Swal.fire({
                text: "Максимальное число загружаемых файлов не более 5-ти",
                icon: "warning",
            });
            return;
        }

        $.ajax({
            type: $(form).attr("method"),
            url: $(form).attr("action"),
            data: new FormData(form),
            processData: false,
            contentType: false,
            success: (data) => {
                if (data.status !== "ok") {
                    Swal.fire({
                        text: "Ошибка загрузки",
                        icon: "error",
                    });
                    return;
                }

                data.images.forEach((image) => {
                    document
                        .querySelector(".gallery__main")
                        .append(createCard(image));

                    document
                        .querySelector(".form_event-create")
                        .append(createInput(image));
                });
                console.log(data);
            },
            error: handleError,
        });
    });

    /*--------------event photo upload----------------*/
    $(".input_file_event").on("change", function (event) {
        let form = event.target.closest("form");
        let fileUpload = $(form).find("input[type=file]");

        if (parseInt(fileUpload.get(0).files.length) > 5) {
            Swal.fire({
                text: "Максимальное число загружаемых файлов не более 5-ти",
                icon: "warning",
            });
            return;
        }

        $.ajax({
            type: $(form).attr("method"),
            url: $(form).attr("action"),
            data: new FormData(form),
            processData: false,
            contentType: false,
            success: (data) => {
                if (data.status !== "ok") {
                    Swal.fire({
                        text: "Ошибка загрузки",
                        icon: "error",
                    });
                    return;
                }

                data.images.forEach((image) => {
                    document
                        .querySelector(".gallery__main")
                        .append(createCard(image));
                });
            },
            error: handleError,
        });
    });

    /*--------------photo delete----------------*/
    $(document).on("click", ".btn__image-delete", function (event) {
        let btn = this.closest(".btn__image-delete");
        $.ajax({
            url: btn.dataset.action,
            method: "DELETE",
            data: {
                _token: btn.dataset.token,
                userId: btn.dataset.user_id,
            },
            success: (data) => {
                if (data.status === "ok") {
                    this.closest(".gallery__card").remove();
                }
            },
            error: handleError,
        });
    });
});
