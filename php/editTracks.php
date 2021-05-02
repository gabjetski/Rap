<?php
echo "lol<br>";
$stmntGetKey = $pdo->prepare("SELECT * FROM keysignature WHERE short = ?");
$stmntGetKey->bindParam(1, $_GET['tset-key'], PDO::PARAM_STR, 4000);
$stmntGetKey->execute();

$tagsSplitted = explode(",", $_GET['tset-tags']);
$_SESSION['tags'] = $tagsSplitted;

switch ($_GET['tset-type']) {
        case 'beat':
                $typeID = 1;
                break;
        case 'sample':
                $typeID = 2;
                break;
        case 'snippet':
                $typeID = 3;
                break;
}


$stmtEditTrack = $pdo->prepare("UPDATE `files` SET `fk_upload_type_id` = ?, 
                                        `fk_bpm_id` = ?, 
                                        `Title` = ?, 
                                        `Description` = ?, 
                                        `Tag1` = ?, `Tag2` = ?, `Tag3` = ?, `Tag4` = ?, `Tag5` = ?
                                WHERE `files`.`pk_files_id` = ?");
//define the in-parameters
$stmtEditTrack->bindParam(1, $typeID, PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(2, $_GET['tset-bpm'], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(3, $_GET['tset-title'], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(4, $_GET['tset-desc'], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(5, $tagsSplitted[0], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(6, $tagsSplitted[1], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(7, $tagsSplitted[2], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(8, $tagsSplitted[3], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(9, $tagsSplitted[4], PDO::PARAM_STR, 4000);
$stmtEditTrack->bindParam(10, $_GET['tset-track-id'], PDO::PARAM_INT);
$stmtEditTrack->execute();
