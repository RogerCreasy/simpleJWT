<?php
/**
 * User: Roger Creasy
 * Date: 0008 6/8/2016
 * Time: 10:24
 */

namespace RogerCreasy\SimpleJWT;

class SimpleJWT
{
    private static $hashAlgorithm = array(
        'HS256' => 'sha256',
        'HS512' => 'sha512'
    );

    public static function encode($payload = ' ', $key = 'this is the secret phrase', $alg = 'HS512', $keyId = null, $head = null)
    {
        //encode JWT
        $header = array('typ' => 'JWT', 'alg' => $alg);

        //payload hardcoded here for testing
        // In production, this will be dynamically created
        /*$payload = array('iss' => 'http://myapi.com',
                         'sub' => '1234567890',
                         'name' => 'John Doe',
                         'scope' => 'API',
                         'admin' => true);*/

        $JWT = array();
        $JWT[] = self::base64urlEncode(json_encode($header));
        $JWT[] =  self::base64urlEncode(json_encode($payload));
        $signature = implode('.', $JWT);
        $signature = hash_hmac(self::$hashAlgorithm[$alg], $signature, $key, true);
        $JWT[] = self::base64urlEncode($signature);
        $output = implode('.', $JWT);
        return $output;
    }

    public static function decode($jwt, $key)
    {
        //decode JWT
        $jwtSegments = explode('.', $jwt);
        list($encodedHeader, $encodedPayload, $encodedSignature) = $jwtSegments;
        $header = json_decode(self::base64urlDecode($encodedHeader));
        $payload = json_decode(self::base64urlDecode($encodedPayload));
        $signature = self::base64urlDecode($encodedSignature);

        //verify that the signature hash matches
        if (!self::verifySignature("$encodedHeader.$encodedPayload", $signature, $key, self::$hashAlgorithm[$header->alg])) {
            return 'Signature verification failed';
        }

        return $payload;

    }


    //Encode to base64 in a URL-safe manner
    private static function base64urlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    //decode the above
    private static function base64urlDecode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    //do the signature verify thang
    private static function verifySignature($message, $signature, $key, $algorithm)
    {
        $hash = hash_hmac($algorithm, $message, $key, true);
        return hash_equals($signature, $hash);
    }
}