<?php

//$db_name = 'mysql:host=localhost;dbname=food_db';
//$user_name = 'root';
//$user_password = '';

//$conn = new PDO($db_name, $user_name, $user_password);







//$db_name = "mysql:host=127.0.0.1;port=3307;dbname=food_db;charset=utf8";
//$user_name = "root";
//$user_password = "";

//try {
  //  $conn = new PDO($db_name, $user_name, $user_password);
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Database Connected Successfully";
//} catch (PDOException $e) {
  //  die("Connection Failed: " . $e->getMessage());
//}



$envPath = __DIR__ . '/../.env';

$envValues = [
    'DB_HOST' => '127.0.0.1',
    'DB_PORT' => '3307',
    'DB_NAME' => 'food_db',
    'DB_USER' => 'root',
    'DB_PASS' => ''
];

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) continue;
        if (strpos($line, '=') === false) continue;

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        $envValues[$key] = $value;
        putenv("$key=$value");
        $_ENV[$key] = $value;
    }
}

$db_name = "mysql:host=" . $envValues['DB_HOST']
    . ";port=" . $envValues['DB_PORT']
    . ";dbname=" . $envValues['DB_NAME']
    . ";charset=utf8";
$user_name = $envValues['DB_USER'];
$user_password = $envValues['DB_PASS'];

try {
    $conn = new PDO($db_name, $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Database Connected Successfully"; // uncomment only for testing
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}





?>