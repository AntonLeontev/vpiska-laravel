$(document).ready(function () {
    let city = $(".select_city_input");
    let form = city.closest("form");
    let cityFiasId = $(form).children("[name='city_fias_id']");

    city.on("input", () => {
        cityFiasId.val("");
    });

    function formatSelectedCity(suggestion) {
        return suggestion.data.city;
    }

    city.suggestions({
        type: "ADDRESS",
        token: import.meta.env.VITE_DADATA_TOKEN,
        minChars: 3,
        hint: false,
        bounds: "city",
        count: 5,
        onSelect: (suggestion) => {
            cityFiasId.val(suggestion.data.city_fias_id);
        },
        formatSelected: formatSelectedCity,
    });
});
