<?php
// データベース接続に必要な情報
$host = '';
$db_name = '';
$db_user = '';
$db_passwd = '';

foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }
    
    $host = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $db_name = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
    $db_user = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $db_passwd = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

$link = mysqli_connect($host, $db_user, $db_passwd,$db_name);


if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

mysqli_close($link);


// リダイレクトする際の自サイトの情報
    $url = "http://akico.azurewebsites.net/";