(function($) {
    $('.ask-a-question').on('click', function (e){
        e.preventDefault();
        FB && FB.CustomerChat && FB.CustomerChat.showDialog();
    });
    $(window).load(function () {
        $("body").addClass("tts-app-loaded");
    });})(jQuery);
