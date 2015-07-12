<?php

/*
* Configuration for DEV environment
* To create another configuration set just copy this file to config.XXX.php
* Then add a SetEnv=XXX command in your webserver conf or in pub/.htaccess 
*/

/*
* Error reporting
* Don't show errors for env different than development
*/
error_reporting(E_ALL);
ini_set("display_errors", 1);

// extend the session lifetime (be careful with this)
ini_set('session.gc_maxlifetime', 0);

/*
* Return the full configuration, used by system/Config class
*/
return array(
  /**
   * Base URL
   * This automatically detects your URL/IP inc. sub-folder.
   * If you want to set it manually, make it look like this: 'http://192.168.123.123/' ! Note the slash in the end.
   */
  'URL' => 'http://' . $_SERVER['HTTP_HOST'] . str_replace('pub', '', dirname($_SERVER['SCRIPT_NAME'])),
  
  // device that is being used for browsing the website
  'DEVICE' => Device::detect(),
  
  /**
   * Folders paths
   */
  'PATH_CONTROLLER' => realpath(dirname(__FILE__).'/../../') . '/app/controller/',
  'PATH_VIEW' => realpath(dirname(__FILE__).'/../../') . '/app/view/',
  
  /**
   * Default controller and action
   */
  'DEFAULT_CONTROLLER' => 'index',
  'DEFAULT_ACTION' => 'index',
  
  /**
   * Configuration for: Database
   * DB_TYPE The used database type. Note that other types than "mysql" might break the db construction currently.
   * DB_HOST The mysql hostname, usually localhost or 127.0.0.1
   * DB_NAME The database name
   * DB_USER The username
   * DB_PASS The password
   * DB_PORT The mysql port, 3306 by default (?), find out via phpinfo() and look for mysqli.default_port.
   * DB_CHARSET The charset, necessary for security reasons. Check Database.php class for more info.
   */
	'DB_TYPE' => 'mysql',
	'DB_HOST' => 'localhost',
	'DB_NAME' => 'dbname',
	'DB_USER' => 'username',
	'DB_PASS' => 'password',
	'DB_PORT' => '3306',
	'DB_CHARSET' => 'utf8',
  
  /**
   * Configuration for: Cookies
   * 1209600 seconds = 2 weeks
   * COOKIE_PATH is the path the cookie is valid on, usually "/" to make it valid on the whole domain.
   * @see http://stackoverflow.com/q/9618217/1114320
   * @see php.net/manual/en/function.setcookie.php
   */
  'COOKIE_RUNTIME' => 1209600,
  'COOKIE_PATH' => '/',
);
