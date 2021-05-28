<?php
//get main sql content
$sql = file_get_contents('main.sql');
//execute
$qr = $pdo->exec($sql);
//reload
header('Location:/home');
