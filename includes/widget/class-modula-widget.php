<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_Widget extends WP_Widget {

    /**
     * Modula_Widget constructor.
     */
    function __construct() {
        parent::__construct(

        // Base ID of widget
            'modula_gallery_widget',

            // Widget name
            __('Modula Gallery', 'modula-best-grid-gallery'),

            // Widget description
            array('description' => __('Modula Gallery Widget.', 'modula-best-grid-gallery'),)
        );

        add_action('siteorigin_panel_enqueue_admin_scripts', array($this, 'enqueue_page_builder_scripts'));
    }

    /**
     * @param array $args
     * @param array $instance
     *
     * Widget Front End
     */
    public function widget($args, $instance) {

        $title = (isset($instance['title'])) ? apply_filters('widget_title', $instance['title']) : '';

        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        // Output Modula Gallery
        echo isset($instance['modula_widget_gallery_select']) ? do_shortcode('[modula id="' . $instance['modula_widget_gallery_select'] . '"]') : '';;

    }

    /**
     * @param array $instance
     * @return string|void
     *
     * Widget options
     */
    public function form($instance) {

        // get Modula Galleries
        $galleries = Modula_Helper::get_galleries();

        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Widget Title', 'wpb_widget_domain');
        }

        ?>
        <p xmlns="http://www.w3.org/1999/html">
            <!-- Widget Title -->
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>

            <!-- Modula Gallery select option -->
            <label for="<?php echo esc_attr($this->get_field_id('modula_widget_gallery_select')); ?>"><?php esc_html_e('Select a Modula Gallery:', 'modula-best-grid-gallery'); ?></label>
            <select class="widefat" id="modula_widget_gallery_select"
                    name="<?php echo esc_attr($this->get_field_name('modula_widget_gallery_select')); ?>">
                <?php
                foreach ($galleries as $gallery_id => $gallery_title) {
                    echo '<option value="' . esc_attr($gallery_id) . '" ' . selected($gallery_id, $instance['modula_widget_gallery_select'], true) . ' >' . esc_html($gallery_title) . '</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     *
     * Widget Update
     */
    public function update($new_instance, $old_instance) {

        $instance                                 = array();
        $instance['title']                        = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['modula_widget_gallery_select'] = (!empty($new_instance['modula_widget_gallery_select'])) ? strip_tags($new_instance['modula_widget_gallery_select']) : '';

        return $instance;
    }

    /**
     * Enqueue needed scripts in the admin required for pagebuilder preview
     */
    public function enqueue_page_builder_scripts() {
        // only enqueue for SiteOrigin page builder
        if (class_exists('SiteOrigin_Panels')) {

            // get siteOrigin panel settings so that we enqueue scripts and styles only where we need them
            $siteorigin_post_types = get_option('siteorigin_panels_settings');
            $current_screen        = get_current_screen();
            // check if is set, else set to defaults
            $so_posts = (isset($siteorigin_post_types['post-types'])) ? $siteorigin_post_types['post-types'] : array('post', 'page');

            if (in_array($current_screen->post_type, $so_posts)) {
                wp_register_style('modula', MODULA_URL . 'assets/css/modula.min.css', null, MODULA_LITE_VERSION);
                wp_register_script('modula-preview', MODULA_URL . 'assets/js/jquery-modula.min.js', array('jquery'), MODULA_LITE_VERSION, true);
                wp_register_script('modula-siteorigin-preview', MODULA_URL . 'assets/js/modula-siteorigin-preview.js', array('jquery'), MODULA_LITE_VERSION, true);

                wp_enqueue_style('modula');
                wp_enqueue_script('modula-preview');
                wp_enqueue_script('modula-siteorigin-preview');
            }
        }
    }
}

