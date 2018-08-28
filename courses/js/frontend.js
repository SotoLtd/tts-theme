;
(function($){
    function isMobile(dw){
        var rw = 1024, ww = $(window).width();
        if(dw){
            rw = dw;
        }
        if(rw>=ww) return true;
        return false;
    }
    $(document).ready(function(){
        var tippedOp = {
            behavior: 'sticky',
            close: 'overlap',
            hideOn: false,
            hideOnClickOutside: true,
            hideOthers: true,
            maxWidth: 960,
            showDelay: 1500
        };
        $('.course-stiker-img').each(function(){
            Tipped.create($(this), $(this).next('p').html(),tippedOp);
        });
        $('.course-tooltip-image').each(function(){
            $(this).on('click', function(){
                return false;
            });
            var text = $(this).attr('href');
            if(!text){
                return;
            }
            Tipped.create($(this), '<img src="' + text + '"/>',tippedOp);
        });
    });
})(jQuery);