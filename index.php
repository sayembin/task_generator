<?php
require_once('autoloader.php');
$settings = \Config\config::getConfig();
header( "Location: ".$settings['base_url']."/controller".DIRECTORY_SEPARATOR."TodoController.php",false );