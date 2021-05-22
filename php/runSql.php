<?php
$sql = file_get_contents('main.sql');
$qr = $pdo->exec($sql);
header('Location:/home');
