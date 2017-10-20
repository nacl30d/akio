<?php

// DB接続
function connectDB()
{
    require_once('./conf/config.php');
	$dsn = "mysql:dbname=$db_name;host=$host;port=$port; charset=utf8;";
	
	try {
		$pdo = new PDO($dsn, $db_user);//, $db_passwd);
	} catch (PDOException $e) {
		die('DB Connection Faild');
	}
	return $pdo;
}

// ユーザーから入力された文字を安全な文字列に変換する(HTMLエスケープ)
function h($string) {
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
