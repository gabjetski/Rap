<?php
//vheck if file was already uploaded with same information --> prevents from uploading twice throu page refresh 
if (isset($_SESSION['uploadCheck']) && $_SESSION['uploadCheck'] == $_POST) {
}else{
  //store information to compare at next upload
  $_SESSION['uploadCheck'] = $_POST; 
  //replace specialchars in title for filename
  $title_replaced = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $_POST['taggedUpload-title']);
  //htmlspecialchar Post Array to store it safely
  array_walk_recursive($_POST, "filter");

  //check if uploaded file is an MP3 File
  // FIXME Error handling
  if (strtolower(pathinfo($_FILES['taggedUpload-file']['name'],PATHINFO_EXTENSION)) != 'mp3') {
      echo "File must be a mp3 file";
  //check if uploaded file is to large
  // FIXME Error handling
  }else if ($_FILES["taggedUpload-file"]["size"] > 104857600) {
      echo "Sorry, your file is too large.";
    }
  // FIXME Check for length
  else{

    //split tags
    $tagsSplitted = explode(" ", $_POST['taggedUpload-tags']);
    //Prepare Procedure call
    $stmntUploadTagged = $pdo->prepare("CALL addTrack(?, ?, '00:04:20', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'tagged', @id);");
    //define the in-parameters
    $stmntUploadTagged->bindParam(1, $_POST['taggedUpload-title'], PDO::PARAM_STR, 4000);
    $stmntUploadTagged->bindParam(2, $title_replaced, PDO::PARAM_STR, 4000);
    // NOTE do we really need length?
    $stmntUploadTagged->bindParam(3, $tagsSplitted[0], PDO::PARAM_STR, 4000);
    $stmntUploadTagged->bindParam(4, $tagsSplitted[1], PDO::PARAM_STR, 4000);
    $stmntUploadTagged->bindParam(5, $tagsSplitted[2], PDO::PARAM_STR, 4000);
    $stmntUploadTagged->bindParam(6, $tagsSplitted[3], PDO::PARAM_STR, 4000);
    $stmntUploadTagged->bindParam(7, $tagsSplitted[4], PDO::PARAM_STR, 4000);
    $stmntUploadTagged->bindParam(8, $_POST['taggedUpload-desc'], PDO::PARAM_STR, 12000);
    $stmntUploadTagged->bindParam(9, $_SESSION['userID'], PDO::PARAM_STR, 5000);
    $stmntUploadTagged->bindParam(10, $_POST['taggedUpload-bpm'], PDO::PARAM_STR, 4000);
    $stmntUploadTagged->bindParam(11, $_POST['taggedUpload-key'], PDO::PARAM_STR, 4000);
    $stmntUploadTagged->bindParam(12, $_POST['taggedUpload-type'], PDO::PARAM_STR, 4000);
    // execute stmnt
    $stmntUploadTagged->execute();

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
        $target_file = 'uploads/'.$id.'#'.$target_file.'.mp3';
        
      //move file to destination
      if (move_uploaded_file($_FILES["taggedUpload-file"]["tmp_name"], $target_file)) {
        // if sucessful, store information in session and reload
        $_SESSION['uploadSuccess'] = basename( $_FILES["taggedUpload-file"]["name"]);
        unset($_SESSION['uploadError']);
        header('Location:index.php');
      } else {
        // if not store error and information in session and reload
        $_SESSION['uploadError']['name'] = basename( $_FILES["taggedUpload-file"]["name"]);
        $_SESSION['uploadError']['id'] = $id;
        $_SESSION['uploadError']['type'] = 'tagged';
        $_SESSION['uploadError']['post'] = $_POST;
        header('Location:index.php');
      }
    }
    else{
      // if other error store in session and reload
      $_SESSION['uploadError']['name'] = basename( $_FILES["taggedUpload-file"]["name"]);
      $_SESSION['uploadError']['id'] = $id;
      $_SESSION['uploadError']['type'] = 'tagged';
      $_SESSION['uploadError']['post'] = $_POST;
      header('Location:index.php');
    }
  }
}