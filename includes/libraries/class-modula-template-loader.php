<?php

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
  require MODULA_PATH . 'includes/libraries/class-gamajo-template-loader.php';
}

/**
 *
 * Template loader for Modula.
 *
 * Only need to specify class properties here.
 *
 */
class Modula_Template_Loader extends Gamajo_Template_Loader {

  /**
   * Prefix for filter names.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $filter_prefix = 'modula';

  /**
   * Directory name where custom templates for this plugin should be found in the theme.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $theme_template_directory = 'modula';

  /**
   * Reference to the root directory path of this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * In this case, `MODULA_PATH` would be defined in the root plugin file as:
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $plugin_directory = MODULA_PATH;

  /**
   * Directory name where templates are found in this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * @since 1.1.0
   *
   * @var string
   */
  protected $plugin_template_directory = 'includes/public/templates';
}