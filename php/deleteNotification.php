<?php
$stmntDelNoti = $pdo->prepare("DELETE FROM `song_reaches_milestone` WHERE `song_reaches_milestone`.`pk_song_milestone_id` = ?");
$stmntDelNoti->bindParam(1, $_GET['nId']);
$stmntDelNoti->execute();

$_SESSION['delNoti'] = true;
header("Location:/home");
