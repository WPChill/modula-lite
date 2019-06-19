jQuery(function($){
    elementor.hooks.addAction( 'panel/open_editor/widget/modula_elementor_gallery', function( panel, model, view ) {
        var gallery_select = panel.$el.find('select[data-setting="modula_gallery_select"]');
        gallery_select.on('change',function(){
            var option = $(this).find('option:selected');
            if('none' != option.val()){
                $(document).trigger('modula-update');
            }
        });
    } );
});