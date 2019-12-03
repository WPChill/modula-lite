jQuery(document).ready(function($){

    var master_toggle = jQuery("input#modula_troubleshooting_option");
    var checked = master_toggle.is(':checked');
    mts_master_toggle(checked);

    master_toggle.on('change',function(){
        checked = master_toggle.is(':checked');
        mts_master_toggle(checked);
    });
});

function mts_master_toggle(checked){
    if(checked){
        jQuery('tr[data-settings="grid_type"], tr[data-settings="lightbox"],tr[data-settings="deeplink"]').show();
    } else {
        jQuery('tr[data-settings="grid_type"], tr[data-settings="lightbox"],tr[data-settings="deeplink"]').hide();
    }
}