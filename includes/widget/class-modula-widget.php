<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(

        // Base ID of your widget
            'modula_gallery_widget',

            // Widget name will appear in UI
            __('Modula Gallery', 'modula-best-grid-gallery'),

            // Widget description
            array('description' => __('Modula Gallery', 'modula-best-grid-gallery'),)
        );
    }

    // Creating widget front-end
    public function widget($args, $instance) {

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        // This is where you run the code and display the output
        echo do_shortcode('[modula id="' . $instance['modula_widget_gallery_select'] . '"]');
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance) {

        $galleries = Modula_Helper::get_galleries();

        // Widget admin form
        ?>
        <p xmlns="http://www.w3.org/1999/html">
            <label for="<?php echo $this->get_field_id('modula_widget_gallery_select'); ?>"><?php esc_html_e('Select a Modula Gallery:', 'modula-best-grid-gallery'); ?></label>
            <select class="widefat" id="modula_widget_gallery_select"
                    name="<?php echo $this->get_field_name('modula_widget_gallery_select'); ?>">
                <?php
                foreach ($galleries as $gallery_id => $gallery_title) {
                    echo '<option value="' . esc_attr($gallery_id) . '" ' . selected($gallery_id, $instance['modula_widget_gallery_select'], true) . ' >' . esc_html($gallery_title) . '</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {

        $instance                                 = array();
        $instance['modula_widget_gallery_select'] = (!empty($new_instance['modula_widget_gallery_select'])) ? strip_tags($new_instance['modula_widget_gallery_select']) : '';

        return $instance;
    }
}

