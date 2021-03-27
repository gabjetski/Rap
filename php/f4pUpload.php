<?php
//htmlspecialchar Get Array to store it safely
array_walk_recursive($_POST, "filter");

//split tags
$tagsSplitted = explode("|", $_POST['f4pUpload-tags']);
//Prepare Procedure call
$stmntUploadF4P = $pdo->prepare("CALL addTrack(?, '00:04:20', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'f4p', @id);");
//define the in-parameters
$stmntUploadF4P->bindParam(1, $_POST['f4pUpload-title'], PDO::PARAM_STR, 4000);
//do we really need length
$stmntUploadF4P->bindParam(2, $tagsSplitted[0], PDO::PARAM_STR, 4000);
$stmntUploadF4P->bindParam(3, $tagsSplitted[1], PDO::PARAM_STR, 4000);
$stmntUploadF4P->bindParam(4, $tagsSplitted[2], PDO::PARAM_STR, 4000);
$stmntUploadF4P->bindParam(5, $tagsSplitted[3], PDO::PARAM_STR, 4000);
$stmntUploadF4P->bindParam(6, $tagsSplitted[4], PDO::PARAM_STR, 4000);
$stmntUploadF4P->bindParam(7, $_POST['f4pUpload-desc'], PDO::PARAM_STR, 12000);
$stmntUploadF4P->bindParam(8, $_SESSION['userID'], PDO::PARAM_STR, 5000);
$stmntUploadF4P->bindParam(9, $_POST['f4pUpload-bpm'], PDO::PARAM_STR, 4000);
$stmntUploadF4P->bindParam(10, $_POST['f4pUpload-key'], PDO::PARAM_STR, 4000);
$stmntUploadF4P->bindParam(11, $_POST['f4pUpload-type'], PDO::PARAM_STR, 4000);

var_dump($stmntUploadF4P);
// 调用存储过程  !!Wichtig!!
$stmntUploadF4P->execute();

//Select the out parameter into variable
$sql = "SELECT @id AS id";
$stmtGetId = $pdo->prepare($sql);
$stmtGetId->execute();
foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
    $id = $row['id'];
}
//check if id is negative which means an error is thrown
if ($id > 0) {
    var_dump($_FILES);
    $target_file = 'uploads/'.$id.'#'.substr(basename($_FILES["f4pUpload-file"]["name"]), 0, 10).'mp3';
    var_dump($target_file);
}
//else log in
else{
}
echo "<br><br>";
var_dump($id);