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

		
		<nav clas="submenu">
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
