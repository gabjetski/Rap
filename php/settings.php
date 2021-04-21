<?php
session_start();
try {
  //database connection
  $pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
  //function to htmlspecialchar Arrays -> prevent injections
  function filter(&$value)
  {
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
    
  // ANCHOR Username Validation
  if(isset($_GET['changeUsername'])){
    unset($_SESSION['usernameChange-Error']);
    $stmntGetUsernames = $pdo->prepare("SELECT Username FROM user");
    $stmntGetUsernames->execute();
    
    // neuer Username ist vergeben
    foreach ($stmntGetUsernames->fetchAll(PDO::FETCH_ASSOC) as $row) {
      echo "<br>" .$row['Username']. " - ". $_GET['newUsername'];
        if($_GET['newUsername'] == $row['Username']){
          echo "<hr>";
          $_SESSION['usernameChange-Error']['value'] = $_GET['newUsername'];
          $_SESSION['usernameChange-Error']['id'] = -1;
          header('Location:/user/my/settings');
        }
      }

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if(!preg_match("/^[a-zA-Z0-9ÄÜÖäüö_.\-]{3,20}$/u", $_GET['newUsername'])){
      echo "akdafuigidash";
      $_SESSION['usernameChange-Error']['value'] = $_GET['newUsername'];
      $_SESSION['usernameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    } 
    // keine Fehler
    if(!isset($_SESSION['usernameChange-Error'])) {
    $updateUsername = $pdo->prepare('UPDATE user set Username="'.$_GET['newUsername'].'" where pk_user_id = '.$_SESSION['userID']);
    $updateUsername->execute();
    header('Location:/user/my/settings');
    }
  }

  // ANCHOR Email Validations
  if(isset($_GET['changeEmail'])){
    unset($_SESSION['emailChange-Error']);
    $stmntGetUsernames = $pdo->prepare("SELECT Email FROM user");
    $stmntGetUsernames->execute();
    
    // neuer Username ist vergeben
    foreach ($stmntGetUsernames->fetchAll(PDO::FETCH_ASSOC) as $row) {
      echo "<br>".$row['Email']." - ". $_GET['newEmail'];
        if($_GET['newEmail'] == $row['Email']){
          echo "<hr>";
          $_SESSION['emailChange-Error']['value'] = $_GET['newEmail'];
          $_SESSION['emailChange-Error']['id'] = -1;
          header('Location:/user/my/settings');
        }
      }

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if(!preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/u", $_GET['newEmail'])){
      echo "akdafuigidash";
      $_SESSION['emailChange-Error']['value'] = $_GET['newEmail'];
      $_SESSION['emailChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    } 
    // keine Fehler
    if(!isset($_SESSION['emailChange-Error'])) {
    $updateUsername = $pdo->prepare('UPDATE user set Email="'.$_GET['newEmail'].'" where pk_user_id = '.$_SESSION['userID']);
    $updateUsername->execute();
    header('Location:/user/my/settings');
    }
  }


  // ANCHOR Password Validations und Änderungen
  if(isset($_GET['changePassword'])){
    unset($_SESSION['passwordChange-Error']);
    $oldPassword = $pdo->query('SELECT Passwort from User where pk_user_id = '.$_SESSION['userID']);
    $oldPassword2 = $oldPassword->fetch(PDO::FETCH_ASSOC);
    //echo '<div>' . $_GET['newPassword'] . '</div>';
    $hashedPassword = sha1($_GET['newPassword']);
    echo $hashedPassword;
    print_r($oldPassword2);
    // Altes Passwort ist neues
    if($hashedPassword == $oldPassword2['Passwort']){
      echo "<hr>";
      $_SESSION['passwordChange-Error']['value'] = $_GET['newPassword'];
      $_SESSION['passwordChange-Error']['id'] = -1;
      header('Location:/user/my/settings');
    } 

    // Passwort hat Validations gefailed
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.\-ÄÜÖäüö]{7,30}$/u", $_GET['newPassword'])){
      $_SESSION['passwordChange-Error']['value'] = $_GET['newPassword'];
      $_SESSION['passwordChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    } 
    // keine Fehler
    if(!isset($_SESSION['passwordChange-Error'])) {
    $updateUsername = $pdo->prepare('UPDATE user set Passwort="'.sha1($_GET['newPassword']).'" where pk_user_id = '.$_SESSION['userID']);
    $updateUsername->execute();
    //header('Location:/user/my/settings');
    }
  }

  // Wenn ein Error Auftritt, SettingsError aufrufen
    if (isset($_SESSION['emailChange-Error'])) {
        require "settingsError.php";
    }
    
    if (isset($_SESSION['usernameChange-Error'])) { 
        require "settingsError.php";
    }

    if (isset($_SESSION['passwordChange-Error'])) {
      require "settingsError.php";
    }
  
  /*if (isset($_GET['quickLog'])) {
    session_destroy();
    session_start();
    $_SESSION['userID'] = '4';
    header('Location:/user/my/settings');
  }*/

  

  
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Rap</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  </head>

  <body>
    <h2><a href="/home"> Rap Plattform</a></h2>
    <?php
    // ANCHOR: PHP Zeugs
    //show login/register button if guest
    ?>

    <?php
    var_dump($_SESSION);
    // ANCHOR: PHP Zeugs
    //show login/register button if guest
    if (!isset($_SESSION['userID'])) {
      echo 'Nicht angemeldet';
    }
    //show username and id if logged in
    elseif ($_SESSION['userID'] > 0) {
      $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = " . $_SESSION['userID']);
      $stmntGetUserInfos->execute();
      $oldPassword = $pdo->prepare('SELECT Passwort from User where pk_user_id = '.$_SESSION['userID']);
      $oldPassword->execute();
      foreach ($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $_SESSION['userName'] = $row['Username'];
        $_SESSION['email'] = $row['Email'];
      }

      

      echo '<div class="profileForm"><i class="fa fa-user">' . $_SESSION['userName'] . '</i></div>';
      echo '<div class="profileForm"><i class="fa fa-envelope">' . $_SESSION['email'] . '</i></div>';
    }
    ?>

    <!-- Username Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container" id="usernameForm">
      <input type="text" placeholder="Enter new Username" name="newUsername" id="change-username" required>
      <input type="submit" name="changeUsername" id="changeUsername" value="Change" /> <!--index.php?newUsername=peter&changeUsername=Change-->
    </form>

    <!-- Email Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter new Email" name="newEmail" id="change-email" required>
      <input type="submit" name="changeEmail" id="changeEmail" value="Change" /> <!--index.php?newUsername=peter&changeUsername=Change-->
    </form>

    <!-- Password Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Password" name="newPassword" id="change-password" required>
      <input type="submit" name="changePassword" id="changePassword" value="Change"/>
    </form>

    <!-- Password Change Repeat
    <form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="password" placeholder="Repeat Password" name="changePasswordRepeat" id="change-password-repeat" required>
      <input type="submit" name="changePasword" id="changePassword" value="Change"/>
    </form>

    -->


    <br>
    <hr>
    <br>

    <?php
    $feedPurp = 'profile';
    require "./feed.php";
    ?>
  <?php
  $pdo = null;
} catch (PDOException $e) {
  //catch potentual error
  print "Error!: " . $e->getMessage() . "<br>";
  die();
}

  ?>