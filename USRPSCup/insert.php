<?php
use \vendor\Doctrine\DBAL\DriverManager;

$connectionParams = array(
    'dbname' => 'shirtdb',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

$conn = \vendor\Doctrine\DBAL\DriverManager::getConnection($connectionParams);

$conn = DriverManager::getConnection($params, $config);

$sql = "SELECT * FROM shirts";
$stmt = $conn->query($sql); // Simple, but has several drawbacks

echo $stmt;
