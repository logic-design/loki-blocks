<?php
	if (!defined('ABSPATH')) {
		exit;
	}

	/**
	 * Enqueue Editor Assets
	 */
	function loki_block_lead_editor_assets() {
		wp_enqueue_script('loki-block-lead-block-js', plugins_url('lead/index.js', dirname(__FILE__)), array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor'), true);
		wp_enqueue_style('loki-block-lead-editor-css', plugins_url('lead/editor.css', dirname(__FILE__)), array('wp-edit-blocks'));
	}
	add_action('enqueue_block_editor_assets', 'loki_block_lead_editor_assets');