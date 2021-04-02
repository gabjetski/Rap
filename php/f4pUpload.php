<?php
//vheck if file was already uploaded with same information --> prevents from uploading twice throu page refresh 

if (isset($_SESSION['uploadCheck']) && $_SESSION['uploadCheck'] == $_POST) {
}else{
  //store information to compare at next upload
  $_SESSION['uploadCheck'] = $_POST; 
  //replace specialchars in title for filename
  $title_replaced = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $_POST['f4pUpload-title']);
  //htmlspecialchar Get Array to store it safely
  array_walk_recursive($_POST, "filter");

  if($_FILES['f4pUpload-file']['size'] == 0){
    $_SESSION['uploadError']['name'] = basename( $_FILES["f4pUpload-file"]["name"]);
    $_SESSION['uploadError']['id'] = -10;
    $_SESSION['uploadError']['type'] = 'f4p';
    $_SESSION['uploadError']['post'] = $_POST;
    header('Location:index.php');
  }


  //check if uploaded file is an MP3 File
  // FIXME Error handling
  if (strtolower(pathinfo($_FILES['f4pUpload-file']['name'],PATHINFO_EXTENSION)) != 'mp3') {
    $_SESSION['uploadError']['name'] = basename( $_FILES["f4pUpload-file"]["name"]);
    $_SESSION['uploadError']['id'] = -11;
    $_SESSION['uploadError']['type'] = 'f4p';
    $_SESSION['uploadError']['post'] = $_POST;
    header('Location:index.php');
      //echo "File must be a mp3 file";
      //check if uploaded file is to large
      // FIXME Error handling
  }else if ($_FILES["f4pUpload-file"]["size"] > 104857600) {
    $_SESSION['uploadError']['name'] = basename( $_FILES["f4pUpload-file"]["name"]);
    $_SESSION['uploadError']['id'] = -12;
    $_SESSION['uploadError']['type'] = 'f4p';
    $_SESSION['uploadError']['post'] = $_POST;
    header('Location:index.php');
      //echo "Sorry, your file is too large.";
    }
    // FIXME Check for length
  else{

    //split tags
    $tagsSplitted = explode(" ", $_POST['f4pUpload-tags']);
    $_SESSION['tags'] = $tagsSplitted;
    //Prepare Procedure call
    $stmntUploadF4P = $pdo->prepare("CALL addTrack(?, ?, '00:04:20', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'f4p', @id);");
    //define the in-parameters
    $stmntUploadF4P->bindParam(1, $_POST['f4pUpload-title'], PDO::PARAM_STR, 4000);
    $stmntUploadF4P->bindParam(2, $title_replaced, PDO::PARAM_STR, 4000);
    // NOTE do we really need length?
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
    foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
        $id = $row['id'];
  }
  //check if id is negative which means an error is thrown
  if ($id > 0) {        
      // if procedure runed without error, put together information for final filename
      $target_file = substr($title_replaced, 0, 10);
      $target_file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $target_file);
      //Filename is <Trackid>#<First 10 Chars of Trackname>
      $target_file = '../uploads/'.$id.'#'.$target_file.'.mp3';
      
    //move file to destination
    if (move_uploaded_file($_FILES["f4pUpload-file"]["tmp_name"], $target_file)) {
      // if sucessful, store information in session and reload
      $_SESSION['uploadSuccess'] = basename( $_FILES["f4pUpload-file"]["name"]);
      unset($_SESSION['uploadError']);
      header('Location:index.php');    
    } else {
      // if not store error and information in session and reload
      $_SESSION['uploadError']['name'] = basename( $_FILES["f4pUpload-file"]["name"]);
      $_SESSION['uploadError']['id'] = $id;
      $_SESSION['uploadError']['type'] = 'f4p';
      $_SESSION['uploadError']['post'] = $_POST;
      header('Location:index.php');
    }
  }
  else{
    // if other error store in session and reload
    $_SESSION['uploadError']['name'] = basename( $_FILES["f4pUpload-file"]["name"]);
    $_SESSION['uploadError']['id'] = $id;
    $_SESSION['uploadError']['type'] = 'f4p';
    $_SESSION['uploadError']['post'] = $_POST;
    header('Location:index.php');
  }
  //echo "<br><br>";
  //var_dump($id);
  }
}