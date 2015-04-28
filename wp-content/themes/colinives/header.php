<?php
/**
* modified by nina@ninalp.com
 */
 
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri();?>/favicon.ico"/>


<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>z
<![endif]-->



<?php wp_head(); ?>



<!-- THUMBNAIL scripts -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script><!-- latest jQuery direct from google's CDN -->
<script src="<?php echo get_template_directory_uri(); ?>/js/menu.js?v=1.0" type="text/javascript"></script>
<link rel='stylesheet' href='<?php echo get_template_directory_uri();?>/css/menu.css?ver=1.0' type='text/css' media='all' />

<!-- GOOGLE ANALYTICS -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-38024705-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		
		<?php
			$current_group_name = getCurrentProjectGroup()->name;
			$menuitems = getGlobalMenuItems();
		?>
		

		<div class="mobile-menu">
			<?php
			
				echo "<ul>";
				for ($k = 0; $k < count($menuitems); $k++) {
					$projectname = $menuitems[$k]['name'];
					$projects = $menuitems[$k]['projects'];					
					if (count($projects > 0)) {
						$firstproject = $projects[0];
						if ($current_group_name == $projectname) {
							echo '<li>'.$projectname.'</li>';
						}else {
							echo '<li><a href="?projectpages='.$firstproject->post_name.'">'.$projectname.'</a></li>';
						}
						
					}
					
					
					
				}
				echo "</ul>";
			
			?>
		</div>
		<div class="fancy-menu">
			<div class="menu-labels-wrapper">
				<div class="menu-labels">
					<?php
					
						echo "<ul>";
						for ($k = 0; $k < count($menuitems); $k++) {
							$projectname = $menuitems[$k]['name'];
							$projects = $menuitems[$k]['projects'];					
							if (count($projects > 0)) {
								$firstproject = $projects[0];
								echo '<li><a href="?projectpages='.$firstproject->post_name.'">'.$projectname.'</a></li>';	
							}
						}
						echo "</ul>";
						
					
					?>
				</div>
			</div>
			<div class="colinives-menu-wrapper">
				<div class="colinives-menu">
					<?php
					
					
						echo "<ul>";
						for ($k = 0; $k < count($menuitems); $k++) {
							$project_group = $menuitems[$k];
							$project_group_name = $project_group['name'];
							$project_group_id = $project_group['id'];
							$projects = $project_group['projects'];			
							
							$first_project = $projects[0];
							
							
							$thumbnail_id = get_field('project_group_thumbnail', 'projectgroup_'.$project_group_id);
							$thumbnail_image = wp_get_attachment_image_src($thumbnail_id, 'full');	
							$thumbnail_title = get_the_title($thumbnail_id);
							$class = ($current_group_name == $project_group_name)? 'active' : '';
							
							
							if(count($projects>0)){
								
								echo '
									<li class="'.$class.'">
										<a href="?projectpages='.$first_project->post_name.'">
											<img src="'.$thumbnail_image[0].'" alt="'.$project_group_name.'"/>
										</a>								
									</li>';
							}
						}
						
						echo "</ul>";
					
					?>
					
				
				</div>
			</div>
		</div>
		
		
		
	</header><!-- #masthead -->

	<div id="main" class="wrapper">
		