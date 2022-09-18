<?php
session_start();

spl_autoload_register(function ($class_name) {
    include "classes/class_".$class_name . '.php';
});

