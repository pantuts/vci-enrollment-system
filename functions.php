<?php

// hashing password
// require_once 'passwordhash.php';
function hashPassword($passwd)
{
    // if (strlen($passwd) > 72) {
    //     return 'Only 72 password characters are allowed.';
    // } else {
    //     $hasher = new PasswordHash(8, false);
    //     return $hasher->HashPassword($passwd);
    // }
    $secret = '$3cr3t';
    $password = md5($passwd . $secret);
    return $password;
}

// student number
function studentNumber()
{
    $random = 'vci-';
    for ($i = 0; $i < 8; $i++) {
        $random .= rand(0,9);
    }
    return $random;
}

// activation link
function activationLink($email)
{
    $secret = 'ThisIsA$ecret';
    $hash = md5($email . $secret);
    $link = $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) .'/confirm.php?id=' . $hash;
    return $link;
}

// clean variables
function cleanVar($var)
{
    $c = htmlentities($var);
    return $c;
}

?>