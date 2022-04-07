<?php

/**
 * Plugin Name:       MetaBox Plugin
 * Plugin URI:        https://osmanforhad.net/plugins/practice/
 * Description:       CBX WordPress Plugin Development Intern MetaBox.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      8.1
 * Author:            osman forhad
 * Author URI:        https://author.osmanforhad.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-practice-plugin
 * Domain Path:       /languages
 */
abstract class Cbx_Intern_Meta_Box {


    /**
     * Set up and add the meta box.
     */
    public static function add() {
        $screens = [ 'post', 'cbx_cpt' ];
        foreach ( $screens as $screen ) {
            add_meta_box(
                'cbx_box_id',          // Unique ID
                'Custom Meta Box Title', // Box title
                [ self::class, 'html' ],   // Content callback, must be of type callable
                $screen                  // Post type
            );
        }
    }


    /**
     * Save the meta box selections.
     *
     * @param int $post_id  The post ID.
     */
    public static function save( int $post_id ) {
        if ( array_key_exists( 'cbx_field', $_POST ) ) {
            update_post_meta(
                $post_id,
                '_cbx_meta_key',
                $_POST['cbx_field']
            );
        }
    }


    /**
     * Display the meta box HTML to the user.
     *
     * @param \WP_Post $post   Post object.
     */
    public static function html( $post ) {
        $value = get_post_meta( $post->ID, '_cbx_meta_key', true );
        ?>
        <label for="cbx_field">Description for this field</label>
        <select name="wporg_field" id="cbx_field" class="postbox">
            <option value="">Select something...</option>
            <option value="something" <?php selected( $value, 'something' ); ?>>Something</option>
            <option value="else" <?php selected( $value, 'else' ); ?>>Else</option>
        </select>
        <?php
    }
}

add_action( 'add_meta_boxes', [ 'Cbx_Intern_Meta_Box', 'add' ] );
add_action( 'save_post', [ 'Cbx_Intern_Meta_Box', 'save' ] );