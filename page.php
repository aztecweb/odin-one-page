<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package Odin
 * @since 2.2.0
 */
?>

<?php if( empty( $onepage ) ) : 

get_header(); ?>
	<div id="primary" class="<?php echo odin_full_page_classes(); ?>">
		<div id="content" class="site-content" role="main">

<?php else : ?>

	<section id="page-<?php echo get_queried_object_id() ?>">

<?php endif; ?>


			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
			
					// Include the page content template.
					get_template_part( 'content', 'page' );
			
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile;
			?>

			
<?php if( empty( $onepage ) ) : ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php 

get_footer();

else : ?>
	</section>
<?php endif; ?>