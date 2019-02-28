(function($) {
    $('.ask-a-question').on('click', function (e){
        e.preventDefault();
        FB && FB.CustomerChat && FB.CustomerChat.showDialog();
    });
})(jQuery);