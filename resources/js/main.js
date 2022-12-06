$("input").on("focus", function () {
    $(".navbar").addClass("hide");
});

$("input").on("focusout", function () {
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
        let card = document.querySelector(".gallery__card_template");
        card = card.cloneNode(true);
        card.classList.remove("gallery__card_template");
        card.querySelector("img").setAttribute(
            "src",
            `/storage/${imageData.path}`
        );
        card.querySelector(".btn__image-delete").setAttribute(
            "data-action",
            imageData.deletePath
        );
        card.querySelector(".btn__image-delete").setAttribute(
            "data-token",
            imageData.token
        );
        card.querySelector(".btn__image-delete").setAttribute(
            "data-user_id",
            imageData.userId
        );
        return card;
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

    /*--------------hiding orders----------------*/
    $(document).on("click", ".order-hide", (event) => {
        let item = event.target.closest(".weed-item");

        $.ajax({
            method: event.target.dataset.method,
            url: event.target.dataset.url,
            data: {
                _token: event.target.dataset.token,
            },
            success: (data) => {
                if (data.status === "ok") {
                    $(item).on("transitionend", (event) => {
                        item.remove();
                    });
                    $(item).addClass("weed-item_hiding");
                }
            },
            error: handleError,
        });
    });
});
