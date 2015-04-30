<?php
/**
 * Template Name: Empty Page
 */

get_header('project'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1><?= $post->post_title; ?></h1>

				<?= $post->post_content; ?>

			</article><!-- #post-## -->


		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
