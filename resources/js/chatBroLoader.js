import $ from "jquery";

function ChatbroLoader(chats, async) {
    async = !1 !== async;
    var params = {
            embedChatsParameters: chats instanceof Array ? chats : [chats],
            lang: navigator.language || navigator.userLanguage,
            needLoadCode: "undefined" == typeof Chatbro,
            embedParamsVersion: localStorage.embedParamsVersion,
            chatbroScriptVersion: localStorage.chatbroScriptVersion,
        },
        xhr = new XMLHttpRequest();
    xhr.withCredentials = !0;
    xhr.onload = function () {
        eval(xhr.responseText);
    };
    xhr.onerror = function () {
        console.error("Chatbro loading error");
    };
    xhr.open(
        "GET",
        "//www.chatbro.com/embed.js?" +
            btoa(unescape(encodeURIComponent(JSON.stringify(params)))),
        async
    );
    xhr.send();
}

var isMobile =
    !!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
        navigator.userAgent
    );
if (!isMobile) {
    var color_white = "#fffffff";
    var col_2 = color_white;
    var col_3 = color_white;
    var col_4 = "#fff";
    var false_ff = false;
    var c_header = "#010012";
} else {
    //var color_white = "#7F7165";
    var color_white = "#55003c";
    var col_2 = "#CBE3FE";
    //var col_3="#aab3c7";
    var col_3 = "#fff";
    var col_4 = "#000";
    var c_header = "#55003c";
    var false_ff = true;
}

let chat = $(".chat__main");

if (chat.length) {
    let user_id = chat.data("user_id");
    let user_name = chat.data("user_name");
    let user_avatar = chat.data("user_avatar");
    let user_link = chat.data("user_link");
    let chat_id = chat.data("chat_id");

    ChatbroLoader({
        parentEncodedChatId: "98LUa",
        isStatic: !isMobile,
        chatMobileHeightPercent: 100,
        chatMobileWidthPercent: 100,
        chatTitle: "Вы вошли в чат",
        extId: chat_id,
        siteDomain: "vpiska.online",
        avatarBorderRadius: "50%",
        chatHeaderBackgroundColor: c_header,
        chatBodyBackgroundColor: "#ffffff",
        chatHeaderTextColor: color_white,
        chatBodyTextColor: color_white,
        chatAdminBodyTextColor: color_white,
        chatModerBodyTextColor: color_white,
        chatInputTextColor: col_4,
        chatInputBackgroundColor: col_3,
        chatLinksTextColor: color_white,
        chatTopLeftBorderRadius: "10",
        chatTopRightBorderRadius: "10",
        chatBottomLeftBorderRadius: "10",
        chatBottomRightBorderRadius: "10",
        minimizedChatBorderRadius: "5px",
        showChatBorder: false_ff,
        showBorderBetweenMessages: false_ff,
        highlightReplies: false,
        siteUserExternalId: user_id,
        siteUserFullName: user_name,
        siteUserAvatarUrl: user_avatar,
        siteUserProfileUrl: user_link,
    });
}
