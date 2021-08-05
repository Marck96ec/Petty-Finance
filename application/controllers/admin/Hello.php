<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Guayaquil');
class Hello extends CI_Controller
{
  public function index()
  {
    echo "Hello, World" . PHP_EOL;
  }
  public function greet($name)
  {
   echo "Hello, $name" . PHP_EOL;
  }
}