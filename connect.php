<?php
define('DB_DSN','mysql:host=127.0.0.1;dbname=serverside;charset=utf8');
define('DB_USER','serveruser');
define('DB_PASS','gorgonzola7!');

// PDO is PHP Data Objects
try {
    // Try creating a new PDO connection to MySQL.
    $db = new PDO(DB_DSN, DB_USER, DB_PASS);
} catch (PDOException $e) {
    print "Error: " . $e->getMessage();
    die(); // Force execution to stop on errors.
}
?>
