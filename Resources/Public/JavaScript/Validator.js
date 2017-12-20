
(function( $ ){

    $.fn.ajaxFormValidator = function(form) {
        var $this = $(this);

        //get the starting position of each element to have parallax applied to it
        $this.each(function(){

            var $this = $(this);

            $('input,textarea',$this).keyup(function(el) {
                if (el.originalEvent.key === 'Tab') return;
                delay(function(){
                    //console.debug(el);
                    sendValidationRequest($this,$(el.currentTarget));
                }, 1000 );
            }).keypress(function(el) {

                $(el.currentTarget).removeClass('is-invalid').next('.invalid-feedback').remove();

            }).focusout(function(el) {
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

                    target.removeClass('is-invalid').next('.invalid-feedback').remove();

                    $.each( data, function( identifier, errors ) {

                        if (form.attr('id')+'-'+identifier !== target.attr('id')) return;

                        $.each(errors, function(key, error) {
                            //console.debug(error.message);

                            $('#'+form.attr('id')+'-'+identifier).addClass('is-invalid').after($('<div/>').addClass('invalid-feedback').html(error.message));

                        });
                    });

                    if (!target.hasClass('is-invalid')) target.addClass('is-valid');
                }
            });

        }

    };
})(jQuery);


(function($) {
    $(function() {

        $('form.ajax-validation').ajaxFormValidator();

    });
})(jQuery);