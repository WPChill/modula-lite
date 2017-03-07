<?php
  if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(_e('You are not allowed to call this page directly.','modula-gallery')); }
  
  $tg_subtitle = "New Gallery";
?>

    <?php include("header.php") ?>
    
   

<div id="modula-wizard" >
        <h2>  <?php _e('Add New Gallery','modula-gallery');  ?> </h2>
        <form action="#" method="post">
          <?php wp_nonce_field('Modula', 'Modula'); ?>
          <input type="hidden" name="enc_images" value="" />

        <fieldset data-step="1">
                <div class="row">
                    <div class="input-field">
                        <input name="tg_name" id="name" type="text" class="validate" required="required">
                        <label for="name"><?php _e('Name of the gallery','modula-gallery')?></label>
                    </div>
                </div>
                <div class="row">
                  <div class="input-field">
                      <input name="tg_description" id="description" type="text" class="validate">
                      <label for="description"><?php _e('Description of the gallery (for internal use)','modula-gallery')?></label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s6">
                    <input name="tg_width" id="width" type="text" value="100%">
                    <label for="width"><?php _e('Gallery width','modula-gallery')?></label>
                  </div>
                  <div class="input-field col s6">
                    <input name="tg_height" id="height" type="text" value="800">
                    <label for="height"><?php _e('Gallery height in pixels','modula-gallery')?></label>
                  </div>
                </div>
        </fieldset>
    <fieldset data-step="2" data-branch="images">
      <div class="field">
                <h5><?php _e('WordPress field for titles:','modula')?></h5>
              <select class="browser-default" name="ftg_wp_field_title">
                <option value="none">Don't use titles</option>
                <option value="title" selected>Title</option>
                <option value="description">Description</option>
              </select>               
            </div>
            <div class="field">
                <h5><?php _e('WordPress field for captions:','modula')?></h5>
              <select class="browser-default" name="ftg_wp_field_caption">
                <option value="none">Don't use captions</option>
                <option value="title">Title</option>
                <option value="caption" selected>Caption</option>
                <option value="description">Description</option>
              </select>               
            </div>            
        </fieldset>
        <fieldset data-step="3" data-save="true">
              <div class="field">
                  <h5><?php _e('Image size','modula-gallery')?></h5>
                  <div class="row">
                    <div class="input-field">
                        <input name="tg_img_size" id="img_size" type="text" class="validate" required="required" value="500">
                        <label for="name"><?php _e('Minimum width or height of images','modula-gallery')?></label>
                    </div>
                </div>
                <label class="shortpixel">
                    <img src="<?php echo plugins_url('',__file__) ?>/images/icon-shortpixel.png" alt="ShortPixel">
                  <a target="_blank" href="https://shortpixel.com/wp/af/N8LKGGT72393"><?php _e('We suggest you to use ShortPixel image optimization plugin for best SEO results.','modula-gallery')?></a></label>
             </div>
              <div class="field select-images">
                  <a class="waves-effect waves-light btn add-images">
                      <i class="mdi mdi-plus left"></i> <?php _e('Add images','modula-gallery')?></a>
                  <br>
                  <label><?php _e('You can add images now or later.','modula-gallery')?></label>
                  
                  <div class="images list-group"></div>
              </div> 
          </fieldset> 

         <footer class="page-footer">  
            <div class="progress loading hide">
              <div class="indeterminate"></div>
          </div>

          <a class="waves-effect waves-yellow btn-flat prev"><?php _e('Previous','modula-gallery')?></a>
          <a class="waves-effect waves-green btn-flat next"><?php _e('Next','modula-gallery')?></a>
        </footer>

        </form>
        <div id="success" class="modal">
            <div class="modal-content">
              <h4><?php _e('Success!','modula-gallery')?></h4>
              <p><?php _e('Your gallery','modula-gallery')?> "<span class="gallery-name"></span>" <?php _e('has been created. Copy the following shortcode:','modula-gallery')?><br>
                  <input type="text" class="code"><br>
                 <?php _e('and paste it inside a post or a page. Otherwise click','modula-gallery')?> <a class='customize'><?php _e('here','modula-gallery')?></a> <?php _e('to customize
                  the gallery.','modula-gallery')?>
              </p>
            </div>
            <div class="modal-'footer">
              <a href="?page=ModulaLite-admin" id="modal-close" class="waves-effect waves-green btn-flat modal-action"><?php _e('Close','modula-gallery')?></a>
            </div>
          </div>

        <div id="error" class="modal">
        <div class="modal-content">
          <h4><?php _e('Error!','modula-gallery')?></h4>
          <p><?php _e('For some reason it was not possible to save your gallery','modula-gallery')?></p>
        </div>
        <div class="modal-footer">
          <a href="?page=ModulaLite-admin" class="waves-effect waves-green btn-flat modal-action"><?php _e('Close','modula-gallery')?></a>
        </div>
      </div>
    </div>
