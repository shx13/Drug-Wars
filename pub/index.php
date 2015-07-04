<?php

/**
 * SKELETOR
 *
 * @author shx
 * @link https://github.com/shx13/skeletor/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// problems with hashing
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
  require_once('../vendor/password_compatibility_library.php');
}

// Composer's PSR-4 autoloader
require '../vendor/autoload.php';

// Start our application
new Skeletor();
