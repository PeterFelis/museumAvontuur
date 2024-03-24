<?php

/**
 * Plugin Name: Museum
 * filename: museum.php
 * Description: Voegt een metabox toe aan posts voor het documenteren van museumbezoeken.
 * Version: 1.0
 * Author: Chat GPT en Peter Felis (in die volgorde)
 */

function museum_reviews_add_metabox()
{
    add_meta_box(
        'museum_reviews_metabox',
        'Museum Review',
        'museum_reviews_metabox_callback',
        'museum_reviews', // Dit is het ID van je nieuwe custom post type.
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'museum_reviews_add_metabox');

function museum_reviews_metabox_callback($post)
{
    wp_nonce_field(basename(__FILE__), 'museum_reviews_nonce');

    $visit_date = get_post_meta($post->ID, 'visit_date', true);
    $museum_url = get_post_meta($post->ID, 'museum_url', true);
    $museum_maps = get_post_meta($post->ID, 'museum_maps', true);
    $image_ids = get_post_meta($post->ID, 'museum_review_images', true);
?>
    <p>
        <label for="visit_date">Datum Bezoek:</label>
        <input type="date" id="visit_date" name="visit_date" value="<?php echo esc_attr($visit_date); ?>" />
    </p>
    <p>
        <label for="museum_url">Museum Website:</label>
        <input type="url" id="museum_url" name="museum_url" value="<?php echo esc_url($museum_url); ?>" />
    </p>
    <p>
        <label for="museum_maps">Google Maps Link:</label>
        <input type="url" id="museum_maps" name="museum_maps" value="<?php echo esc_url($museum_maps); ?>" />
    </p>
    <p>
        <label for="museum_background_color">Achtergrondkleur (hexcode):</label>
        <input type="text" id="museum_background_color" name="museum_background_color" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$" value="<?php echo esc_attr(get_post_meta($post->ID, 'museum_background_color', true)); ?>" placeholder="#ffffff" />
    </p>
    <p>
        <button id="upload_images_button" class="button">Voeg afbeeldingen toe</button>
        <input type="hidden" id="museum_review_images" name="museum_review_images" value="<?php echo esc_attr($image_ids); ?>" />
    </p>
<?php
    if (!empty($image_ids)) {
        $ids = explode(',', $image_ids);
        foreach ($ids as $id) {
            $image_url = wp_get_attachment_url($id);
            echo '<img src="' . esc_url($image_url) . '" style="max-width: 90px; margin-right: 5px;" />';
        }
    }
}

function museum_reviews_create_post_type()
{
    register_post_type('museum_reviews', array(
        'labels'      => array(
            'name'          => __('Museumbezoeken', 'textdomain'),
            'singular_name' => __('Museumbezoek', 'textdomain'),
        ),
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => array('slug' => 'museumbezoeken'),
        'supports'    => array('title', 'editor', 'thumbnail'),
        'menu_icon'   => 'dashicons-admin-customizer',
        'taxonomies'  => array('post_tag'), // Voeg dit toe
    ));
}
add_action('init', 'museum_reviews_create_post_type');

function museum_reviews_save_metabox($post_id)
{
    if (
        !isset($_POST['museum_reviews_nonce']) || !wp_verify_nonce($_POST['museum_reviews_nonce'], basename(__FILE__)) ||
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) ||
        !current_user_can('edit_post', $post_id)
    ) {
        return;
    }

    update_post_meta($post_id, 'visit_date', sanitize_text_field($_POST['visit_date']));
    update_post_meta($post_id, 'museum_url', esc_url($_POST['museum_url']));
    update_post_meta($post_id, 'museum_maps', esc_url($_POST['museum_maps']));
    update_post_meta($post_id, 'museum_background_color', sanitize_hex_color($_POST['museum_background_color']));
}

add_action('save_post', 'museum_reviews_save_metabox');

function museum_reviews_enqueue_scripts($hook)
{
    global $post;
    if (($hook == 'post-new.php' || $hook == 'post.php') && 'museum_reviews' === $post->post_type) {
        wp_enqueue_script('museum-reviews-upload', plugins_url('/museum.js', __FILE__), array('jquery'), false, true);
        wp_localize_script('museum-reviews-upload', 'mr_upload', array(
            'title' => __('Upload Afbeeldingen', 'museum-reviews'),
            'button' => __('Gebruik deze afbeeldingen', 'museum-reviews'),
        ));
    }
}
add_action('admin_enqueue_scripts', 'museum_reviews_enqueue_scripts');

function museum_reviews_save_images($post_id)
{
    if (isset($_POST['museum_review_images'])) {
        $image_ids = sanitize_text_field($_POST['museum_review_images']);
        update_post_meta($post_id, 'museum_review_images', $image_ids);
    }
}
add_action('save_post', 'museum_reviews_save_images');

function hide_oxygen_box_on_museum_page()
{
    $screen = get_current_screen();
    if ($screen->post_type == 'museum_reviews') {
        echo '<style>
            #ct_views_cpt{ display: none; }
        </style>';
    }
}
add_action('admin_head', 'hide_oxygen_box_on_museum_page');
