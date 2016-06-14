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
    //

    public function testCorrectEncode()
    {
        $toBeEncoded = array('iss' => 'http://myapi.com',
            'sub' => '1234567890',
            'name' => 'John Doe',
            'scope' => 'API',
            'admin' => true);

        $result = SimpleJWT::encode($toBeEncoded);

        $expectedResult = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9teWFwaS5jb20iLCJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwic2NvcGUiOiJBUEkiLCJhZG1pbiI6dHJ1ZX0.-xFE5ixJ10g5jEXq2IDxk-Btgy4BviyoyFE4JWN1u2acOSKtTCC_FsgGHhI9R8zCLe3gj2HYJnEsjj0smtY5qQ";
        $this->assertEquals($expectedResult, $result);
    }
}