<?php
/**
 * Plugin Name:       Card Block
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Version:           2.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       card-block
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_card_block_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_card_block_block_init' );

function card_block_categories($categories, $post){
	 // Add the custom category.
	 $custom_category = [
        [
            'slug'  => 'CardBlock',
            'title' => 'Card Block',
        ]
    ];
    
    // Merge the custom category with the existing ones.
    return array_merge($custom_category, $categories);
}

add_filter( 'block_categories', 'card_block_categories', 10, 2 );