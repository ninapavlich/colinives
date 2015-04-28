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

	<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/gallery.js"></script>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			<h1 class="entry-title"><span class="project-title"><?php echo $display_title; ?></span></h1>			
		</header><!-- .entry-header -->
		<div class="entry-content">
			<div class="format-image-gallery">
				<div class="full">
					
					<?php					
					
						$gallery_elements = get_field('gallery_element');
						
						
						for ($k = 0; $k < count($gallery_elements); $k++) {
							
							$gallery_element = $gallery_elements[$k];
							$has_image = $gallery_element['image_or_video'] == 'Image';
						
							if($has_image===true){
								
								$full_image_id = $gallery_element['image'];
								$full_image = wp_get_attachment_image_src($full_image_id, 'full');	
								$full_image_title = get_the_title($full_image_id);
							
								echo '<div class="gallery_image_full" id="full_'.$k.'">
										<img src="'.$full_image[0].'" alt="'.$full_image_title.'" />
									</div>';
							}else {
							
								$vimeo_id = $gallery_element['vimeo_video_id'];
								$vimeo_embed_width = $gallery_element['vimeo_embed_width'];
								$vimeo_embed_height = $gallery_element['vimeo_embed_height'];
								echo '
								<div class="gallery_image_full" id="full_'.$k.'">
									<iframe src = "http://player.vimeo.com/video/'.$vimeo_id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width = "'.$vimeo_embed_width.'" height = "'.$vimeo_embed_height.'" frameborder = "0" webkitAllowFullScreen mozallowfullscreen allowFullScreen ></iframe>
								</div>';
								
							}
							
						}	
						
					?>
					
					
				</div>
				<div class="thumbnails">
					
					<?php	
					$len = count($gallery_elements);
					$image_class = $len <= 2? 'cols_1' : ($len <= 4? 'cols_2' : ( $len <= 9? 'cols_3' : 'cols_4' ));
					for ($k = 0; $k < $len; $k++) {
							
						$gallery_element = $gallery_elements[$k];
						
						$thumbnail_id = $gallery_element['thumbnail'];
						$thumbnail_image = wp_get_attachment_image_src($thumbnail_id, 'full');	
						$thumbnail_title = get_the_title($thumbnail_id);
						echo '<img src="'.$thumbnail_image[0].'" alt="'.$thumbnail_title.'" id="thumbnail_'.$k.'" class="'.$image_class.'" />';
						
					}
					?>
					
				</div>
			</div>
		</div><!-- .entry-content -->
		
		<footer class="entry-meta">
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
