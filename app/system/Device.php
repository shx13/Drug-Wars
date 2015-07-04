<?php

/**
* Device class
*
* detecting the device that is being used to browse the website
*/
class Device
{

  public static function detect() {

    // check the device being used, required by config::get('DEVICE'). (a bit dirty, need to rewrite this) 
    $detect = new Mobile_Detect;
    
    if($detect->isMobile() && !$detect->isTablet()){
      $device = 'mobile';
    }
    elseif($detect->isTablet()) {
      $device = 'tablet';
    }
    else {
      $device = 'desktop';
    }

    return $device;

  }

  public static function detectScreenResolution() {

    $screen['width'] = " <script>document.write(screen.width); </script>";
    $screen['height'] = "<script>document.write(screen.height); </script>";

    return $screen;

  }

  public static function detectBrowserSize() {

    $browser['width'] = " <script>document.write(window.innerWidth); </script>";
    $browser['height'] = "<script>document.write(window.innerHeight); </script>";

    return $browser;

  }

}
