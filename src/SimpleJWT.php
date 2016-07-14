<?php namespace RogerCreasy\SimpleJWT;
/**
 * User: Roger Creasy
 * Date: 0008 6/8/2016
 * Time: 10:24
 */



class SimpleJWT
{
    private static $hashAlgorithm = array(
        'HS256' => 'sha256',
        'HS512' => 'sha512'
    );

    public static function encode($payload = ' ', $key = 'this is the secret phrase', $alg = 'HS512')
    {
        //encode JWT
        $header = array('typ' => 'JWT', 'alg' => $alg);

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
        // handle php <5.6
        if(!function_exists('hash_equals'))
        {
            function hash_equals($str1, $str2)
            {
                if(strlen($str1) != strlen($str2))
                {
                    return false;
                }
                else
                {
                    $res = $str1 ^ $str2;
                    $ret = 0;
                    for($i = strlen($res) - 1; $i >= 0; $i--)
                    {
                        $ret |= ord($res[$i]);
                    }
                    return !$ret;
                }
            }
        }
        return hash_equals($signature, $hash);
    }
}