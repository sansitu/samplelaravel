<?php namespace Library;

use Illuminate\Http\Response;
use Config;

class Utilities
{
       
    public static function sendResponse($data, $httpCode){
       return (new Response(json_encode($data), $httpCode))->header('Content-Type', 'application/json');
    }
      
    public static function encrypt($string) {
        $secret_key    = Config::get('custom.defaultData.enc_secret');
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        return  base64_encode($output);
    }
    
    
    public static function decrypt($string) {
        $secret_key    = Config::get('custom.defaultData.enc_secret');
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        return  openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
   
}