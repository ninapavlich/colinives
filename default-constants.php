<?php

$env_file = DRUPAL_ROOT. '/env.php';
if (file_exists($env_file)) {
	include $env_file;
}else{
	//WARNING: Missing environment file in MINERAL
}

?>