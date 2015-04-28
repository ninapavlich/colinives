<?php
/**
* modified by nina@ninalp.com
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="colophon" role="contentinfo">
		
		<div class="colinives-submenu">
			<?php
			
			$current_name = $post->post_name;
			$submenu_items = getSubMenuItems();
			
			echo "<ul>";
			for ($k = 0; $k < count($submenu_items); $k++) {
				
				$project = $submenu_items[$k];				
				$display_title_raw = $project->display_title;
				
				$display_title =  empty($display_title_raw) ? $project->post_title : $display_title_raw;
				
				if($current_name == $project->post_name){
					echo '<li>'. $display_title .'</li>';
				}else {					
					echo '<li><a href="?projectpages='.$project->post_name.'">'. $display_title .'</a></li>';
				}
				
			}
			echo "</ul>";
			
				
			
			?>
		</div>
		
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>


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


</body>




</html>