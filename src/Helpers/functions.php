<?php

if (! function_exists('config')) {
	function config($key = null, $default = null)
	{
		if (! isset($key)) {
			return [];
		}

		return include __DIR__ . '/../../config/slack.php';
	}
}
