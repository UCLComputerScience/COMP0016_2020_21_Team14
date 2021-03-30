<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Fashion Diva
 */
$home_layout = get_theme_mod( 'home_layout', 'two' );
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();
				if( $home_layout == 'two' ) :
					get_template_part( 'template-parts/content-one', get_post_format() );
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				else:
					get_template_part( 'template-parts/content', get_post_format() );
				endif;
			endwhile;

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>
        
		</main><!-- #main -->
        
        <?php
        /**
         * @hooked blossom_fashion_navigation - 15
        */
        do_action( 'blossom_fashion_after_posts_content' );
        ?>        
        
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
