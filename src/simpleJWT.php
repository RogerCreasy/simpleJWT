<?php
namespace SimpleJWT;
/**
 * User: Roger Creasy
 * Date: 0008 6/8/2016
 * Time: 10:24
 */

class SimpleJWT
{

    public static function encode($payload = ' ', $key = 'secret', $alg = 'HS256', $keyId = null, $head = null)
    {
        //encode JWT
        $header = array('typ' => 'JWT', 'alg' => $alg);
        $payload = array('iss' => 'http://myapi.com',
                         'sub' => '1234567890',
                         'name' => 'John Doe',
                         'scope' => 'API',
                         'admin' => true);

        $JWT = array();
        $JWT[] = self::base64urlEncode(json_encode($header));
        $JWT[] =  self::base64urlEncode(json_encode($payload));
        $signature = implode('.', $JWT);
        $signature = hash_hmac('sha256', $signature, $key, false);
        $JWT[] = self::base64urlEncode($signature);
        $output = implode('.', $JWT);
        echo $output;
    }

    public static function decode()
    {
        //decode JWT
    }



    private static function base64urlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64urlDecode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}