<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo esc_html__('Modula Galleries', 'modula-best-grid-gallery'); ?></title>
    <script>
        var wpColorPickerL10n = {
            "clear": "Clear",
            "defaultString": "Default",
            "pick": "Select Color",
            "current": "Current Color"
        };
    </script>
    <script type="text/javascript"
            src="<?php echo esc_url($admin_url); ?>/load-scripts.php?c=1&load%5B%5D=jquery-core,jquery-migrate,utils,jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-draggable,jquery-ui-slider,jquery-tou&load%5B%5D=ch-punch,iris,wp-color-picker"></script>
    <link rel="stylesheet"
          href="<?php echo esc_url(admin_url('load-styles.php?c=1&dir=ltr&load=buttons,wp-admin,iris,wp-color-picker')); ?>"
          type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo esc_url($css_path); ?>">
    <script language="javascript" type="text/javascript"
            src="<?php echo esc_url(includes_url('js/tinymce/tiny_mce_popup.js') . '?ver=' . $wp_version); ?>"></script>
    <style type="text/css">
        h1 {
            color: black;
        }

        body {
            overflow-y: scroll;
            padding: 5px 20px 100px 20px;
            height: auto;
        }

        #galleries {
            width: 100%;
            border-collapse: collapse;
        }

        tr:nth-child(1) {
            background-color: #90caf9;
        }

        tr {
            background-color: #e3f2fd;
            cursor: pointer;
        }

        tr:not(:nth-child(1)):hover {
            background-color: #bbdefb;
        }

        #galleries td, #galleries th {
            border: 1px solid white;
            padding: 10px;
        }

        .modula-logo-center span,
        .modula-logo-center img {
            display: inline-block;
            vertical-align: middle;
        }

        .modula-logo-center img {
            max-width: 75px;
            height: auto;
        }
    </style>
</head>
<body class="popup">
<h1 class="modula-logo-center"><span><?php echo esc_html__('YOUR GALLERIES:', 'modula-best-grid-gallery'); ?></span>
    <img src="<?php echo esc_url(MODULA_URL . 'assets/images/modula-logo.jpg'); ?>" class="modula-logo-center"></h1>
<br>
<table id="galleries">
    <!-- list here galleries -->
    <!-- loop variable $galleries -->
    <?php if( 1 == count( $galleries ) ) {?>

    <p> <?php echo esc_html__( 'You don’t have a gallery created, please go and add one','modula-best-grid-gallery') ?> </p>
    
    <?php  } else { ?>
    <tr>
        <td>
            <b> <?php echo esc_html__('Name', 'modula-best-grid-gallery'); ?> </b>
        </td>
        <td>
            <b> <?php echo esc_html__('Type', 'modula-best-grid-gallery'); ?> </b>
        </td>
        <td>
            <b> <?php echo esc_html('ID'); ?> </b>
        </td>
    </tr>
    <?php foreach ($galleries as $gallery => $value):
        if ('none' != $gallery) {
            ?>
            <tr>
                <td>
                    <label id="<?php echo esc_attr($gallery); ?>"> <?php echo esc_html($value); ?> </label>
                </td>

                <td>
                    <?php echo !empty($gallery->source) ? esc_html( $gallery->source ) : esc_html__("Images", "modula-best-grid-gallery"); ?>
                </td>

                <td>
                    <?php echo esc_html( $gallery ); ?>
                </td>
            </tr>
        <?php } ?>
    <?php endforeach; ?>
        <?php } ?>
</table>
<!-- // Select form in case we go with select input
<div class="form-table">
    <select id="classic-editor-modula-gallery-select" class="select-dropdown">
        <?php /*foreach ($galleries as $gallery => $value) {
            if ('none' != $gallery) {
                */ ?>
                <option value="<?php /*echo esc_attr($gallery); */ ?>"><?php /*echo esc_html($value); */ ?></option>
            <?php /*}
        } */ ?>
    </select>
</div>
-->
<script>
    jQuery("#galleries tr").click(function () {
        var id = jQuery(this).find('label').attr('id');
        top.tinymce.activeEditor.insertContent('[modula id="' + id + '"]');
        top.tinymce.activeEditor.windowManager.close();
    });

    // Select functionality in case we go with select input
    /*jQuery("select#classic-editor-modula-gallery-select option").click(function (e) {
        var id = jQuery(this).val();
        top.tinymce.activeEditor.insertContent('[modula id="' + id + '"]');
        top.tinymce.activeEditor.windowManager.close();
    });*/
</script>
</body>
</html>