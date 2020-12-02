<?php

// DB接続
function connectDB()
{
    require_once('./conf/config.php');
	$dsn = "{$db['provider']}:dbname={$db['database']};host={$db['host']};port={$db['port']};";

	try {
		$pdo = new PDO($dsn, $db['username'], $db['password']);
	} catch (PDOException $e) {
		die('DB Connection Faild');
	}
	return $pdo;
}

// ユーザーから入力された文字を安全な文字列に変換する(HTMLエスケープ)
function h($string) {
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
