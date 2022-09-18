<?php
session_start();

spl_autoload_register(function ($className) {
    $file = "classes/class_".$className . '.php';
	if (file_exists($file)) {
		require_once $file;
	}
});

