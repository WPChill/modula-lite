<?php
            $default_options = get_option('modula_options');
			foreach($imageResults as $image) { 
                $sizes = ModulaLiteTools::get_image_size_links($image->imageId);
                $thumb = array_key_exists("150x150", $sizes) ? $sizes["150x150"] : $image->imagePath;
            ?>
            <div class='item card' data-image-id="<?php echo absint($image->imageId) ?>" data-id="<?php echo absint($image->Id) ?>">
                <input type="hidden" name="filter-list" value="<?php echo absint($image->imageId) ?>">
                <div class="figure card-image" style="background-image: url('<?php echo esc_url($thumb) ?>');">
                    <img class="thumb" src="<?php echo plugins_url('../images/square.gif', __FILE__) ?>" />

                    <?php
                        if(!empty($image->filters))
                        {
                            echo "<ul class='filters'>";

                            foreach(explode('|', $image->filters) as $f)
                            {
                                if(in_array($f, $active_filters))
                                {
                                    echo '<li>' . esc_html( $f ) . '</li>';
                                }
                            }

                            echo "</ul>";

                 echo '<input type="hidden" class ="current_image_filter" value=' . esc_attr($image->filters) . '>';

                        } 


                    ?>
                   
                </div>
                 <div class="card-content">
                        <p class="truncate">
                            <?php echo (isset($image->title) && !empty($image->title)) ? esc_html($image->title) : esc_html($image->description) ?>
                        </p>    
                        <div class="data">
                            <input class="copy" type="hidden" name="id" value="<?php echo absint($image->Id); ?>" />
                            <input class="copy" type="hidden" name="img_id" value="<?php echo absint($image->imageId); ?>" />
                            <input class="copy" type="hidden" name="sortOrder" value="<?php echo absint($image->sortOrder); ?>" />
                            <input class="copy" type="hidden" name="filters" value="<?php echo esc_attr($image->filters); ?>" />
                            <select name="img_url" class="select">
                            <?php foreach($sizes as $k => $v) : ?>
                                <option <?php echo $v == $image->imagePath ? "selected" : "" ?> value="<?php echo esc_attr($v) ?>"><?php echo esc_html($k) ?></option>
                            <?php endforeach ?>
                            </select>
                            <input type="hidden" name="link" value="<?php echo esc_attr($image->link) ?>" />
                            <input type="hidden" name="target" value="<?php echo esc_attr($image->target) ?>" />
                            <input type="hidden" name="valign" value="<?php echo esc_attr($image->valign) ?>" />
                            <input type="hidden" name="halign" value="<?php echo esc_attr($image->halign) ?>" />
                            <input type="hidden" name="sortOrder" value="<?php echo absint($image->sortOrder) ?>" />
                            <pre><?php echo wp_kses_post($image->description) ?></pre>
                            <input id="img-title" value="<?php echo htmlentities($image->title) ?>"> 
                        </div>                       
                </div>

                <div class="card-action">
                    <a href="#" class="edit">
                        <span><?php echo esc_html__( 'Edit', 'modula-gallery' ) ?></span>                       
                    </a>
                       <a href="#" class="remove">
                        <span><?php echo esc_html__( 'Remove', 'modula-gallery' ) ?></span>                       
                      </a>
                </div>
                                
            </div>        
		  <?php }  ?> 