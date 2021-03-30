<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fashion Diva
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/Blog">
	<?php 
	        blossom_fashion_post_thumbnail();
	        blossom_fashion_entry_header();
        /**
         * @hooked blossom_fashion_entry_content - 15
         * @hooked blossom_fashion_entry_footer  - 20
        */
        do_action( 'blossom_fashion_post_entry_content' );
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
