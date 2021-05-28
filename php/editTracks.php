<?php
//htmlspecialchar Get Array to store it safely
array_walk_recursive($_GET, "filter");
//get new key-signature
$stmntGetKey = $pdo->prepare("SELECT * FROM keysignature WHERE short = ?");
$stmntGetKey->bindParam(1, $_GET['tset-key'], PDO::PARAM_STR, 4000);
$stmntGetKey->execute();

//split tag-array
$tagsSplitted = explode(",", $_GET['tset-tags']);

//unset old errors
unset($_SESSION['trackEdit-error']);

//set number of typeid
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
        default:
                $_SESSION['trackEdit-error']['id'] = '-1';
                break;
}
//check if bpm is in range
if ($_GET['tset-bpm'] > 999 || $_GET['tset-bpm'] < 0) {
        $_SESSION['trackEdit-error']['id'] = '-2';
}
//match title for regex
if (!preg_match("/^.{0,60}$/u", $_GET['tset-title'])) {
        $_SESSION['trackEdit-error']['id'] = '-3';
}
//match description for regex
if (!preg_match("/^.{0,120}$/u", $_GET['tset-desc'])) {
        $_SESSION['trackEdit-error']['id'] = '-4';
}
//check tags for validity and count invalid tags
$i = 0;
$_SESSION['tagErrorCount'] = 0;
foreach ($tagsSplitted as $tag) {
        if (!preg_match("/^((\#(\w){0,30})|.{0})$/u", $tag)) {
                $_SESSION['tagErrorCount']++;
                $_SESSION['trackEdit-error']['id'] = '-5';
        }
}
//if none of the above checks went wrong
if (!isset($_SESSION['trackEdit-error'])) {
        //update track entry in db
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
        // TODO serverside validations

} else {
        //else store get values in variable (to fill in new values in the form again)
        $_SESSION['trackEdit-error']['get'] = $_GET;
}
//reload page
header('location: ' . $_SESSION['header']);
