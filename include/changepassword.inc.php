<?php

$encryptedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
$encryptedRePassword = password_hash($_POST["repassword"], PASSWORD_DEFAULT);

var_dump($encryptedPassword);
echo '<br/>';
var_dump($encryptedRePassword);