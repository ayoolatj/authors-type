<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://vedno.de
 * @since      1.0.0
 *
 * @package    Authors_type
 * @subpackage Authors_type/public/partials
 */

global $post;
$author_first_name  = get_post_meta( $post->ID, 'apt_first_name', true);
$author_last_name   = get_post_meta( $post->ID, 'apt_last_name', true);
$author_full_name   = $author_first_name . ' ' . $author_last_name;

$authors_facebook_link   = get_post_meta( $post->ID, 'apt_facebook_url', true);
$authors_googleplus_link = get_post_meta( $post->ID, 'apt_google_plus_url', true);
$authors_linkedin_link   = get_post_meta( $post->ID, 'apt_linkedin_url', true);
$authors_biography   = get_post_meta( $post->ID, 'apt_biography', true);

$authors_image_id = get_post_meta( $post->ID, 'apt_authors_image', true);
$authors_image_id = ( -1 == $authors_image_id ) ? '' : (int) $authors_image_id;
$gravatar_args    = array(
    'size'          => 150,
    'default'       => 'mysteryman',
    'force_default' => true,
);

$authors_image_url = get_avatar_url( $post, $gravatar_args );//Default to mystery man image

if ( !empty( $authors_image_id ) ) {
    $authors_image_url = wp_get_attachment_thumb_url( $authors_image_id );
}
$existing_user = get_post_meta( $post->ID, 'apt_existing_user', true);
$existing_user = ( -1 == $existing_user ) ? '' : (int) $existing_user;

//echo $existing_user . " EXISTING";

$authors_gallery_ids  = get_post_meta( $post->ID, 'apt_image_gallery', true);
$attachment_array     = maybe_unserialize( $authors_gallery_ids );
if ( is_array( $attachment_array ) ) {
    $attachment_string = implode( ",", $attachment_array );
} else {
    $attachment_string = $attachment_array;
}
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<!-- PORTLET MAIN -->
<div class="authors-profile-wrapper">
    <div class="authors-profile-userpic">
        <img src="<?php echo esc_url( $authors_image_url ); ?>" class="img-responsive" alt="">
        <div class="authors-profile-usertitle-name"><?php echo esc_html( $author_full_name ); ?></div>
    </div>
    <div class="authors-profile-desc">
        <span class="authors-profile-desc-title">About <?php echo esc_html( $author_full_name ); ?></span>
        <span class="authors-profile-desc-text"><?php echo esc_html( $authors_biography ); ?></span>
        <?php if ( ! empty( $authors_facebook_link ) ): ?>
        <div class="authors-profile-desc-link">
            <i class="fa fa-facebook-official"></i>
            <a href="<?php echo esc_url( $authors_facebook_link ); ?>"> <?php echo esc_url( $authors_facebook_link ); ?></a>
        </div>
        <?php endif; ?>
        <?php if ( ! empty( $authors_linkedin_link ) ): ?>
        <div class="authors-profile-desc-link">
            <i class="fa fa-linkedin-square"></i>
            <a href="<?php echo esc_url( $authors_linkedin_link ); ?>"> <?php echo esc_url( $authors_linkedin_link ); ?></a>
        </div>
        <?php endif; ?>
        <?php if ( ! empty( $authors_googleplus_link ) ): ?>
        <div class="authors-profile-desc-link">
            <i class="fa fa-google-plus-official"></i>
            <a href="<?php echo esc_url( $authors_googleplus_link ); ?>"> <?php echo esc_url( $authors_googleplus_link ); ?></a>
        </div>
        <?php endif; ?>
    </div>
    <?php if ( ! empty( $attachment_string ) ): ?>
    <div class="authors-gallery">
        <span class="authors-post">Authors Gallery</span>
        <?php echo do_shortcode("[gallery ids='$attachment_string']"); ?>
    </div>
    <?php endif; ?>
    <?php if ( ! empty( $existing_user ) ): ?>
        <span class="authors-post"><?php echo esc_html( $author_full_name ); ?> Posts</span>
        <?php $author_args = array(
            'author'         => esc_attr( $existing_user ),
            'posts_per_page' => -1,
        );

        $the_query = new WP_Query( $author_args );

        if ( $the_query->have_posts() ): ?>
            <ul>
            <?php while ( $the_query->have_posts() ): $the_query->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile;
            wp_reset_postdata(); ?>
            </ul>
        <?php else: ?>
        <p> Author has no posts yet</p>
    <?php endif;

    endif; ?>
</div>