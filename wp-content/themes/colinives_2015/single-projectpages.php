<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header('project'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			//get_template_part( 'content', 'page' );

			$post = populateProjectData($post);
			if($post->layout_type=='image-and-text'){
				get_template_part( 'content', 'projectpage-text-and-image' );
			}elseif($post->layout_type=='person'){
				get_template_part( 'content', 'projectpage-person' );
			}elseif($post->layout_type=='image-gallery'){
				get_template_part( 'content', 'projectpage-image-gallery' );
			}elseif($post->layout_type=='video-gallery'){
				get_template_part( 'content', 'projectpage-video-gallery' );
			}elseif($post->layout_type=='vimeo-video'){
				get_template_part( 'content', 'projectpage-vimeo-video' );
			}

		// End the loop.
		endwhile;
		?>

		<nav class="subnav">
			<ul>
				<?php $submenu = getSubMenuItems(); ?>
				<?php foreach($submenu as $project): ?>
				
				<li>
					<a href="<?= $project->url ?>">
						<?= $project->display_title ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</nav>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
