<?php
/**
 * @author Bob Hutchinson <arwystli@gmail.com>
 * @copyright GNU GPL
 *
 */

$listname = '';
$dom = '';
$listpath = "";
$errmsg = array();

if (isset($action)) {
  // $action is either a listname or a request to to save the config
  if ($action == 'save') {
    if(isset($_POST['list'])) {
      $list = $_POST["list"];
      $listpath = get_listpath($list);
      if(is_dir($listdir."/".$listpath)) {
        include(APP_ROOT . 'src/save_functions.php');
        $smarty->assign("list", htmlspecialchars($list));
        $tunables = file_get_contents(APP_ROOT . 'src/tunables.pl');
        eval($tunables);
        if (count($errmsg)) {
          // we have error messages
          $msg = implode("<br/>", $errmsg);
        }
        else {
          $msg = "Saved settings for " . $list;
        }
        $smarty->assign("msg",  $msg);
        $method = 'subscribers';
        $action = $list;
        include(APP_ROOT . 'src/' . $method . '.php');
      }
    }
  }
  elseif (filter_var($action, FILTER_VALIDATE_EMAIL)) {
    $listpath = get_listpath($action);
    if(is_dir($listdir."/".$listpath)) {
      include(APP_ROOT . 'src/edit_functions.php');
      $smarty->assign("list", htmlspecialchars($action));
      $tunables = file_get_contents(APP_ROOT . 'src/tunables.pl');
      eval($tunables);
      $smarty->display($method . '.tpl');
    }
    else {
      $smarty->assign("msg",  "non-existent list: " . $listdir."/".$listpath );
      $method = 'main';
      include(APP_ROOT . 'src/' . $method . '.php');
      exit;
    }
  }
  else {
    $method = "main";
    include(APP_ROOT . 'src/' . $method . '.php');
    exit;
  }
}
else {
  // no action set so go to main page
  $method = "main";
  include(APP_ROOT . 'src/' . $method . '.php');
  exit;
}
