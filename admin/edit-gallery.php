    <?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(_e('You are not allowed to call this page directly.','modula-gallery')); }

	function modula_print_value($gallery, $field, $default = NULL)
    {            
        if($gallery == NULL || $gallery->$field === NULL) 
        {
            if($default === NULL)
            {
                print "";
            }
            else
            {
                print stripslashes($default);
            }
        } 
        else 
        {
            print stripslashes($gallery->$field);
        }
    }

	$galleryResults = $this->ModulaDB->getGalleries();

    $gallery = $this->loadedData;
    $tg_subtitle = "Edit Gallery: " . $gallery->name;

	include("header.php");

 ?>       

    <script>
        var modula_wp_caption_field = '<?php modula_print_value($gallery, "wp_field_caption")  ?>';
    </script>
    <div class="row collapsible">
	    <div class="col s12 m6 l4">
		    <div class="card-panel light-green lighten-4">
			    <span> Shortcode: </span>
			    <input type="text" readonly value="[Modula id='<?php print $gallery->id; ?>']"> </input>
		    </div>
	    </div>
	    <div class="col s12 m6 l4">
		    <div class="card-panel lime lighten-4">
		    <strong>TIP</strong>: blurry images? Try using a higher <i>Minimum image size</i> value!
		    </div>
	    </div>
    </div>

         <span class='setting'>Settings:</span>

        <p class="import-export">
             <a id='import' href="#">Import</a>
             <a id='export' href="#">Export</a>
       </p>
       
        <ul class="collapsible" data-collapsible="accordion">
        <?php foreach($modula_fields as $section => $s): ?>
            <li id="<?php print strtolower(str_replace(' ', '-', $section)); ?>"> 
                <div  class="collapsible-header white-text  darken-2">
                    <i class="<?php _e($s["icon"]) ?>"></i> <span><?php _e($section) ?> </span>
                    <i class="icon icon-chevron-right"></i>
                </div>

                <div class="collapsible-body lighten-5 tab form-fields"> 
                    <div class="jump-head">
                        <?php
                            $jumpFields = array();
                            foreach($s["fields"] as $f => $data)
                            {
                                $jumpFields[$f] = $data;
                                $jumpFields[$f]['_code'] = $f;
                            }
                            unset($f);
                            unset($data);
                        ?> 
                        <select class="browser-default jump">
                            <option><?php _e('Jump to setting','modula-gallery')?></option>
                        <?php foreach($jumpFields as $f => $data) : ?>                                              
                            <option value="<?php _e($data['_code']) ?>">
                                <?php _e($data["name"]); ?>
                            </option>
                            <?php endforeach; ?>
                            </select>
                    </div>
            <input type="hidden" id="wp_caption" value="<?php print $gallery->wp_field_caption ?>" >
            <input type="hidden" id="wp_title" value="<?php print $gallery->wp_field_title ?>" >

            <form name="gallery_form" id="gallery_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
              <?php  wp_nonce_field('Modula', 'Modula'); ?>
            <input type="hidden" name="ftg_gallery_edit" id="gallery-id" value="<?php _e($gallery->id); ?>" />
            <table class="widefat post fixed" cellspacing="0">              
                </tbody>
            </table>
            </form>  

            <table>                        
                    <tbody>                    
                <?php foreach($s["fields"] as $f => $data) : ?>
                    <?php if(is_array($data["excludeFrom"]) && ! in_array($modula_parent_page, $data["excludeFrom"])) : ?>                    
                    <tr class="row-<?php print $f ?> <?php print $data["type"] ?>">                     
                        <th scope="row">
                            <label class="label-text"><?php _e($data["name"]); ?>
                                <?php if(isset($data["mu"])) : ?>
                                (<?php _e($data["mu"]) ?>)
                                <?php endif ?>
                                </label>
                        </th>
                        <td>                        
                        <div class="field">
                        <?php if($data["type"] == "text") : ?>                          
                            <div class="text">                            
                                <input type="text" size="30" name="tg_<?php print $f ?>" value="<?php print $gallery->$f ?>" /> 
                            </div>
                        <?php elseif($data["type"] == "select") : ?>

                            <div class="text">
                                <select class="browser-default dropdown-menu" name="tg_<?php print $f ?>" >
                                    <?php foreach(array_keys($data["values"]) as $optgroup) : ?>
                                        <optgroup label="<?php print $optgroup  ?>">
                                            <?php foreach($data["values"][$optgroup] as $option) : ?>
    
                                                <?php $v = explode("|", $option); ?>
                                                <option value="<?php print $v[0] ?>" <?php print $v[0] == $gallery->$f ? "selected" : "" ?> ><?php print $v[1] ?></option>
                                            <?php endforeach ?>
                                        </optgroup>
                                    <?php endforeach ?>
                                    <?php if(isset($data["disabled"])) : ?>
                                    <?php foreach(array_keys($data["disabled"]) as $optgroup) : ?>
                                        <optgroup label="<?php print $optgroup  ?>">
                                            <?php foreach($data["disabled"][$optgroup] as $option) : ?>
    
                                                <?php $v = explode("|", $option); ?>
                                                <option disabled><?php print $v[1] ?></option>
                                            <?php endforeach ?>
                                        </optgroup>
                                    <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                        <?php elseif($data["type"] == "toggle") : ?>
                         <div class="text"> 
                                <input type="checkbox" id="ftg_<?php print $f ?>" name="tg_<?php print $f ?>" value="<?php print $gallery->$f ?>" <?php print $gallery->$f=='T' ? 'checked' : '' ?> />
                                <label for="ftg_<?php print $f ?>"><?php _e($data["description"]); ?></label>
                            </div>

                        <?php elseif($data["type"] == "ui-slider") : ?>  
                            <div class="text">
                                <label class="effect-description"><?php print $data['description'] ?></label>
                                <p class="range-field">
                                  <input name="tg_<?php print $f ?>" value="<?php print $gallery->$f ?>" type="range" min="<?php print $data["min"] ?>" max="<?php print $data["max"] ?>" />
                                </p>
                            </div>
                            
                        <?php elseif($data["type"] == "number") : ?>
                            <div class="text">
                                <input type="text" name="tg_<?php print $f ?>" class="integer-only"  value="<?php print $gallery->$f; ?>"  > 
                            </div>
                                
                        <?php elseif($data["type"] == "color") : ?>
                            <div class="text">
                            <label class="effect-description effect-color" style="display:none;"> <?php print $data['description'] ?></label>
                            <input type="text" size="6" data-default-color="<?php print $data["default"] ?>" name="tg_<?php print $f ?>" value="<?php print $gallery->$f  ?>" class='pickColor' />                          </div>
						<?php elseif($data["type"] == "PRO_FEATURE") : ?>

                            <div class="pro-cell">
                                <a href="http://modula.greentreelabs.net/?utm_source=modulalite_inst&utm_medium=banner&utm_campaign=Modula%20Lite#buy" target="_blank">Unlock this feature, buy full version <i class="mdi-content-send
