import $ from "jquery";
import "suggestions-jquery";

$(document).ready(function () {
    let city = $(".select_city_input");
    let form = city.closest("form");
    let cityFiasId = $(form).children("[name='city_fias_id']");

    let token = "6258e1bec720b3a4c277c137fd96e32c57e2f39d";

    city.on("input", () => {
        cityFiasId.val("");
    });

    function formatSelectedCity(suggestion) {
        return suggestion.data.city;
    }

    city.suggestions({
        type: "ADDRESS",
        token: token,
        minChars: 3,
        hint: false,
        bounds: "city",
        count: 8,
        onSelect: (suggestion) => {
            cityFiasId.val(suggestion.data.city_fias_id);
        },
        formatSelected: formatSelectedCity,
    });
});
