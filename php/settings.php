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
  if(isset($_GET['changePassword']) && $_GET['newPassword'] == $_GET['newPasswordRepeat']){
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
      //header('Location:/user/my/settings');
    } 

    // Passwort hat Validations gefailed
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.\-ÄÜÖäüö]{7,30}$/u", $_GET['newPassword'])){
      $_SESSION['passwordChange-Error']['value'] = $_GET['newPassword'];
      $_SESSION['passwordChange-Error']['id'] = -2;
      //header('Location:/user/my/settings');
    } 
    // keine Fehler
    if(!isset($_SESSION['passwordChange-Error'])) {
    $updateUsername = $pdo->prepare('UPDATE user set Passwort="'.sha1($_GET['newPassword']).'" where pk_user_id = '.$_SESSION['userID']);
    $updateUsername->execute();
    //header('Location:/user/my/settings');
    }
  } else{
    $_SESSION['passwordChange-Error']['value'] = $_GET['newPassword'];
    $_SESSION['passwordChange-Error']['id'] = -3;
  }

  // ANCHOR First Name Validations und Änderungen
  if(isset($_GET['changeFirstName'])){
    unset($_SESSION['firstNameChange-Error']);
    $stmntGetFirstNames = $pdo->prepare("SELECT FirstName FROM user");
    $stmntGetFirstNames->execute();

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if(!preg_match("/^[a-zA-ZÄÜÖäüö]{1,}$/u", $_GET['newFirstName'])){
      echo "akdafuigidash";
      $_SESSION['firstNameChange-Error']['value'] = $_GET['newFirstName'];
      $_SESSION['firstNameChange-Error']['id'] = -1;
      header('Location:/user/my/settings');
    }
    /*
    if($_SESSION['firstName'] == $_GET['newFirstName']){
      $_SESSION['firstNameChange-Error']['value'] = $_GET['newFirstName'];
      $_SESSION['firstNameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    } */

    // keine Fehler
    if(!isset($_SESSION['firstNameChange-Error'])) {
    $updateFirstName = $pdo->prepare('UPDATE user set FirstName="'.$_GET['newFirstName'].'" where pk_user_id = '.$_SESSION['userID']);
    $updateFirstName->execute();
    header('Location:/user/my/settings');
    }
  }

  // ANCHOR Last Name Validations und Änderungen 
  if(isset($_GET['changeLastName'])){
    unset($_SESSION['lastNameChange-Error']);
    $stmntGetLastNames = $pdo->prepare("SELECT LastName FROM user");
    $stmntGetLastNames->execute();

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if(!preg_match("/^[a-zA-ZÄÜÖäüö]{1,}$/u", $_GET['newLastName'])){
      echo "akdafuigidash";
      $_SESSION['lastNameChange-Error']['value'] = $_GET['newLastName'];
      $_SESSION['lastNameChange-Error']['id'] = -1;
      header('Location:/user/my/settings');
    } 

    /*if($_SESSION['lastName'] == $_GET['newLastName']){
      $_SESSION['lastNameChange-Error']['value'] = $_GET['newLastName'];
      $_SESSION['lastNameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    }*/
    
    // keine Fehler
    if(!isset($_SESSION['lastNameChange-Error'])) {
    $updateLastName = $pdo->prepare('UPDATE user set LastName="'.$_GET['newLastName'].'" where pk_user_id = '.$_SESSION['userID']);
    $updateLastName->execute();
    header('Location:/user/my/settings');
    }
  }

  // ANCHOR Instagram Validations und Änderungen
  if(isset($_GET['changeInstagramName'])){
    unset($_SESSION['instagramNameChange-Error']);
    $stmntGetInstagram = $pdo->prepare("SELECT Insta FROM user");
    $stmntGetInstagram->execute();

    // vergebener Instagram Username
    foreach ($stmntGetInstagram->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if($_GET['newInstagramName'] == $row['Insta']){
          $_SESSION['instagramNameChange-Error']['value'] = $_GET['newInstagramName'];
          $_SESSION['instagramNameChange-Error']['id'] = -1;
          header('Location:/user/my/settings');
        }
      }

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if(!preg_match("/^[a-zA-Z0-9._]+$/u", $_GET['newInstagramName'])){
      echo "akdafuigidash";
      $_SESSION['instagramNameChange-Error']['value'] = $_GET['newInstagramName'];
      $_SESSION['instagramNameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    } 

    // keine Fehler
    if(!isset($_SESSION['instagramNameChange-Error'])) {
      $updateInstagramName = $pdo->prepare('UPDATE user set Insta="'.$_GET['newInstagramName'].'" where pk_user_id = '.$_SESSION['userID']);
      $updateInstagramName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Twitter Validations und Änderungen
  if(isset($_GET['changeTwitterName'])){
    unset($_SESSION['twitterNameChange-Error']);
    $stmntGetTwitter = $pdo->prepare("SELECT Twitter FROM user");
    $stmntGetTwitter->execute();

    // vergebener Instagram Username
    foreach ($stmntGetTwitter->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if($_GET['newTwitterName'] == $row['Twitter']){
          $_SESSION['twitterNameChange-Error']['value'] = $_GET['newTwitterName'];
          $_SESSION['twitterNameChange-Error']['id'] = -1;
          header('Location:/user/my/settings');
        }
      }

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if(!preg_match("/^[A-Za-z0-9_]+$/u", $_GET['newTwitterName'])){
      echo "akdafuigidash";
      $_SESSION['twitterNameChange-Error']['value'] = $_GET['newTwitterName'];
      $_SESSION['twitterNameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    } 

    // keine Fehler
    if(!isset($_SESSION['twitterNameChange-Error'])) {
      $updateTwitterName = $pdo->prepare('UPDATE user set Twitter="'.$_GET['newTwitterName'].'" where pk_user_id = '.$_SESSION['userID']);
      $updateTwitterName->execute();
      header('Location:/user/my/settings');
    }
  }

   // ANCHOR Soundcloud Validations und Änderungen
   if(isset($_GET['changeScName'])){
    unset($_SESSION['scNameChange-Error']);
    $stmntGetSc = $pdo->prepare("SELECT Soundcloud FROM user");
    $stmntGetSc->execute();

    // vergebener Instagram Username
    foreach ($stmntGetSc->fetchAll(PDO::FETCH_ASSOC) as $row) {
        if($_GET['newScName'] == $row['Soundcloud']){
          $_SESSION['scNameChange-Error']['value'] = $_GET['newScName'];
          $_SESSION['scNameChange-Error']['id'] = -1;
          header('Location:/user/my/settings');
        }
      }

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    // FIXME Soundcloud validation?
    if(!preg_match("/^[A-Za-z0-9_.]+$/u", $_GET['newScName'])){
      echo "akdafuigidash";
      $_SESSION['scNameChange-Error']['value'] = $_GET['newScName'];
      $_SESSION['scNameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    } 

    // keine Fehler
    if(!isset($_SESSION['scNameChange-Error'])) {
      $updateTwitterName = $pdo->prepare('UPDATE user set Soundcloud="'.$_GET['newScName'].'" where pk_user_id = '.$_SESSION['userID']);
      $updateTwitterName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Bio Validations und Änderungen
  if(isset($_GET['changeBioName'])){
    unset($_SESSION['bioNameChange-Error']);
    $stmntGetBio = $pdo->prepare("SELECT Bio FROM user");
    $stmntGetBio->execute();
    
    // keine Fehler
    if(!isset($_SESSION['bioNameChange-Error'])) {
      $updateBioName = $pdo->prepare('UPDATE user set Bio="'.$_GET['newBioName'].'" where pk_user_id = '.$_SESSION['userID']);
      $updateBioName->execute();
      header('Location:/user/my/settings');
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

    if (isset($_SESSION['firstNameChange-Error'])) {
      require "settingsError.php";
    }

    if (isset($_SESSION['lastNameChange-Error'])) {
      require "settingsError.php";
    }

    if (isset($_SESSION['instagramNameChange-Error'])) {
      require "settingsError.php";
    }

    if (isset($_SESSION['twitterNameChange-Error'])) {
      require "settingsError.php";
    }

    if (isset($_SESSION['scNameChange-Error'])) {
      require "settingsError.php";
    }

    if (isset($_SESSION['bioNameChange-Error'])) {
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
    <style>
    i{
      float:left;
    }
    </style>
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
        $_SESSION['firstName'] = $row['FirstName'];
        $_SESSION['lastName'] = $row['LastName'];
        $_SESSION['instagram'] = $row['Insta'];
        $_SESSION['twitter'] = $row['Twitter'];
        $_SESSION['soundcloud'] = $row['Soundcloud'];
        $_SESSION['bio'] = $row['Bio'];

      }

      echo '<hr>';
      echo '<div class="profileForm"><i class="fa fa-user"> FirstName: '. $_SESSION['firstName'] . '</i></div>';
      echo '<hr>';
      echo '<div class="profileForm"><i class="fa fa-user"> LastName: '. $_SESSION['lastName'] . '</i></div>';
      echo '<hr>';
      echo '<div class="profileForm"><i class="fa fa-user">' . $_SESSION['userName'] . '</i></div>';
      echo '<br>';
      echo '<div class="profileForm"> Bio: ' . $row['Bio']  . '</div>';
      echo '<hr>';
      echo '<div class="profileForm"><a href="https://www.instagram.com/' . $_SESSION['instagram'] . '" target="_blank"><i class="fa fa-instagram">' . $_SESSION['insta'] . '</i></a></div>';
      echo '<br>';
      echo '<div class="profileForm"><a href="https://twitter.com/' . $_SESSION['twitter'] . '" target="_blank"><i class="fa fa-twitter">' . $_SESSION['twitter'] . '</i></a></div>';
      echo '<br>';
      echo '<div class="profileForm"><a href="https://soundcloud.com/' . $row['Soundcloud'] . '" target="_blank"><i class="fa fa-soundcloud">' . $row['Soundcloud'] . '</i></a></div>';
      echo '<br>';
      echo '<div class="profileForm"><i class="fa fa-envelope">' . $_SESSION['mail'] . '</i></div>';
      echo '<hr>';
      echo '<hr>';

    
    
    }
    ?>


    <a href="/user/my"><i class="fa fa-arrow-circle-left fa-5x"></i></a>


    <!-- Username Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container" id="usernameForm">
      <input type="text" placeholder="Enter new Username" name="newUsername" id="change-username" value = "<?php echo $_SESSION['userName'] ?>">
      <input type="submit" name="changeUsername" id="changeUsername" value="Change" /> <!--index.php?newUsername=peter&changeUsername=Change-->
    </form>

    <!-- Email Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter new Email" name="newEmail" id="change-email" value = "<?php echo $_SESSION['email'] ?>">
      <input type="submit" name="changeEmail" id="changeEmail" value="Change" /> <!--index.php?newUsername=peter&changeUsername=Change-->
    </form>

    <!-- FIXME Passwort geht tbh überhaupt nicht, fixen! -->
    <!-- Password Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="password" placeholder="Enter Password" name="newPassword" id="change-password" maxlength="30" required>
      <input type="password" placeholder="Repeat Password" name="newPasswordRepeat" id="change-password-repeat" maxlength="30" required>
      <input type="submit" name="changePassword" id="changePassword" value="Change"/>
    </form>


    <!-- First Name Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter New First Name" name="newFirstName" id="change-firstName" value = "<?php echo $_SESSION['firstName'] ?>">
      <input type="submit" name="changeFirstName" id="changeFirstName" value="Change"/>
    </form>

    <!-- Last Name Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter New Last Name" name="newLastName" id="change-lastName" value = "<?php echo $_SESSION['lastName'] ?>">
      <input type="submit" name="changeLastName" id="changeLastName" value="Change"/>
    </form>

    <!-- Instagram Change / Instagram Connect -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Instagram Name" name="newInstagramName" id="change-instagramName" value = "<?php echo $_SESSION['instagram'] ?>">
      <input type="submit" name="changeInstagramName" id="changeInstagramName" value="Change"/>
    </form>

    <!-- Twitter Change / Twitter Connect -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Twitter Name" name="newTwitterName" id="change-twitterName" value = "<?php echo $_SESSION['twitter'] ?>">
      <input type="submit" name="changeTwitterName" id="changeTwitterName" value="Change"/>
    </form>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Sc Name" name="newScName" id="change-scName" value = "<?php echo $_SESSION['soundcloud'] ?>">
      <input type="submit" name="changeScName" id="changeScName" value="Change"/>
    </form>

    <!-- FIXME in Textarea wird die aktuelle Bio nicht angezeigt -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <textarea placeholder="Enter Bio" rows="4" cols="50" name="newBioName" id="change-bioName" value = "<?php echo $_SESSION['bio'] ?>" maxlength="200"></textarea>
      <input type="submit" name="changeBioName" id="changeBioName" value="Change"/>
    </form>

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