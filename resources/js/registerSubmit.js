if ($("#register").length) {
  $("#register").submit(function (e) {
    e.preventDefault();
    let form = $(this);
    let actionUrl = form.attr("action");
    $.ajax({
      type: "POST",
      url: actionUrl,
      data: form.serialize(),
      success: function (data) {
        if (data == "error_1") {
          Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Имя должно быть длиннее 1 символа",
          });
        } else if (data == "error_2") {
          Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Фамилия должна быть длиннее 2 символов",
          });
        } else if (data == "error_3") {
          Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Пароли не совпадают!",
          });
        } else if (data == "error_4") {
          Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Пароль должен быть не менее 8-ми символов!",
          });
        } else if (data == "error_5") {
          Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Данный e-mail уже зарегистрирован",
          });
        } else if (data == "error_6") {
          Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Неправильный ответ на контрольный вопрос",
          });
        } else if (data == "error_7") {
          Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Ошибка регистрации. Попробуйте позже",
          });
        } else if (data == "error_8") {
          Swal.fire({
            icon: "error",
            title: "Ошибка...",
            text: "Ошибка регистрации. Попробуйте позже",
          });
        } else if (data == "success") {
          $("#register")[0].reset();
          Swal.fire({
            icon: "success",
            title: "Успешная регистрация!",
            text: "Ссылка на подтверждение аккаунта отправлена на вашу почту",
            showConfirmButton: false,
            timer: 2500,
          });
        }
      },
    });
  });
}
