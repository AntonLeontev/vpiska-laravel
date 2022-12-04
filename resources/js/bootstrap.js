import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * jQuery
 */

import $ from "jquery";
window.$ = $;

/**
 * slider
 */

import "slick-carousel";

/**
 * DaData.ru Suggestions jQuery plugin 
 */

import "suggestions-jquery";

/**
 * vanilla javascript input mask 
 */

import IMask from "imask";
window.IMask = IMask;

/**
 * Replacement for JavaScript's popup boxes 
 */

import Swal from "sweetalert2";
window.Swal = Swal;


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";
window.Echo = Echo;
import Pusher from "pusher-js";
window.Pusher = Pusher;

/**
 * ToastrJS is a JavaScript library for Gnome / Growl type non-blocking notifications.
 */

import toastr from "toastr";
window.toastr = toastr;

toastr.options = {
    closeButton: false,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-bottom-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};

if (window.innerWidth <= 1150) {
    toastr.options.positionClass = "toast-top-center";
}



