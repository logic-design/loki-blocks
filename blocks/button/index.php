<?php
	if (!defined('ABSPATH')) {
		exit;
	}

	/**
	 * Enqueue Editor Assets
	 */
	function loki_block_button_editor_assets() {
		wp_enqueue_script('loki-block-button-block-js', plugins_url('button/index.js', dirname(__FILE__)), array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), true);
		wp_enqueue_style('loki-block-button-editor-css', plugins_url('button/editor.css', dirname(__FILE__)), array('wp-edit-blocks'));
	}
	add_action('enqueue_block_editor_assets', 'loki_block_button_editor_assets');