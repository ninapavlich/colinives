<?php

$env_file = DRUPAL_ROOT. '/env.php';
if (file_exists($env_file)) {
	define('WP_DEBUG', true);
	include $env_file;
}else{
	define('WP_DEBUG', true);
	
}
?>