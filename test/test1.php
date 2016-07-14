<?php
/**
 * Created by PhpStorm.
 * User: CGC User
 * Date: 0008 6/8/2016
 * Time: 14:33
 */

require __DIR__ . '/../vendor/autoload.php';

use RogerCreasy\SimpleJWT\SimpleJWT;

$toBeEncoded = array('iss' => 'http://RogerCreasy.com',
    'sub' => '1234567890',
    'name' => 'Roger Creasy',
    'scope' => 'API',
    'admin' => false);

SimpleJWT::encode($toBeEncoded);


