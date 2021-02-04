<?php
/**
 * @author Bob Hutchinson <arwystli@gmail.com>
 * @copyright GNU GPL
 *
 */

// debug
$server_settings = '';
if ( ! empty($devel_status) ) {
  $server_settings = print_r($_SERVER, TRUE);
}
$smarty->assign("server_settings",  $server_settings);

// site_url
$site_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $sitepath;

$smarty->assign("site_url",  $site_url);

$methods = array("main", "configure", "subscribers");
// set default
$method = "main";
$action = "";

$uri = $_SERVER['REQUEST_URI'];
// get path components
$uri2 = explode('/', $uri);

if ( in_array($uri2[$method_pos], $methods)) {
  $method = $uri2[$method_pos];
}
if ( isset($uri2[$action_pos]) && ! empty($uri2[$action_pos]) ) {
  $action = urldecode($uri2[$action_pos]);
}

$smarty->assign("action",  $action);

# debug
$uri2 = print_r($uri2, TRUE);
$smarty->assign("uri",  $uri2);

include(APP_ROOT . 'src/' . $method . '.php');
