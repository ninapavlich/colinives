<?php
/**
* modified by nina@ninalp.com
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

	<!-- SCRIPTS FOR FANCY SCROLL BAR -->
	<link type="text/css" href="<?php echo get_template_directory_uri();?>/css/jquery.jscrollpane.css" rel="stylesheet" media="all" /><!-- styles needed by jScrollPane -->	
	<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.mousewheel.js"></script><!-- the mousewheel plugin - optional to provide mousewheel support -->
	<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/jquery.jscrollpane.min.js"></script><!-- the jScrollPane script -->
	<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/scrollpane.js"></script><!-- the jScrollPane script -->
	
	<!-- /SCRIPTS FOR FANCY SCROLL BAR -->
	
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			<h1 class="entry-title"><span class="project-title"><?php echo $display_title; ?></span></h1>			
		</header><!-- .entry-header -->
		<div class="entry-content">
			<div class="format-image-and-text">
				<div class="image">
					<?php
					
						$project_image = wp_get_attachment_image_src(get_field('project_image'), 'full');	
						$project_image_title = get_the_title(get_field('project_image'));
						echo '<img src="'.$project_image[0].'" alt="'.$project_image_title.'" />';
					
					?>
				</div>
				<div class="text">
					<div class="scroll-pane">
						<?php the_field('project_description'); ?>
					</div>
				</div>
			</div>
			
		</div><!-- .entry-content -->
		
		<footer class="entry-meta">
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
