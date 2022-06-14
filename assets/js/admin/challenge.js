jQuery(document).ready(function($){

    	// Dismiss challenge on cancel
	$('body').on('click','#modula-challenge-close',function (e) {
        e.preventDefault();
        set_challenge_hidden()

	});

    // Dismiss challenge on start
    $('body').on('click',' #modula-challenge-button',function (e) {
        e.preventDefault();
        set_challenge_hidden();
        location.href = $(this).attr('href');

    });

    function set_challenge_hidden(){
        jQuery.ajax({
            url: modulaChallenge.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'modula_challenge_hide',
                'nonce' : modulaChallenge.nonce
            },
            success: function( ) {
                $( '.modula-challenge-wrap' ).fadeOut( 200, function() {
                    $( '.modula-challenge-wrap' ).remove();
                });
            }
        });
    }
});
