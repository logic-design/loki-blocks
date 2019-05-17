<?php
/**
 * Plugin Name: Loki Blocks
 * Description: Blocks for use with the Loki theme, developed by Logic Design
 * Author: Logic Design & Consultancy Ltd
 * Author URI: https://www.logicdesign.co.uk/
 * Version: 1.0.5
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * @package Loki
 */

if (!defined('ABSPATH')){
	exit;
}

/**
 * Initialise blocks
 */
include plugin_dir_path(__FILE__) . 'blocks/expand/index.php';
include plugin_dir_path(__FILE__) . 'blocks/lead/index.php';
include plugin_dir_path(__FILE__) . 'blocks/accordion/index.php';
include plugin_dir_path(__FILE__) . 'blocks/button/index.php';
include plugin_dir_path(__FILE__) . 'includes/LogicPluginUpdater.php';

if ( is_admin() ) {
    new LogicPluginUpdater(__FILE__, 'logic-design', 'loki-blocks');
}

/**
 * Categorise blocks
 */
function loki_block_category($categories, $post) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'loki-blocks',
				'title' => __('Loki Blocks', 'loki-blocks'),
			),
		)
	);
}
add_filter('block_categories', 'loki_block_category', 10, 2);
