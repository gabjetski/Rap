<!-- INSERT INTO archiveFiles SELECT * FROM files WHERE pk_files_id = 1 
DELETE FROM files WHERE pk_files_id = 1  -->
<?php

$stmtDelTrack = $pdo->prepare("INSERT INTO archiveFiles SELECT * FROM files WHERE pk_files_id = ?; 
                                DELETE FROM files WHERE pk_files_id = ?");
//define the in-parameters
$stmtDelTrack->bindParam(1, $_GET['tset-track-id'], PDO::PARAM_INT);
$stmtDelTrack->bindParam(2, $_GET['tset-track-id'], PDO::PARAM_INT);
$stmtDelTrack->execute();

header('location: /user/my');
