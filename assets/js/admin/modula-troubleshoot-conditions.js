jQuery(document).ready(function($){

    var master_toggle = jQuery("input#modula_troubleshooting_option-enqueue_files");
    var checked = master_toggle.is(':checked');
    mts_master_toggle(checked);

    master_toggle.on('change',function(){
        checked = master_toggle.is(':checked');
        mts_master_toggle(checked);
    });
});

function mts_master_toggle(checked){
    if(checked){
        jQuery('tr.troubleshoot-subfield').show();
    } else {
        jQuery('tr.troubleshoot-subfield').hide();
    }
}