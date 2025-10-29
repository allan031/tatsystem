<?php
ob_start();
//session_start(); // Start the session

//add reference for authenticate class
include_once dirname(__DIR__, 1) . '/tatsystem/class/authenticate.class.php';

$authenticateuser = new AuthenticateUser();

// Check if the session variable is set before using it
if (isset($_SESSION['username'])) {
    // Call the IsLogout method with the username
    if ($authenticateuser->IsLogout($_SESSION['username']) == true) {
        session_unset(); // Destroy the session if IsLogout returns true
    }
} else {
    echo "Username is not set in session.";
}

// Redirect to login page after 1 second
header("refresh:0; url=./login.php");
exit();
?>
