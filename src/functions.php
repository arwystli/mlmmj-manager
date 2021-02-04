<?php
/**
 * @author Bob Hutchinson <arwystli@gmail.com>
 * @copyright GNU GPL
 *
 */

function get_lists($listdir) {
  $lists = array();
  foreach (scandir($listdir) AS $dom) {
    if (! preg_match("/^\./", $dom)) {
      foreach (scandir("$listdir/$dom") AS $listn) {
        if (! preg_match("/^\./", $listn)) {
          $lists[] = $listn . '@' . $dom;
        }
      }
    }
  }
  return $lists;
}

function get_subscribers($listpath) {
  global $cmddir;
  $errmsg = '';

  $cmd = $cmddir . "mlmmj-list -L " . escapeshellarg("$listpath") . " 2>&1";
  unset($out);
  exec($cmd, $out, $ret);
  if ($ret !== 0) {
    return "* Error: Could not get subscribers list: " . $listpath . ' ' . $cmd;
  }
  else {
    // clean up and check
    $emails = array();
    foreach ($out as $email) {
      $email = trim($email);
      if (! empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $emails[] = $email;
      }
    }
    // all in $emails
    return $emails;

  }
}

// $subs can be more than one line
function add_subscriber($listpath, $subs) {
  global $cmddir;
  $errmsg = '';
  foreach (preg_split('/\r\n|\n|\r/', $subs) as $line) {
    $email = trim($line);
    if ($email != "") {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $cmd = $cmddir . "mlmmj-sub -s -L " . escapeshellarg("$listpath") . " -a " . escapeshellarg($email) . " 2>&1";
        unset($out);
        exec($cmd, $out, $ret);
        if ($ret !== 0) {
          $errmsg .= "* Subscribe error for $email\ncommand: $cmd\nreturn code: $ret\noutput: ".implode("\n", $out)."\n";
        }
      }
      else {
        $errmsg .= "* Email address not valid: $email\n";
      }
    }
  }
  if (empty($errmsg)) {
    $errmsg .= "Email " . $email . " added";
  }
  return $errmsg;

}

function delete_subscriber($listpath, $sub) {
  global $cmddir;
  $errmsg = '';
  if (filter_var($sub, FILTER_VALIDATE_EMAIL)) {
    $cmd = $cmddir . "mlmmj-unsub -L " . escapeshellarg("$listpath") . " -a " . escapeshellarg($sub) . " 2>&1";
    unset($out);
    exec($cmd, $out, $ret);
    if ($ret !== 0) {
      $errmsg .= "* Unsubscribe error.\ncommand: $cmd\nreturn code: $ret\noutput: ".implode("\n", $out)."\n";
    }

  }
  else {
    $errmsg .= "* Email address not valid: $sub\n";
  }
  return $errmsg;

}

function get_listpath($list) {
  $listpath = "";
  if (filter_var($list, FILTER_VALIDATE_EMAIL)) {
    $a = explode("@", $list);
    $listname = $a[0];
    $dom      = $a[1];
    $listpath = "$dom/$listname";
  }
  return $listpath;
}

// Perl's encode_entities (to be able to use tunables.pl)
function encode_entities($str) {
  return htmlentities($str);
}
