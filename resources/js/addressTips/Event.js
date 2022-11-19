import $ from "jquery";
import "suggestions-jquery";
import IMask from "imask";

$(document).ready(function () {
    /*-------------------- address tooltips --------------------*/
    let city = $(".select_city_input-desc");
    let form = city.closest("form");
    let cityFiasId = $(form).find("[name='city_fias_id']");
    let streetFiasId = $("[name='street_fias_id']");
    let streetType = $("[name='street_type']");
    let street = $(".select_street_input-desc");
    let buildingFiasId = $("[name='building_fias_id']");
    let building = $(".select_building_input-desc");

    let token = "6258e1bec720b3a4c277c137fd96e32c57e2f39d";

    city.on("input", () => {
        cityFiasId.val("");
    });
    street.on("input", () => {
        streetFiasId.val("");
    });
    building.on("input", () => {
        buildingFiasId.val("");
    });

    function formatSelectedCity(suggestion) {
        return suggestion.data.city;
    }
    function formatSelectedStreet(suggestion) {
        return suggestion.data.street;
    }
    function formatSelectedBuilding(suggestion) {
        return suggestion.data.house;
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
    street.suggestions({
        type: "ADDRESS",
        token: token,
        minChars: 3,
        hint: false,
        bounds: "street",
        constraints: city,
        count: 8,
        onSelect: (suggestion) => {
            streetFiasId.val(suggestion.data.street_fias_id ?? "fias_is_null");
            streetType.val(suggestion.data.street_type);
        },
        formatSelected: formatSelectedStreet,
    });
    building.suggestions({
        type: "ADDRESS",
        token: token,
        minChars: 1,
        hint: false,
        bounds: "house",
        constraints: street,
        count: 8,
        onSelect: (suggestion) => {
            buildingFiasId.val(suggestion.data.house_fias_id ?? "fias_is_null");
        },
        formatSelected: formatSelectedBuilding,
    });

    /*----------------- input masks -----------------*/
    let timeDesktop = document.querySelector("#create_time-desktop");
    let timeMobile = document.querySelector("#create_time-mobile");
    let phoneDesktop = document.querySelector("#phone_desktop");
    let phoneMobile = document.querySelector("#phone_mobile");

    if (timeDesktop || timeMobile) {
        let timeOptions = {
            mask: "HH:MM - HH:MM",
            blocks: {
                HH: {
                    mask: IMask.MaskedRange,
                    from: 0,
                    to: 23,
                },

                MM: {
                    mask: IMask.MaskedRange,
                    from: 0,
                    to: 59,
                },
            },
        };
        let phoneOptions = {
            mask: "{+7}(000)000-00-00",
            lazy: false,
        };

        IMask(timeDesktop, timeOptions);
        IMask(timeMobile, timeOptions);
        IMask(phoneDesktop, phoneOptions);
        IMask(phoneMobile, phoneOptions);
    }
});
