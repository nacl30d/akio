<?php
$db = [
    'provider' => getenv('DB_PROVIDER') ?: 'pgsql',
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => getenv('DB_PORT') ?: '3306',
    'database' => getenv('DB_DATABASE') ?: 'akio',
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: 'root'
];

// リダイレクトする際の自サイトの情報
$url = getenv('BASE_URL') ?: 'localhost:8000';
