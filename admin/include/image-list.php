<?php
            $default_options = get_option('modula_options');
			foreach($imageResults as $image) { 
                $sizes = ModulaLiteTools::get_image_size_links($image->imageId);
                $thumb = array_key_exists("150x150", $sizes) ? $sizes["150x150"] : $image->imagePath;
            ?>
            <div class='item card' data-image-id="<?php _e($image->imageId) ?>" data-id="<?php _e($image->Id) ?>">
                <input type="hidden" name="filter-list" value="<?php print $image->imageId ?>">
                <div class="figure card-image" style="background-image: url('<?php _e($thumb) ?>');">
                    <img class="thumb" src="<?php echo plugins_url('../images/square.gif', __FILE__) ?>" />

                    <?php
                        if(!empty($image->filters))
                        {
                            print "<ul class='filters'>";

                            foreach(explode('|', $image->filters) as $f)
                            {
                                if(in_array($f, $active_filters))
                                {
                                    print "<li> $f </li>";
                                }
                            }

                            print "</ul>";

                 print "<input type='hidden' class ='current_image_filter' value=$image->filters>";

                        } 


                    ?>
                   
                </div>
                 <div class="card-content">
                        <p class="truncate">
                            <?php print (isset($image->title) && !empty($image->title)) ? $image->title : $image->description ?>
                        </p>    
                        <div class="data">
                            <input class="copy" type="hidden" name="id" value="<?php _e($image->Id); ?>" />
                            <input class="copy" type="hidden" name="img_id" value="<?php _e($image->imageId); ?>" />
                            <input class="copy" type="hidden" name="sortOrder" value="<?php _e($image->sortOrder); ?>" />
                            <input class="copy" type="hidden" name="filters" value="<?php _e($image->filters); ?>" />
                            <select name="img_url" class="select">
                            <?php foreach($sizes as $k => $v) : ?>
                                <option <?php print $v == $image->imagePath ? "selected" : "" ?> value="<?php print $v ?>"><?php print $k ?></option>
                            <?php endforeach ?>
                            </select>
                            <input type="hidden" name="link" value="<?php _e($image->link) ?>" />
                            <input type="hidden" name="target" value="<?php _e($image->target) ?>" />
                            <input type="hidden" name="valign" value="<?php _e($image->valign) ?>" />
                            <input type="hidden" name="halign" value="<?php _e($image->halign) ?>" />
                            <input type="hidden" name="sortOrder" value="<?php _e($image->sortOrder) ?>" />
                            <pre><?php _e($image->description) ?></pre>
                            <input id="img-title" value="<?php print $image->title ?>"> 
                        </div>                       
                </div>

                <div class="card-action">
                    <a href="#" class="edit">
                        <span>Edit</span>                       
                    </a>
                       <a href="#" class="remove">
                        <span>Remove</span>                       
                      </a>
                </div>
                                
            </div>        
		  <?php }  ?> 