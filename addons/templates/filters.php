<?php
	
	include(__DIR__.'/find_avatar.php');

	PerchSystem::register_template_filter('find_avatar', 'PerchTemplateFilter_find_avatar');