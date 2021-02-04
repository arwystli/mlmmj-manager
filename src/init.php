<?php
/**
 * @author Bob Hutchinson <arwystli@gmail.com>
 * @copyright GNU GPL
 *
 */

// PHP INIT/SECURITY STUFF
#ini_set("display_errors", 1);
#ini_set("display_startup_errors", 1);
#ini_set("log_errors", 1);
#ini_set("allow_url_fopen", 0);

//ini_set("error_reporting", E_ALL ^ E_NOTICE);
ini_set("error_reporting", E_ALL);

// Check that register_globals is off
if(ini_get("register_globals")) {
  die("Error: register_globals is on.");
}
if(ini_get("safe_mode")) {
  die("Error: safe_mode is on.");
}

$protects = array("_REQUEST", "_GET", "_POST", "_COOKIE", "_FILES", "_SERVER", "_ENV", "GLOBALS", "_SESSION");
foreach ($protects as $protect) {
  if ( in_array($protect , array_keys($_REQUEST)) ||
    in_array($protect , array_keys($_GET)) ||
    in_array($protect , array_keys($_POST)) ||
    in_array($protect , array_keys($_COOKIE)) ||
    in_array($protect , array_keys($_FILES))) {
    die("Invalid Request.");
  }
}

// set up sitepath
$a = explode("/", $sitepath);
$method_pos = count($a) - 1;
$action_pos = $method_pos +1;

// composer autoloader
require_once( APP_ROOT . "vendor/autoload.php" );

$smarty = new Smarty;

#$smarty->debugging = true;
#$smarty->error_reporting = true;
$smarty->debugging = false;
$smarty->error_reporting = true;

$private_dirs = APP_ROOT . "data";

// Location of sessions dir
$session_dir = "$private_dirs/sessions";

// Make sure the private_dirs exist and are writable
if(!is_writable($session_dir)) die("Error: $session_dir is not writeable.");
if(!is_writable("$private_dirs/templates_c")) die("Error: $private_dirs/templates_c is not writeable.");
if(!is_writable("$private_dirs/configs")) die("Error: $private_dirs/configs is not writeable.");
if(!is_writable("$private_dirs/cache")) die("Error: $private_dirs/cache is not writeable.");

// Location of smarty dirs
$smarty->setCompileDir("$private_dirs/templates_c/");
$smarty->setConfigDir("$private_dirs/configs/");
$smarty->setCacheDir("$private_dirs/cache/");

// enable caching
$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);

// disable caching
#$smarty->setCaching(Smarty::CACHING_LIFETIME_OFF);

// clear out all cache files
#$smarty->clearAllCache();

define("TEMPLATES", APP_ROOT."templates/");
# which template. this one is for including templates within templates
$smarty->setTemplateDir(TEMPLATES);
define("PHP_SELF", $_SERVER["PHP_SELF"]);
$smarty->assign("php_self", PHP_SELF);

// footer
$smarty->assign("copyright", $copyright);
$smarty->assign("devstatus", $devel_status);
