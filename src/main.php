<?php
/**
 * @author Bob Hutchinson <arwystli@gmail.com>
 * @copyright GNU GPL
 *
 */

// get list
$smarty->assign("listdir",  $listdir);
$lists = get_lists($listdir);
$list2 = array();
foreach ($lists AS $ct => $l) {
  $lists2[$ct]['name'] = $l;
  $lists2[$ct]['url'] = urlencode($l);
}
$smarty->assign("lists",  $lists2);

$smarty->display($method . '.tpl');
