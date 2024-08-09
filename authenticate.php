<?php

// Manually parse the Authorization header when using the PHP built-in server.
if (!isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['HTTP_AUTHORIZATION'])) {
    // Check if the Authorization header starts with "Basic"
    if (stripos($_SERVER['HTTP_AUTHORIZATION'], 'Basic') === 0) {
        // Decode the base64-encoded username:password string
        list($user, $pass) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
        // Assign the values to the PHP_AUTH_USER and PHP_AUTH_PW variables
        $_SERVER['PHP_AUTH_USER'] = $user;
        $_SERVER['PHP_AUTH_PW'] = $pass;
    }
}

define('ADMIN_LOGIN','wally');
define('ADMIN_PASSWORD','mypass');

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
    || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)
    || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Our Blog"');
    exit("Access Denied: Username and password required.");
}
?>
