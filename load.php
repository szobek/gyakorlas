<?php
session_start();

spl_autoload_register(function ($className) {
	$file = __DIR__.DIRECTORY_SEPARATOR. "classes". DIRECTORY_SEPARATOR.'class_' . $className . '.php';
	if (file_exists($file) && is_readable($file)) {
		require_once $file;
	}
});


