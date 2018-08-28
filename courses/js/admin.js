;
(function($){
    function sort_clone_key($cloneWrap){
        $('.sd-visual-editor', $cloneWrap).each(function(){
            var fid = $(this).attr('id');
            tinyMCE && tinyMCE.execCommand("mceRemoveEditor", false, fid);
        });
        $cloneWrap.find('.tts-field-cloneable').each(function(index){
            var $clone = $(this);  
            $(':input', $clone).each(function(){
                var name = $(this).attr( 'name' ).replace( /\[(\d+)\]/, function( match, p1 ){
                        return '[' + index + ']';
                    });
                $(this).attr( 'name', name );

                var fid = $(this).attr( 'id' );
                if($(this).hasClass('sd-visual-editor')){
                    tinyMCE && tinyMCE.execCommand("mceRemoveEditor", false, fid);
                }
                fid = fid.replace( /-(\d+)-/, function( match, p1 ){
                        return '-' + index + '-';
                    });
                $(this).attr( 'id', fid );
            });

            $('label', $clone).each(function(){
                var l = $(this);
                var lfor = l.attr( 'for' ).replace( /-(\d+)-/, function( match, p1 ){
                    $('.tts-label-num', l).html(index + 1);
                            return '-' + index + '-';
                        });
                l.attr( 'for', lfor );
            });  
        });
        $('.sd-visual-editor', $cloneWrap).each(function(){
            var fid = $(this).attr('id');
            tinyMCE && tinyMCE.execCommand("mceAddEditor", false, fid);
        });
        
    }
    function sort_stickers_key($cloneWrap){
        $cloneWrap.find('li').each(function(index){
            var $clone = $(this);
            $(':input', $clone).each(function(){
                var name = $(this).attr( 'name' ).replace( /\[(\d+)\]/, function( match, p1 ){
                        return '[' + index + ']';
                    });
                $(this).attr( 'name', name );
            });
        });
        
    }
    
    $(document).ready(function(){
        $('.tts-mb-shortable').sortable({
            axis: "y",
            cursor: "move",
            distance: 5,
            connectWith: ">li",
            items: ">li",
            placeholder: "sortable-placeholder",
            forcePlaceholderSize: true,
            handle: '.tts-sahandle'
        });
        $('.tts-mb-clone-wrap').sortable({
            axis: "y",
            cursor: "move",
            distance: 5,
            connectWith: ".tts-field-cloneable",
            items: ".tts-field-cloneable",
            placeholder: "sortable-placeholder",
            forcePlaceholderSize: true,
            handle: '.tts-mb-clone-sahandle',
            update: function(event, ui){
                sort_clone_key($(event.target));
            },
            start: function(event, ui){
                $('.sd-visual-editor', $(event.target)).each(function(){
                    var fid = $(this).attr('id');
                    tinyMCE && tinyMCE.execCommand("mceRemoveEditor", false, fid);
                });
            },
            stop: function(event, ui){
                $('.sd-visual-editor', $(event.target)).each(function(){
                    var fid = $(this).attr('id');
                    tinyMCE && tinyMCE.execCommand("mceAddEditor", false, fid);
                });
            }
        });
        
        $('body').on('click', '.tts-add-media', function(e){
            e.preventDefault();
            var $field = $(this).prev('input');
            var $preview = false;
            if($(this).hasClass('tss-has-prev') && $(this).next('.tts-media-prev').size()){
                $preview = $(this).next('.tts-media-prev');
            }
            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Select Image',
                button: {
                text: 'Use This Image'
                },
                multiple: false // Set to true to allow multiple files to be selected
            });
            file_frame.on( 'select', function() {
                var attachment = file_frame.state().get('selection').toJSON();
                attachment = attachment[0];
                $field.val(attachment.url);
                console.log(attachment);
                if($preview){
                    $preview.html('<img src="'+attachment.url+'" alt=""/>');
                }
            });
            file_frame.open();
        });
        
        $('body').on('click', '.tts-mb-clone-delete', function(e){
            e.preventDefault();
            var $cloneW = $(this).closest('.tts-mb-clone-wrap');
            if($cloneW.find('.tts-field-cloneable').length <2){
                return false;
            }
            $(this).closest('.tts-field-cloneable').find('.sd-visual-editor').each(function(){
                var fid = $(this).attr('id');
                tinyMCE && tinyMCE.execCommand("mceRemoveEditor", false, fid);
            });
            
            $(this).closest('.tts-field-cloneable').remove();
            sort_clone_key($cloneW);
        });
        
        $('body').on('click', '.tts-mb-clone-add', function(e){
            e.preventDefault();
            var $cloneW = $(this).prev('.tts-mb-clone-wrap'),
                $clone = $cloneW.find('.tts-field-cloneable').last().clone();
            $('.mce-tinymce', $clone).remove();
            $(':input', $clone).each(function(){
                $(this).val('');
                $(this).attr('style', '');
            });
            
            
            $(this).prev('.tts-mb-clone-wrap').append($clone);
            sort_clone_key($cloneW);
        });
        $('.tts-add-stiker').on('click', function(e){
            e.preventDefault();
            var $cloneW = $(this).prev('.tts-stikers-ul'),
                $clone = $cloneW.find('li').last().clone();
                
            console.log($($cloneW));
            console.log($($clone));
            $(':input', $clone).each(function(){
                $(this).val('');
            });
            $('.tts-media-prev', $clone).html('');
            
            $cloneW.append($clone);
            sort_stickers_key($cloneW);
        });
        
        $('.tts-stikers-ul').sortable({
            axis: "x",
            cursor: "move",
            distance: 5,
            connectWith: ">li",
            items: ">li",
            placeholder: "sortable-placeholder",
            forcePlaceholderSize: true,
            handle: '.tts-sahandle',
            update: function(event, ui){
                sort_stickers_key($(event.target));
            }
        });
        $('body').on('click', '.tts-delete-sticker', function(e){
            e.preventDefault();
            var $cloneW = $(this).closest('.tts-stikers-ul');
            if($cloneW.find('li').length <2){
                return false;
            }
            $(this).closest('li').remove();
            sort_stickers_key($cloneW);
        });
        $('.sd-visual-editor').each(function(){
            var fid = $(this).attr('id');
            tinyMCE && tinyMCE.execCommand("mceAddEditor", false, fid);
        });
    });
})(jQuery);