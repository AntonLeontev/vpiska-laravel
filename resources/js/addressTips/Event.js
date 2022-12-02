import $ from "jquery";
import "suggestions-jquery";
import IMask from "imask";
import { tokens } from "../tokens";

$(document).ready(function () {
    /*-------------------- address tooltips --------------------*/
    let city = $(".select_city_input-desc");
    let form = city.closest("form");
    let cityFiasId = $(form).find("[name='city_fias_id']");
    let utcOffset = $(form).find("[name='utc_offset']");
    let streetFiasId = $("[name='street_fias_id']");
    let streetType = $("[name='street_type']");
    let street = $(".select_street_input-desc");
    let buildingFiasId = $("[name='building_fias_id']");
    let building = $(".select_building_input-desc");

    city.on("input", () => {
        cityFiasId.val("");
        utcOffset.val("");
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

    function getUtcOffset(lat, lon) {
        $.get({
            url: "https://api.ipgeolocation.io/timezone",
            data: {
                apiKey: tokens.geolocationApiKey,
                lat: lat,
                long: lon,
            },
            success: (data) => {
                utcOffset.val(data.timezone_offset_with_dst);
            },
        });
    }

    city.suggestions({
        type: "ADDRESS",
        token: tokens.dadataToken,
        minChars: 3,
        hint: false,
        bounds: "city",
        count: 8,
        onSelect: (suggestion) => {
            cityFiasId.val(suggestion.data.city_fias_id);
            utcOffset.val(
                getUtcOffset(suggestion.data.geo_lat, suggestion.data.geo_lon)
            );
        },
        formatSelected: formatSelectedCity,
    });
    street.suggestions({
        type: "ADDRESS",
        token: tokens.dadataToken,
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
        token: tokens.dadataToken,
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
    let phoneDesktop = document.querySelector("#phone_desktop");

    if (timeDesktop) {
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
        IMask(phoneDesktop, phoneOptions);
    }
});
