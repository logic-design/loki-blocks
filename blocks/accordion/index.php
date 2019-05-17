<?php if ( ! defined('ABSPATH')) { exit; }

if ( ! class_exists( 'Loki_Accordion_Block' ) ) {
	class Loki_Accordion_Block
	{
		public $counter = 0;

		public function __construct()
		{
			if ( is_admin() ) {
				add_action( 'admin_init', array( $this, 'admin_init' ) );
			} else {
				add_action( 'init', array( $this, 'init' ) );
			}
		}

		public function init()
		{
			wp_enqueue_style( 'loki-accordion-css', plugin_dir_url( __FILE__ ) . 'accordion.css', null, filemtime( plugin_dir_path( __FILE__ ) . 'accordion.css' ));
		}

		public function admin_init()
		{
			if ( function_exists( 'register_block_type' ) ) {

				wp_register_script('loki-accordion-js', plugin_dir_url( __FILE__ ) . 'index.js', array( 'wp-editor', 'wp-i18n', 'wp-element' ), filemtime( plugin_dir_path( __FILE__ ) . 'index.js' ));
				wp_register_style('loki-accordion-css', plugin_dir_url( __FILE__ ) . 'editor.css', array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ));

				register_block_type( 'loki/accordion', array(
					'editor_script' => 'loki-accordion-js',
					'editor_style'  => 'loki-accordion-css'
				));
			}
		}
	}
}

new Loki_Accordion_Block();