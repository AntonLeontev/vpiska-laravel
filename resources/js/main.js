function create_activity_1() {
  if (
    $("#create_date").val().length == 0 ||
    $("#create_time").val().length == 0
  ) {
    Swal.fire({
      icon: "error",
      title: "Ошибка...",
      text: "Заполните все поля !",
    });
  } else {
    document.getElementsByClassName("activity__location")[0].style.display =
      "none";
    document.getElementsByClassName("activity__info")[0].style.display = "flex";
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
    document.getElementsByClassName("activity__info")[0].style.display = "none";
    document.getElementsByClassName("activity__description")[0].style.display =
      "flex";
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
    document.getElementsByClassName("activity__description")[0].style.display =
      "none";
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
        $(".carousel-count").html(nextSlide + 1 + "/" + slick.slideCount);
      }
    );
  }

  $.fn.setCursorPosition = function (pos) {
    if ($(this).get(0).setSelectionRange) {
      $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
      var range = $(this).get(0).createTextRange();
      range.collapse(true);
      range.moveEnd("character", pos);
      range.moveStart("character", pos);
      range.select();
    }
  };

  $.mask.definitions["h"] = "[0-2]";
  $.mask.definitions["m"] = "[0-5]";

  $(".create_phone").mask("+7 (999) 999-99-99");
  $(".create_time").mask("h9:m9 - h9:m9");

  $("#withdraw_card")
    .click(function () {
      $(this).setCursorPosition(0);
    })
    .mask("9999 9999 9999 9999");

  $("#withdraw_number")
    .click(function () {
      $(this).setCursorPosition(0);
    })
    .mask("+79999999999");

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
          activity_id: target.dataset.activity_id,
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

  $(".creator_controls__edit").click((event) => {});

  $(".creator_controls__cancel").click((event) => {
    const target = event.target.closest(".creator_controls__cancel");
    Swal.fire({
      title: "Действительно хотите удалить мероприятие?",
      showDenyButton: true,
      confirmButtonText: "Да",
      denyButtonText: "Нет",
    }).then((result) => {
      if (result.isConfirmed) {
        cancelActivity(target);
      }
    });

    function cancelActivity(target) {
      $.ajax({
        url: "/assets/query/cancel_activity.php",
        method: "POST",
        dataType: "json",
        data: {
          user_id: target.dataset.user_id,
          activity_id: target.dataset.activity_id,
        },
        success: (data) => {
          if (data.state === "ok") {
            Swal.fire({
              icon: "success",
              title: "Успешно",
              text: data.message,
            });
            setTimeout(() => {
              window.location = "/";
            }, 2000);
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
});
