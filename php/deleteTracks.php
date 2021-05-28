<?php
//copy track into archive and delete origin
$stmtDelTrack = $pdo->prepare("INSERT INTO archiveFiles SELECT * FROM files WHERE pk_files_id = ?; 
                                DELETE FROM files WHERE pk_files_id = ?");
//define the in-parameters
$stmtDelTrack->bindParam(1, $_GET['tset-track-id'], PDO::PARAM_INT);
$stmtDelTrack->bindParam(2, $_GET['tset-track-id'], PDO::PARAM_INT);
$stmtDelTrack->execute();
//reload
header('location: ' . $_SESSION['header']);
