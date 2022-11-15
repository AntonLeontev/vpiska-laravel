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
            appendArrows: ".carousel-controls",
            prevArrow:
                '<button type="button" class="slick-prev"><img src="/images/icons/prev.svg" alt="prev"></button>',
            nextArrow:
                '<button type="button" class="slick-next"><img src="/images/icons/next.svg" alt="next"></button>',
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

    /*----------------- Кнопки отмены заказа -----------------*/
    $(".cancel_order_button").click(function (event) {
        event.preventDefault();
        const target = event.target.closest(".cancel_order_button");

        Swal.fire({
            title: "Действительно хотите отменить заявку? Комиссия не возвращаается",
            showDenyButton: true,
            confirmButtonText: "Да",
            denyButtonText: "Нет",
        }).then((result) => {
            if (result.isConfirmed) {
                cancelOrder(target);
            }
        });

        function cancelOrder(target) {
            $.ajax({
                url: "/assets/query/cancel_order.php",
                method: "POST",
                dataType: "json",
                data: {
                    user_id: target.dataset.user_id,
                    event_id: target.dataset.event_id,
                },
                success: (data) => {
                    if (data.state === "ok") {
                        $(".cancel_order_button").remove();
                        $(".message_for_user").remove();

                        Swal.fire({
                            icon: "success",
                            title: "Успешно",
                            text: data.message,
                        });
                    }

                    if (data.state === "error") {
                        Swal.fire({
                            icon: "error",
                            title: "Ошибка",
                            text: data.message,
                        });
                    }
                },
            });
        }
    });

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
    $("form").on("submit", formSubmitHandler);

    function formSubmitHandler(event) {
        event.preventDefault();
        let form = event.target;

        if (form.hasAttribute("confirmable")) {
            return;
        }

        form = $(form);
        let actionUrl = form.attr("action");
        let method = form.attr("method");
        $.ajax({
            type: method,
            url: actionUrl,
            data: form.serialize(),
            success: function (data) {
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
            },
            error: (data) => {
                let message;
                if (data.responseJSON.errors === undefined) {
                    message = data.responseJSON.message;
                    if (message) {
                        fireError(message);
                        return;
                    }
                }

                let errors = data.responseJSON.errors;
                message = "";
                for (let text in errors) {
                    message += errors[text].join(`\n`) + `\n`;
                }

                if (!message) {
                    message = "Попробуйте перезагрузить страницу";
                }

                fireError(message);
                console.log(data);
            },
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
});
