<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class CodeGenerator
{
  public static function generateRandomCode($length = 8)
  {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomCode = '';

    for ($i = 0; $i < $length; $i++) {
      $randomCode .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $randomCode;
  }
}
