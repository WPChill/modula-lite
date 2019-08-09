<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_Beaver {

    public function __construct() {
        add_action('init', array($this, 'include_beaver_block'));
    }

    public function include_beaver_block() {
        if (class_exists('FLBuilder')) {
            require_once 'modula-beaver-block.php';
        }
    }
}

$modula_beaver = new Modula_Beaver();