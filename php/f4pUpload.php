<?php

unset($_SESSION['uploadError']);
unset($_SESSION['uploadSuccess']);

//check if file was already uploaded with same information --> prevents from uploading twice throu page refresh 

if (isset($_SESSION['uploadCheck']) && $_SESSION['uploadCheck'] == $_POST) {
} else {
  //replace specialchars in title for filename
  $title_replaced = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $_POST['f4pUpload-title']);
  //htmlspecialchar Get Array to store it safely
  array_walk_recursive($_POST, "filter");

  if ($_FILES['f4pUpload-file']['size'] == 0) {
    $_SESSION['uploadError']['id'] = -10;
  }


  //check if uploaded file is an MP3 File
  elseif (strtolower(pathinfo($_FILES['f4pUpload-file']['name'], PATHINFO_EXTENSION)) != 'mp3') {
    $_SESSION['uploadError']['id'] = -11;
    //echo "File must be a mp3 file";
    //check if uploaded file is to large
  } elseif ($_FILES["f4pUpload-file"]["size"] > 104857600) { //104857600
    $_SESSION['uploadError']['id'] = -12;
    //echo "Sorry, your file is too large.";
  } elseif ($_POST['f4pUpload-bpm'] == '') {
    $_SESSION['uploadError']['id'] = -13;
  } elseif ($_POST['f4pUpload-title'] == '') {
    $_SESSION['uploadError']['id'] = -14;
  } else {
    //store information to compare at next upload
    $_SESSION['uploadCheck'] = $_POST;
    //split tags
    $tagsSplitted = explode(",", $_POST['f4pUpload-tags']);
    // $_SESSION['tags'] = $tagsSplitted;
    //Prepare Procedure call
    $stmntUploadF4P = $pdo->prepare("CALL addTrack(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'f4p', @id);");
    //define the in-parameters
    $stmntUploadF4P->bindParam(1, $_POST['f4pUpload-title'], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(2, $title_replaced, PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(3, $tagsSplitted[0], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(4, $tagsSplitted[1], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(5, $tagsSplitted[2], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(6, $tagsSplitted[3], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(7, $tagsSplitted[4], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(8, $_POST['f4pUpload-desc'], PDO::PARAM_STR, 12000);
    $stmntUploadF4P->bindParam(9, $_SESSION['userID'], PDO::PARAM_STR, 5000);
    $stmntUploadF4P->bindParam(10, $_POST['f4pUpload-bpm'], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(11, $_POST['f4pUpload-key'], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(12, $_POST['f4pUpload-type'], PDO::PARAM_STR, 4000);
    // execute stmnt
    $stmntUploadF4P->execute();

    //Select the out parameter into variable
    $sql = "SELECT @id AS id";
    $stmtGetId = $pdo->prepare($sql);
    $stmtGetId->execute();
    foreach ($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row) {
      $id = $row['id'];
    }
    //check if id is negative which means an error is thrown
    if ($id > 0) {
      // if procedure runed without error, put together information for final filename
      $target_file = substr($title_replaced, 0, 10);
      $target_file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $target_file);
      //Filename is <Trackid>#<First 10 Chars of Trackname>
      $target_file = 'uploads/' . $id . '#' . $target_file . '.mp3';

      //move file to destination
      if (move_uploaded_file($_FILES["f4pUpload-file"]["tmp_name"], $target_file)) {
        // if sucessful, store information in session and reload
        $_SESSION['uploadSuccess'] = basename($_FILES["f4pUpload-file"]["name"]);
      } else {
        // if not store error and information in session and reload
        $_SESSION['uploadError']['id'] = '-99';
        //delete db row
        $stmntDeleteTrackRow = $pdo->prepare("DELETE FROM `files` WHERE `files`.`pk_files_id` = ?;");
        $stmntDeleteTrackRow->bindParam(1, $id, PDO::PARAM_STR, 4000);
        $stmntDeleteTrackRow->execute();

        $stmntResetAutoIncrement = $pdo->prepare("SET @max_id = (SELECT MAX(pk_files_id) FROM `files` );
      SET @sql = CONCAT('ALTER TABLE `files` AUTO_INCREMENT = ', @max_id);
      PREPARE st FROM @sql;
      EXECUTE st;");
        $stmntResetAutoIncrement->execute();
      }
    } else {
      // if other error store in session and reload
      $_SESSION['uploadError']['id'] = $id;
    }
    //echo "<br><br>";
    //var_dump($id);
  }
}

if (isset($_SESSION['uploadSuccess'])) {
  unset($_SESSION['uploadError']);
  header('Location:index.php');
} elseif (isset($_SESSION['uploadError'])) {
  $_SESSION['uploadError']['name'] = basename($_FILES["f4pUpload-file"]["name"]);
  $_SESSION['uploadError']['type'] = 'f4p';
  $_SESSION['uploadError']['post'] = $_POST;
  $_SESSION['uploadError']['files'] = $_FILES;
  header('Location:index.php');
}
