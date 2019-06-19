jQuery(function($){
    elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
        $(document).trigger('modula-update');
    } );
});