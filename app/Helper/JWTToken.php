<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{
  public static function CreateToken($userEmail): string
  {
    $key = env('JWT_KEY'); // whish key use to create jwt token 
    
    $payload = [
      'iss' => 'laravel-token', //issuer of the token
      'iat' => time(), // jwt token start token time
      'exp' => time() + 60 * 60, // jwt end token time
      'userEmail' => $userEmail // identify who email login 
    ];
    return JWT::encode($payload, $key, "HS256"); // fainally create jwt token qureey
  }
  public static function VerifyToken($token): string
  {
    try {
      $key = env('JWT_KEY');
      $decode = JWT::decode($token, new Key($key, 'HS256'));
      return $decode->userEmail;
    } catch (Exception $exception) {
      return "unauthorized";
    }
  }
}
