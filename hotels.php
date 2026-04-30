<?php

define('HOMEPAGE', 0); // Track homepage.
define('HOTEL_PAGE', 1);// Track Hotel page.
define('JCMSTYPE', 0); // Track Current site language.

require_once("includes/initialize.php");

$currentTemplate	= Config::getCurrentTemplate('template');
$jVars 				= array();
$template 			= "template/{$currentTemplate}/hotels.html";

require_once('views/modules.php');

template($template, $jVars, $currentTemplate);

?>
