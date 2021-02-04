<?php
/**
 * @author Bob Hutchinson <arwystli@gmail.com>
 * @copyright GNU GPL
 *
 */

$listname = '';
$dom = '';
$listpath = "";

if (isset($action) && filter_var($action, FILTER_VALIDATE_EMAIL) ) {
  $listpath = get_listpath($action);
  if(!is_dir($listdir."/".$listpath)) {
    $smarty->assign("msg",  "non-existent list: " . $listdir."/".$listpath );
    $method = 'main';
    include(APP_ROOT . 'src/' . $method . '.php');
    exit;
  }
  else {
    if (isset($_POST["tosubscribe"])) {
      $subs = $_POST["tosubscribe"];
      $msg = add_subscriber($listdir."/".$listpath, $subs);
      $smarty->assign("msg", $msg);
    }
    elseif (isset($_POST["delete"]) && isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ) {
      $sub = $_POST["email"];
      $msg = delete_subscriber($listdir."/".$listpath, $sub);
      $smarty->assign("msg", $msg);
    }
    // get subs
    $res = get_subscribers($listdir."/".$listpath);
    if ( is_array($res)) {
      $emails = array();
      foreach ($res AS $ct => $em) {
        $emails[$ct]['address'] = $em;
        $emails[$ct]['spch'] = htmlspecialchars($em);
      }
      $smarty->assign("subs", $emails);
      $smarty->assign("list", htmlspecialchars($action));
    }
    else {
      $smarty->assign("msg", $res);
    }
    $smarty->display($method . '.tpl');
  }
}
else {
  // no action set so go to main page
  $method = "main";
  include(APP_ROOT . 'src/' . $method . '.php');
  exit;
}
