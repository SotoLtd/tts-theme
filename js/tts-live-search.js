(function ($) {
    var ajaxHandle;

    function ttsCancelSearch($sf) {
        $sf.removeClass('tts-search-show').find('.tts-live-search-result').html('');
    }

    function ttsRunSearch($sf, s, pt) {
        if (ajaxHandle) {
            ajaxHandle.abort();
        }
        $sf.addClass('tts-search-loading');
        ajaxHandle = $.ajax({
            method: "GET",
            url: TTSThemeData.ajaxUrl,
            data: {
                action: 'tts_live_search',
                search: s,
                post_type: pt
            },
            dataType: 'json',
            success: function (res) {
                $sf.removeClass('tts-search-loading');
                if (res && res.Status && res.Status === 'Found') {
                    $sf
                        .addClass('tts-search-show')
                        .find('.tts-live-search-result').html(res.Html);
                } else if (res && res.Status && res.Status === 'NotFound') {
                    $sf
                        .addClass('tts-search-show')
                        .find('.tts-live-search-result').html(res.Html);
                } else {
                    ttsCancelSearch($sf);
                }
            }
        });

    }

    $(document).ready(function () {
        $('.searchform').append('<div class="spinner-square"><div class="square-1 square"></div><div class="square-2 square"></div><div class="square-3 square"></div></div><div class="tts-live-search-result-wrap"><div class="tts-live-search-result"></div></div>');
        $('body').on('click', function (e) {
            $('.searchform').removeClass('tts-search-show');
            $('.tts-live-search-result').html('');
        });
        jQuery('.searchform').on('click', function (e) {
            if ($(this).hasClass('tts-search-show')) {
                e.stopPropagation();
            }
        });
        $('.searchform input[name="s"]').on("keyup", function () {
            var $input = $(this),
                $searchForm = $input.closest('.searchform'),
                $pt = $searchForm.find('input[name="post_type"]'),
                sTerm = $input.val().trim(),
                pt = $pt.length ? $pt.val() : '';

            if (sTerm && sTerm.length >= 3) {
                ttsRunSearch($searchForm, sTerm, pt);
            } else {
                ttsCancelSearch($searchForm);
            }
        });

    });
})(jQuery);
