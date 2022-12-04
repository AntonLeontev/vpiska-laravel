if ($("meta[name='user_id']").length) {
    // Enable pusher logging
    Pusher.log = function (message) {
        if (window.console && window.console.log) window.console.log(message);
    };

    window.Echo = new Echo({
        broadcaster: "pusher",
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        wsHost:
            import.meta.env.VITE_PUSHER_HOST ??
            `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
        wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
        wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
        forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? "https") === "https",
        enabledTransports: ["ws", "wss"],
    });

    let userId = $("meta[name='user_id']").attr("content");

    window.Echo.private(`App.Models.User.${userId}`).notification(
        (notification) => {
            toastr.info(notification.message);
            document.querySelector("#weed").innerHTML =
                notification.notifications;
            document.querySelector("#weed_mob").innerHTML =
                notification.notifications;
        }
    );
}