"></i></a>
                            </div>

                        <?php elseif($data["type"] == "textarea") : ?>
                        <div class="text">
                            <textarea name="tg_<?php print $f ?>"><?php print $gallery->$f ?></textarea>
                        </div>
						<?php elseif($data["type"] == "hover-effect"): ?>
                    		
                            <div class="text">
                               <label class="effect-description"> <?php print $data['description']; ?> </label>                               
                               <select name="tg_hoverEffect" class="select-effect">
	                               <?php $hoverEffectIdx = 0 ?>	                     
                                   <option value="none">None</option>          
                                   <optgroup label="Buy a PRO license to unlock all hover effects">
                                    <option disabled></option>
								    <?php foreach($this->hoverEffects as $effect) : ?>								                                      								   
								        <option <?php print $effect->code != "pufrobo" ? "disabled" : null ?> <?php print ($gallery->hoverEffect == strtolower($effect->code) ? "selected" : null) ?> value="<?php print $effect->code ?>"><?php print $effect->name ?></option>
									<?php endforeach ?>
								   </optgroup>
                               </select>
                               <a class="all-effects" href="http://modula.greentreelabs.net/demo/effects/appear/?utm_source=modulalite_inst&utm_campaign=Modula%20Lite&utm_medium=banner&utm_term=all%20effects" target="_blank"><i class="mdi mdi-comment-alert-outline"></i> Click to see all available effects</a>

                               <!-- all effects preview -->
                                <div class="preview modula">
                                    <div class="panel panel-pufrobo items clearfix">
                                        <!-- show preview -->

                                        <div class="item effect-pufrobo" >
                                            <img  src="<?php print plugins_url() ?>/modula-best-grid-gallery/admin/images/effect.jpg" class="pic">                                        
                                            <div class="figc">
	                                            <div class="figc-inner">
		                                            
	                                                <h2>Lorem ipsum</h2>
	                                                <p class="description">Quisque diam erat, mollis vitae enim eget</p>
		                                            <div class="jtg-social">
		                                                <a class="icon icon-twitter" href="#"></a>
		                                                <a class="icon icon-facebook" href="#"></a>
		                                                <a class="icon icon-google-plus" href="#"></a>
		                                                <a class="icon icon-pinterest" href="#"></a>
		                                            </div>
	                                            </div>
                                            </div>                                            
                                        </div>


                                        <div class="effect-compatibility" >

                                            <label class="effect-description">This effect is compatible with:
                                                <span><i class="icon icon-check-mark-2"></i> Title </span>
                                                <span><i class="icon icon-check-mark-2"></i> Subtitle </span>
                                                <span><i class="icon icon-check-mark-2"></i> Social icons </span>
                                            </label>
                                        </div>                                
                                    </div>
                                </div>
                                <input type="hidden" name="ftg_hoverColor" value="#000">
                                <input type="hidden" name="ftg_hoverOpacity" value="#.8">
                                <div class="pro-cell">
	                                <a href="http://modula.greentreelabs.net/?utm_source=modulalite_inst&utm_medium=banner&utm_campaign=Modula%20Lite#buy" target="_blank">Buy a PRO license to unlock <strong>Hover background color</strong> and <strong>Hover opacity</strong> <i class="mdi-content-send
	"></i></a>
	                            </div>
                            </div>                                                    
                        <?php endif ?>
                        <div class="help">
                            <?php _e($data["description"]); ?>
                        </div>

                        </div>
                        </td>                       
                        </tr>                       
                    <?php endif ?>     
                <?php endforeach ?>

                </tbody>
                </table>  
                </div>
            </li>
        <?php endforeach; ?>

        <li id="images">
           <div class="collapsible-header white-text white darken-2">
                 <i class="mdi mdi-image-filter"></i> <span><?php _e('Images','Modula-gallery')?> </span>
                    <i class="icon icon-chevron-right"></i>                 
            </div>

            <div class="collapsible-body white lighten-5">
                <div class="image-size-section">
                    <div>
                        <div class="tips">
                            <span class="shortpixel">
                            <img src="<?php echo plugins_url('',__file__) ?>/images/icon-shortpixel.png" alt="ShortPixel">
                          <a target="_blank" href="https://shortpixel.com/wp/af/N8LKGGT72393"><?php _e('We suggest you to use ShortPixel image optimization plugin for best SEO results.','modula-gallery')?></a></span>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="">
                        <span class="tip">For multiple selections: Click+CTRL.</span>
                    </div>
                    <div class="actions row">
                        <a href="#" class="open-media-panel waves-effect button-bg waves-light btn action"><i class="mdi-image-photo"></i> <?php _e('Add images','Modula-gallery')?></a>
                    </div>

                    <div class="bulk row">
                        <label class="label-text row"><?php _e('Bulk Actions','modula-gallery')?></label>
                                <div class="options">
                                    <a class="btn button-bg waves-effect waves-light" href="#" data-action="select"><?php _e('Select all','modula-gallery')?></a>
                                    <a class="btn button-bg waves-effect waves-light" href="#" data-action="deselect"><?php _e('Deselect all','modula-gallery')?></a>
                                    <a class="btn button-bg waves-effect waves-light" href="#" data-action="toggle"><?php _e('Toggle selection','modula-gallery')?></a>
                                    <a class="btn button-bg waves-effect waves-light" href="#" data-action="remove"><?php _e('Remove','modula-gallery')?></a>
                                </div>
                        <div class="panel">
                            <strong></strong>
                            <p class="text"></p>
                            <p class="buttons">
                                <a class="btn deep-orange darken-2 mrm cancel" href="#" ><?php _e('Cancel','modula-gallery')?></a>
                                <a class="btn green mrm proceed firm" href="#"><?php _e('Proceed','modula-gallery')?></a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <span class="tip"><?php _e('Drag images to change order.','modula-gallery')?></span>
                    </div>

                    <div id="image-list"></div>

                    <!-- image panel -->
                    <div id="image-panel-model" style="display:none">
                        <a href="#" class="close" title="Close">X</a>
                            <h4> <?php _e('Edit Image','modula-gallery')?> </h4>
                        <div class="clearfix">
                            <div class="left">
                                <div class="figure"></div>
                            </div>
                            <div class="editimage-right" >
                                <div class="field">
                                     <label><?php _e('Title','modula-gallery')?></label>
                                        <div class="text">
                                            <textarea id="item-title" name="title"></textarea>
                                        </div>
                                    <label><?php _e('Caption','modula-gallery')?></label>
                                    <div class="text">
                                        <textarea id="item-description" name="description"></textarea>
                                    </div>
                                </div>

                                <div class="field">
                                    <label for="alignment"><?php _e('Alignment','modula-gallery')?></label>
                                    <select name="halign">
                                        <option><?php _e('left','modula-gallery')?></option>
                                        <option selected><?php _e('center','modula-gallery')?></option>
                                        <option><?php _e('right','modula-gallery')?></option>
                                    </select>
                                    <select name="valign">
                                        <option><?php _e('top','modula-gallery')?></option>
                                        <option selected><?php _e('middle','modula-gallery')?></option>
                                        <option><?php _e('bottom','modula-gallery')?></option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label><?php _e('Link','modula-gallery')?></label>
                                    <div class="text">
                                        <!-- <input type="text" name="link" value="" class="text-input row">  -->
                                        <textarea id="item-link" name="link"></textarea>
                                        <select name="target">
                                            <option value=""><?php _e('Default target','modula-gallery')?></option>
                                            <option value="_self"><?php _e('Open in same page','modula-gallery')?></option>
                                            <option value="_blank"><?php _e('Open in _blank','modula-gallery')?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field filters clearfix"></div>
                            </div>
                        </div>
                        <div class="field buttons">
                            <a href="#" data-action="cancel" class="action modal-action modal-close waves-effect waves-yellow btn-flat"><i class="mdi-content-reply"></i> <?php _e('Cancel','modula-gallery')?></a>
                            <a href="#" data-action="save" class="action modal-action modal-close waves-effect waves-green btn-flat"><i class="icon icon-save-disk"></i> <?php _e('Save','modula-gallery')?></a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>

