(function(){
    tinymce.create('tinymce.plugins.Modula', {
        init : function(ed, url)
        {
            ed.addCommand('modula_shortcode_editor', function(){
                ed.windowManager.open(
                    {
                        file: ajaxurl + '?action=modula_shortcode_editor',
                        width: 900 + parseInt(ed.getLang('button.delta_width', 0)),
                        height: 500 + parseInt(ed.getLang('button.delta_height', 0)),
                        inline: 1
                    }, {
                        plugin_url : url
                    });
                
            });

            var assets_url = url.split('assets/');

            ed.addButton('modula_shortcode_editor', {title: 'Modula Gallery', cmd : 'modula_shortcode_editor', image: assets_url[0] + 'assets/images/modula-logo.jpg'});
        },
        getInfo : function()
        {
            return {
				longname : 'Modula Gallery',
				author : 'Macho Themes',
				authorurl : 'https://www.machothemes.com/',
				infourl : 'https://www.machothemes.com/',
                version : tinymce.majorVersion + "." + tinymce.minorVersion
            };
        }
    });
    tinymce.PluginManager.add('modula_shortcode_editor', tinymce.plugins.Modula);
})();
