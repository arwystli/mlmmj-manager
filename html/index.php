<?php

// application root
define("APP_ROOT", dirname(dirname(__FILE__)) . "/" );

if ( file_exists(APP_ROOT . "src/config.php")) {

  require_once( APP_ROOT . "src/config.php" );
  require_once( APP_ROOT . "src/functions.php" );
  require_once( APP_ROOT . "src/init.php" );
  require_once( APP_ROOT . "src/index.php" );
}
else {
  echo "File " . APP_ROOT . "src/config.php" . " does not exist. Please copy and edit " . APP_ROOT . "src/config.php.dist";
}
