<?php
/**
 * Created by PhpStorm.
 * User: Roger Creasy
 * Date: 0014 6/14/2016
 * Time: 10:44
 */

namespace RogerCreasy\SimpleJWT;
require __DIR__ . '/../vendor/autoload.php';

class SimpleJWTTEST extends \PHPUnit_Framework_TestCase
{

    //test that claims are correctly encoded
    public function testCorrectEncode()
    {
        $toBeEncoded = array('iss' => 'http://RogerCreasy.com',
            'sub' => '1234567890',
            'name' => 'Roger Creasy',
            'scope' => 'API',
            'admin' => false);

        $result = SimpleJWT::encode($toBeEncoded);

        $expectedResult = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9Sb2dlckNyZWFzeS5jb20iLCJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IlJvZ2VyIENyZWFzeSIsInNjb3BlIjoiQVBJIiwiYWRtaW4iOmZhbHNlfQ.Q-No8PSMVTv_zri0fUatnTRgrsc49JuLV0BpyJW3jfr60_stQLV3zboh59AwZRGASgwkhRjWafYYq-epdvH1Bw";
        $this->assertEquals($expectedResult, $result);
    }


    //test that claims are correctly decoded
    public function testCorrectDecode()
    {
        $toBeDecoded = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9Sb2dlckNyZWFzeS5jb20iLCJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IlJvZ2VyIENyZWFzeSIsInNjb3BlIjoiQVBJIiwiYWRtaW4iOmZhbHNlfQ.Q-No8PSMVTv_zri0fUatnTRgrsc49JuLV0BpyJW3jfr60_stQLV3zboh59AwZRGASgwkhRjWafYYq-epdvH1Bw";
        $key = 'this is the secret phrase';

        $result = SimpleJWT::decode($toBeDecoded, $key);
        $result = json_encode($result, JSON_FORCE_OBJECT);

        $expectedResult = array('iss' => 'http://RogerCreasy.com',
            'sub' => '1234567890',
            'name' => 'Roger Creasy',
            'scope' => 'API',
            'admin' => false);

        $expectedResult = json_encode($expectedResult, JSON_FORCE_OBJECT);
        $this->assertEquals($expectedResult, $result);
    }

    // test that incorrect key causes failure
    public function testIncorrectDecode()
    {
        $toBeDecoded = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9Sb2dlckNyZWFzeS5jb20iLCJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IlJvZ2VyIENyZWFzeSIsInNjb3BlIjoiQVBJIiwiYWRtaW4iOmZhbHNlfQ.Q-No8PSMVTv_zri0fUatnTRgrsc49JuLV0BpyJW3jfr60_stQLV3zboh59AwZRGASgwkhRjWafYYq-epdvH1Bw";
        $key = 'this aint the secret phrase';

        $result = SimpleJWT::decode($toBeDecoded, $key);

        $expectedResult = 'Signature verification failed';

        $this->assertEquals($expectedResult, $result);
    }
}