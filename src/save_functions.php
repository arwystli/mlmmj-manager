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
  global $smarty, $listdir, $listpath, $errmsg;

  $file = $listdir."/".$listpath."/control/".$name;
  if(isset($_POST[$name]) && !empty($_POST[$name])) {
    if(!touch($file)) {
      $errmsg[] = "Couldn't open " . $file . " for writing";
    }
    if (!chmod($file, 0644)) {
      $errmsg[] = "Couldn't chmod " . $file;
    }
  }
  else {
    if (file_exists($file)) {
      if (!unlink($file)) {
        $errmsg[] = "Couldn't unlink ".$file;
      }
    }
  }
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
  mlmmj_list($name, $nicename, $text);
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
  global $smarty, $listdir, $list, $listpath, $errmsg;

  $file = "$listdir/$listpath/control/$name";

  if(isset($_POST[$name]) && !empty($_POST[$name]) && !preg_match('/^\s*$/',$_POST[$name])) {
    // remove all \r
    $_POST[$name] = preg_replace('/\r/',"",$_POST[$name]);

    // no trailing \n?, then we add one
    if (!preg_match('/\n$/',$_POST[$name])) {
      $_POST[$name] .= "\n";
    }

    if ($nicename !== 'Footer') {
      // we don't like whitespace before a \n
      $_POST[$name] = preg_replace('/\s*\n/',"\n",$_POST[$name]);
    }

    if (!$fp = fopen($file, "w")) {
      $errmsg[] = "Couldn't open " . $file . " for writing";
    }
    // write the result in a file
    fwrite($fp, $_POST[$name]);
    fclose($fp);

    if (!chmod($file, 0664)) {
      $errmsg[] = "Couldn't chmod " . $file;
    }
  }
  else {
    if (file_exists($file)) {
      if (!unlink($file)) {
        $errmsg[] = "Couldn't unlink ".$file;
      }
    }
  }
}
