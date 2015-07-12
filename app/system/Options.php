<?php

class Options
{
  private static $options;

  public static function get($key)
  {
    if (!self::$options) {
      self::$options = require('../app/config/options.php');
    }

    return self::$options[$key];
  }

}
