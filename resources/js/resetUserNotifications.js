document.addEventListener("DOMContentLoaded", () => {
    let userId = $("meta[name='user_id']").attr("content");
    axios
        .put(`/users/events/${userId}`)
        .then((response) => {
            if (response.data.status === "ok") resetNotifications();
        })
        .catch((error) => {
            console.log(error);
        });

    function resetNotifications() {
        document.querySelector("#weed").innerHTML = "0";
        document.querySelector("#weed_mob").innerHTML = "0";
    }
});
