<?php
// Return current server time in ISO format
date_default_timezone_set('Asia/Manila');
echo json_encode([
    "serverTime" => date("Y-m-d H:i:s")
]);
?>
