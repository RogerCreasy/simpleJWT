<?php
/**
 * Created by PhpStorm.
 * User: CGC User
 * Date: 0008 6/8/2016
 * Time: 14:33
 */

require __DIR__ . '/../vendor/autoload.php';
use \RogerCreasy\SimpleJWT\SimpleJWT;

$claims = SimpleJWT::decode('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9teWFwaS5jb20iLCJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwic2NvcGUiOiJBUEkiLCJhZG1pbiI6dHJ1ZX0.-xFE5ixJ10g5jEXq2IDxk-Btgy4BviyoyFE4JWN1u2acOSKtTCC_FsgGHhI9R8zCLe3gj2HYJnEsjj0smtY5qQ', 'this is the secret phrase');
return $claims;
/*foreach($claims as $claim => $value)
{
    echo $claim . ': ' . $value . '\r\n';
}
*/