<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 
	$project_terms = get_the_terms($post->ID, 'projectgroup');
	$project_name = '';
	foreach ($project_terms as $project) {
		$project_name = $project->name;
	}
	
 
	$display_title_raw = get_field('display_title');
	$subproject_title = empty($display_title_raw) ? get_the_title() : $display_title_raw;
	$display_title =  "<span class='project-name'>".$project_name."</span> ".$subproject_title;
	
 
?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/swfobject.v2.2.js"></script>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			<h1 class="entry-title"><span class="project-title"><?php echo $display_title; ?></span></h1>			
		</header><!-- .entry-header -->
		<div class="entry-content">
			<div class="format-vimeo-video">
				<div class="vimeo" style="width:<?php the_field('embed_width'); ?>px;height:<?php the_field('embed_height'); ?>px">
					<iframe src="http://player.vimeo.com/video/<?php the_field('vimeo_id'); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="<?php the_field('embed_width'); ?>" height="<?php the_field('embed_height'); ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
					
				</div>			
			</div>
		</div><!-- .entry-content -->
		
		<footer class="entry-meta">
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
