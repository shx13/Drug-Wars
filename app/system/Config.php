<?php

class Config
{
  private static $config;

  public static function get($key)
  {
    if (!self::$config) {
      self::$config = require('../app/config/config.' . Environment::get() . '.php');
    }

    return self::$config[$key];
  }

}
