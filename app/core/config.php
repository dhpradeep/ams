<?php

// site domain name with http
defined("SITE_URL")
	|| define("SITE_URL", "http://".$_SERVER['SERVER_NAME']."/ams/public");

// To be used in MVC

// directory separator
defined("DS")
	|| define("DS", DIRECTORY_SEPARATOR);

defined("HOME_PATH")
 	|| define("HOME_PATH", realpath(dirname(__FILE__).DS."..".DS."..".DS));

// root path
defined("ROOT_PATH")
	|| define("ROOT_PATH", HOME_PATH.DS."app");

// public path
defined("PUBLIC_PATH")
	|| define("PUBLIC_PATH", HOME_PATH.DS."public");
	
// libs folder
defined("LIBS_DIR")
	|| define("LIBS_DIR", ROOT_PATH.DS."libs");

// models directory
defined("MODELS_DIR")
	|| define("MODELS_DIR", ROOT_PATH.DS."models");

// controllers folder
defined("CONTROLLERS_DIR")
	|| define("CONTROLLERS_DIR", ROOT_PATH.DS."controllers");
	
// views folder
defined("VIEWS_DIR")
	|| define("VIEWS_DIR", ROOT_PATH.DS."views");

// Include folder
defined("INCLUDES_DIR")
	|| define("INCLUDES_DIR", VIEWS_DIR.DS."includes");

// Modals folder
defined("MODALS_DIR")
|| define("MODALS_DIR", VIEWS_DIR.DS."modals");
	

// To be used in Views Templates.

// bower components
defined("BOWER_DIR")
	|| define("BOWER_DIR", SITE_URL."/bower_components");

// css folder
defined("CSS_DIR")
	|| define("CSS_DIR", SITE_URL."/css");

// images folder
defined("IMAGE_DIR")
	|| define("IMAGE_DIR", SITE_URL."/image");

// js folder
defined("JS_DIR")
	|| define("JS_DIR", SITE_URL."/js");

//	fonts folder
defined("FONTS_DIR")
	|| define("FONTS_DIR", SITE_URL."/fonts");


// To be used for some defaults values.
defined("WEBSITE_TITLE")
	|| define("WEBSITE_TITLE", "Attendance Management System");

// Brand Name
defined("BRAND_NAME")
	|| define("BRAND_NAME", "EVERsoft GROUP");

// Brand Website
defined("BRAND_WEBSITE")
	|| define("BRAND_WEBSITE", "http://www.eversoftgroup.com");

// App Version
defined("VERSION")
	|| define("VERSION", "1.0");

?>