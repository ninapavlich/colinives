<?php
/**
 * The Template for displaying all single posts.
 *
* modified by nina@ninalp.com
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
	
			<?php
				$post_id = $post->ID;
				$taxonomy = "projectpageformats";
				$terms = wp_get_post_terms( $post_id, $taxonomy );
				$term = $terms[0];
			
			?>
			
				<?php get_template_part( 'content', $term->slug ); ?>

				

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>