<a id="edit-gallery" data-tooltip="Update gallery" data-position="top" data-delay="10" class="tooltipped btn-floating btn-large waves-effect waves-light green update-gallery">
<i class="icon icon-save-disk"> </i>
</a>
<div class="fixed-action-btn bullet-menu">
    <a class="btn-floating btn-large green darken-1 right back-to-top">
      <i class="icon icon-angle-up"></i>
    </a>
    <ul>
        <?php foreach($modula_fields as $section => $s) : ?>
        <li>
        <a class="btn-floating green" rel="<?php print strtolower(str_replace(' ', '-', $section)) ?>"><i class="small <?php _e($s["icon"]) ?>"></i></a>
        </li>
        <?php endforeach ?>
        <li><a class="btn-floating green" rel="images"><i class="small mdi mdi-image-filter"></i></a></li>
    </ul>
</div>

<div class="preloader-wrapper big active" id="spinner">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>

         <div id="import-modal" class="modal">
    <div class="modal-content">
      <h3> Import Configuration</h3>
      <p> Paste here the configuration code </p>
      <textarea> </textarea>
      
    </div>
    <div class="modal-footer">
      <a id="save" href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php _e('Import','modula-gallery')?></a>

      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php _e('Close','modula-gallery')?></a>
    </div>
</div>

<div id="export-modal" class="modal">
    <div class="modal-content">
      <h3>Export Configuration</h3>
      <p>Copy the configuration code</p>
      <textarea readonly></textarea>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php _e('OK','modula-gallery')?></a>
    </div>
</div>

<script>
            (function ($) {
                TG.load_images();
                TG.init_gallery();                 
            })(jQuery);
        </script>
