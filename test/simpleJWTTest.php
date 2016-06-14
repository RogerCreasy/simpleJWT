<?php
/**
 * Created by PhpStorm.
 * User: Roger Creasy
 * Date: 0014 6/14/2016
 * Time: 10:44
 */


namespace RogerCreasy\SimpleJWT;


class SimpleJWTTEST extends \PHPUnit_Framework_TestCase
{
    //testing

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
}