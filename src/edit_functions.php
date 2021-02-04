<?php
/**
 * @author Bob Hutchinson <arwystli@gmail.com>
 * @copyright GNU GPL
 *
 */

/**
 * mlmmj_boolean
 *
 * @param string $name
 * @param string $nicename
 * @param string $text
 * @return void
 */
function mlmmj_boolean($name, $nicename, $text) {
  global $smarty, $listdir, $listpath;

  // if the file exists, true
  $file = $listdir."/".$listpath."/control/".$name;
  if(is_file($file)) {
    $checked = TRUE;
  }
  else {
    $checked = FALSE;
  }

  $smarty->assign("name", htmlentities($name));
  $smarty->assign("nicename", htmlentities($nicename));
  $smarty->assign("text", htmlentities($text));
  $smarty->assign("checked", $checked ? " checked" : "");
  $out = $smarty->fetch('edit_boolean.tpl');
  $smarty->append("rows", $out);
}

/**
 * mlmmj_string
 *
 * @param string $name
 * @param string $nicename
 * @param string $text
 * @return void
 */
function mlmmj_string($name, $nicename, $text) {
  global $smarty, $listdir, $list, $listpath;

  $file = $listdir."/".$listpath."/control/".$name;
  $value = "";

  // load file as an array
  if(is_file($file)) {
    $lines = file($file);
    $value = $lines[0];
  }

  // remove trailing \n if any, just to be sure
  #$value = preg_replace('/\n$/',"",$value);
  $value = trim($value);

  $smarty->assign("name", htmlentities($name));
  $smarty->assign("nicename", htmlentities($nicename));
  $smarty->assign("text", htmlentities($text));
  $smarty->assign("value", htmlentities($value));
  $out = $smarty->fetch('edit_string.tpl');
  $smarty->append("rows", $out);
}

/**
 * mlmmj_list
 *
 * @param string $name
 * @param string $nicename
 * @param string $text
 * @return void
 */
function mlmmj_list($name, $nicename, $text) {
  global $smarty, $listdir, $list, $listpath;

  $file = "$listdir/$listpath/control/$name";
  $value = "";

  if(is_file($file)) {
    $value = file_get_contents($file);
  }

  // the last \n would result in an extra empty line in the list box,
  // so we remove it
  $value = preg_replace('/\n$/',"",$value);

  $smarty->assign("name", htmlentities($name));
  $smarty->assign("nicename", htmlentities($nicename));
  $smarty->assign("text", htmlentities($text));
  $smarty->assign("value", htmlentities($value));
  $out = $smarty->fetch('edit_list.tpl');
  $smarty->append("rows", $out);
}
