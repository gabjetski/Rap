<?php

$stmntGetKey = $pod->prepare("SELECT * FROM keysignature WHERE short = ?");
$stmntGetKey->bindParam(1, $_GET['tset-key']), PDO::PARAM_STR, 4000;
$stmntGetKey->execute();

$tagsSplitted = explode(",", $_POST['f4pUpload-tags']);
$_SESSION['tags'] = $tagsSplitted;

$stmtEditTrack = $pdo->prepare("UPDATE `files` SET `fk_upload_type_id` = ?, 
                                                `fk_bpm_id` = ?, `Title` = ?, 
                                                `Description` = ?, 
                                                `Tag1` = ?, `Tag2` = '?, `Tag3` = ?, `Tag4` = ?, `Tag5` = ?, 
                                        WHERE `files`.`pk_files_id` = ?; ");
//define the in-parameters
$stmtEditTrack->bindParam(1, $_GET['tset-type'], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(2, $_GET['tset-type'], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(3, $tagsSplitted[0], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(4, $tagsSplitted[1], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(5, $tagsSplitted[2], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(6, $tagsSplitted[3], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(7, $tagsSplitted[4], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(8, $_POST['f4pUpload-desc'], PDO::PARAM_STR, 12000);
$stmtEditTrack->bindParam(9, $_SESSION['userID'], PDO::PARAM_STR, 5000);
$stmtEditTrack->bindParam(10, $_POST['f4pUpload-bpm'], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(11, $_POST['f4pUpload-key'], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(12, $_POST['f4pUpload-type'], PDO::PARAM_STR, 4000);

// 调用存储过程  !!Wichtig!!
$stmtEditTrack->execute();