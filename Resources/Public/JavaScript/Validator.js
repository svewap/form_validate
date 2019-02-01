
(function( $ ){

    $.fn.ajaxFormValidator = function(form) {
        var $this = $(this);

        //get the starting position of each element to have parallax applied to it
        $this.each(function(){

            var $this = $(this);

            $('input,textarea',$this).on('keyup', function(el) {
                if (el.originalEvent.key === 'Tab') return;
                delay(function(){
                    //console.debug(el);
                    sendValidationRequest($this,$(el.currentTarget));
                }, 1000 );
            }).on('keypress', function(el) {

                //$(el.currentTarget).next('.invalid-feedback').slideUp('normal', function() { $(this).prev().removeClass('is-invalid'); $(this).remove(); } );

            }).on('blur', function(el) {
                sendValidationRequest($this,$(el.currentTarget));
            });
            
            $('input[type="radio"],input[type="checkbox"]',$this).on('click', function(el) {
                sendValidationRequest($this,$(el.currentTarget));
            });
        });


        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();


        var sendValidationRequest = function(form, target) {
            
            $.ajax({
                type: "POST",
                url: form.attr('data-ajax-validation'),
                data: form.serialize()+'&cid='+form.parent().attr('id').slice(1),
                success: function(data) {
                    
                    if(typeof(formValidationCallback) === 'function') {
                        formValidationCallback(form, target, data);
                    } else {
                        handleErrors(form, target, data);
                    }
                    
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });

        }
        
        var handleErrors = function(form, target, data) {
            var errorFound = false;
            
            $.each( data, function( identifier, errors ) {
            
                if (form.attr('id') + '-' + identifier !== target.attr('id')) return;
            
                if (errors[0] !== undefined) {
                    errorFound = true;
                }
            
                if (errors[0] !== undefined && $('#' + form.attr('id') + '-' + identifier).next('div[data-code="' + errors[0].code + '"]').length === 0) {
                    // new error
                    $('<div/>').attr('data-code', errors[0].code).addClass('invalid-feedback').html(errors[0].message).css('display', 'none').insertAfter($('#' + form.attr('id') + '-' + identifier).removeClass('is-valid').addClass('is-invalid')).slideDown();
            
                    errorFound = true;
                }
            
                // remove all other error messages
                $('div[data-code!="' + errors[0].code + '"]',target.parent()).slideUp('normal', function() { $(this).remove(); } );
            });
            
            if (!errorFound) {
                target.addClass('is-valid').removeClass('is-invalid').next('.invalid-feedback').slideUp('normal', function() { $(this).remove(); } );
            }
        }

    };
})(jQuery);


(function($) {
    $(function() {

        $('form.ajax-validation').ajaxFormValidator();

    });
})(jQuery);
