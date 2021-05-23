<?php
session_start();
require_once "autoload.php";
try {
  //database connection
  $pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
  //function to htmlspecialchar Arrays -> prevent injections
  function filter(&$value)
  {
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

  if (isset($_GET['admin'])) {
    $_SESSION['header'] = "/user/{$_GET['userID']}/settings";
    if (!$userPerm->permission($_SESSION['userID'], 6)) {
      header("Location: /user/{$_GET['userID']}");
    }
  } else {
    $_SESSION['header'] = "/user/my/settings";
  }

  // ANCHOR Username Validation
  if (isset($_GET['changeUsername'])) {
    unset($_SESSION['usernameChange-Error']);
    $stmntGetUsernames = $pdo->prepare("SELECT Username FROM user");
    $stmntGetUsernames->execute();

    // neuer Username ist vergeben
    foreach ($stmntGetUsernames->fetchAll(PDO::FETCH_ASSOC) as $row) {
      echo "<br>" . $row['Username'] . " - " . $_GET['newUsername'];
      if ($_GET['newUsername'] == $row['Username']) {
        echo "<hr>";
        $_SESSION['usernameChange-Error']['value'] = $_GET['newUsername'];
        $_SESSION['usernameChange-Error']['id'] = -1;
        header('Location:/user/my/settings');
      }
    }

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if (!preg_match("/^[a-zA-Z0-9ÄÜÖäüö_.\-]{3,20}$/u", $_GET['newUsername'])) {
      $_SESSION['usernameChange-Error']['value'] = $_GET['newUsername'];
      $_SESSION['usernameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    }
    // keine Fehler
    if (!isset($_SESSION['usernameChange-Error'])) {
      $updateUsername = $pdo->prepare('UPDATE user set Username="' . $_GET['newUsername'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateUsername->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Email Validations
  if (isset($_GET['changeEmail'])) {
    unset($_SESSION['emailChange-Error']);
    $stmntGetUsernames = $pdo->prepare("SELECT Email FROM user");
    $stmntGetUsernames->execute();

    // neuer Username ist vergeben
    foreach ($stmntGetUsernames->fetchAll(PDO::FETCH_ASSOC) as $row) {
      echo "<br>" . $row['Email'] . " - " . $_GET['newEmail'];
      if ($_GET['newEmail'] == $row['Email']) {
        echo "<hr>";
        $_SESSION['emailChange-Error']['value'] = $_GET['newEmail'];
        $_SESSION['emailChange-Error']['id'] = -1;
        header('Location:/user/my/settings');
      }
    }

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if (!preg_match("/^[a-zA-z0-9._%+-]+@[a-zA-z0-9.-]+\.[a-z]{2,4}$/u", $_GET['newEmail'])) {
      echo "akdafuigidash";
      $_SESSION['emailChange-Error']['value'] = $_GET['newEmail'];
      $_SESSION['emailChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    }
    // keine Fehler
    if (!isset($_SESSION['emailChange-Error'])) {
      $updateUsername = $pdo->prepare('UPDATE user set Email="' . $_GET['newEmail'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateUsername->execute();
      header('Location:/user/my/settings');
    }
  }


  // ANCHOR Password Validations und Änderungen
  if (isset($_GET['changePassword'])) {
    if ($_GET['newPassword'] == $_GET['newPasswordRepeat']) {
      unset($_SESSION['passwordChange-Error']);
      $oldPassword = $pdo->query('SELECT Passwort from User where pk_user_id = ' . $_SESSION['userID']);
      $oldPassword2 = $oldPassword->fetchAll(PDO::FETCH_ASSOC);
      $oldPassword->closeCursor();
      //echo '<div>' . $_GET['newPassword'] . '</div>';
      $hashedPassword = sha1($_GET['newPassword']);

      echo $hashedPassword;

      print_r($oldPassword2);

      // Altes Passwort ist neues
      if ($hashedPassword == $oldPassword2['Passwort']) {
        echo "<hr>";
        $_SESSION['passwordChange-Error']['value'] = $_GET['newPassword'];
        $_SESSION['passwordChange-Error']['id'] = -1;
        header('Location:/user/my/settings');
      }

      // Passwort hat Validations gefailed
      if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.\-ÄÜÖäüö]{7,30}$/u", $_GET['newPassword'])) {
        $_SESSION['passwordChange-Error']['value'] = $_GET['newPassword'];
        $_SESSION['passwordChange-Error']['id'] = -2;
        header('Location:/user/my/settings');
      }
      // keine Fehler
      if (!isset($_SESSION['passwordChange-Error'])) {
        $updateUsername = $pdo->prepare('UPDATE user set Passwort="' . sha1($_GET['newPassword']) . '" where pk_user_id = ' . $_SESSION['userID']);
        $updateUsername->execute();
        header('Location:/user/my/settings');
      }
    } else {
      $_SESSION['passwordChange-Error']['value'] = $_GET['newPassword'];
      $_SESSION['passwordChange-Error']['id'] = -3;
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR First Name Validations und Änderungen
  if (isset($_GET['changeFirstName'])) {
    unset($_SESSION['firstNameChange-Error']);
    // ???
    $stmntGetFirstNames = $pdo->prepare("SELECT FirstName FROM user");
    // $stmntGetFirstNames->execute();

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if (!preg_match("/^[a-zA-ZÄÜÖäüö]{1,50}$/u", $_GET['newFirstName'])) {
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
    if (!isset($_SESSION['firstNameChange-Error'])) {
      $updateFirstName = $pdo->prepare('UPDATE user set FirstName="' . $_GET['newFirstName'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateFirstName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Last Name Validations und Änderungen 
  if (isset($_GET['changeLastName'])) {
    unset($_SESSION['lastNameChange-Error']);
    // ???
    $stmntGetLastNames = $pdo->prepare("SELECT LastName FROM user");
    // $stmntGetLastNames->execute();

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if (!preg_match("/^[a-zA-ZÄÜÖäüö]{1,50}$/u", $_GET['newLastName'])) {
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
    if (!isset($_SESSION['lastNameChange-Error'])) {
      $updateLastName = $pdo->prepare('UPDATE user set LastName="' . $_GET['newLastName'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateLastName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Instagram Validations und Änderungen
  if (isset($_GET['changeInstagramName'])) {
    unset($_SESSION['instagramNameChange-Error']);
    //???
    $stmntGetInstagram = $pdo->prepare("SELECT Insta FROM user");
    // $stmntGetInstagram->execute();

    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if (!preg_match("/^[a-zA-Z0-9._]+$/u", $_GET['newInstagramName'])) {
      echo "akdafuigidash";
      $_SESSION['instagramNameChange-Error']['value'] = $_GET['newInstagramName'];
      $_SESSION['instagramNameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    }

    // keine Fehler
    if (!isset($_SESSION['instagramNameChange-Error'])) {
      $updateInstagramName = $pdo->prepare('UPDATE user set Insta="' . $_GET['newInstagramName'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateInstagramName->execute();
    }
  }

  // ANCHOR Delete Instagram Name 
  if (isset($_GET['deleteInstagramName'])) {
    $deleteInstagramName = $pdo->prepare('UPDATE user set Insta = NULL where pk_user_id = ' . $_SESSION['userID']);
    $deleteInstagramName->execute();
  }

  // ANCHOR Twitter Validations und Änderungen
  if (isset($_GET['changeTwitterName'])) {
    unset($_SESSION['twitterNameChange-Error']);
    // ???
    $stmntGetTwitter = $pdo->prepare("SELECT Twitter FROM user");
    // $stmntGetTwitter->execute();

    // vergebener Twitter Username


    // neuer Username ist nicht vergeben hat aber Validations gefailed
    if (!preg_match("/^[A-Za-z0-9_]+$/u", $_GET['newTwitterName'])) {
      echo "akdafuigidash";
      $_SESSION['twitterNameChange-Error']['value'] = $_GET['newTwitterName'];
      $_SESSION['twitterNameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    }

    // keine Fehler
    if (!isset($_SESSION['twitterNameChange-Error'])) {
      $updateTwitterName = $pdo->prepare('UPDATE user set Twitter="' . $_GET['newTwitterName'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateTwitterName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Delete Twitter Name 
  if (isset($_GET['deleteTwitterName'])) {
    $deleteTwitterName = $pdo->prepare('UPDATE user set Twitter = NULL where pk_user_id = ' . $_SESSION['userID']);
    $deleteTwitterName->execute();
  }

  // ANCHOR Soundcloud Validations und Änderungen
  if (isset($_GET['changeScName'])) {
    unset($_SESSION['scNameChange-Error']);
    //???
    $stmntGetSc = $pdo->prepare("SELECT Soundcloud FROM user");
    // $stmntGetSc->execute();


    // neuer Username ist nicht vergeben hat aber Validations gefailed
    // FIXME Soundcloud validation?
    if (!preg_match("/^[A-Za-z0-9_.]+$/u", $_GET['newScName'])) {
      echo "akdafuigidash";
      $_SESSION['scNameChange-Error']['value'] = $_GET['newScName'];
      $_SESSION['scNameChange-Error']['id'] = -2;
      header('Location:/user/my/settings');
    }

    // keine Fehler
    if (!isset($_SESSION['scNameChange-Error'])) {
      $updateTwitterName = $pdo->prepare('UPDATE user set Soundcloud="' . $_GET['newScName'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateTwitterName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Delete Soundcloud Name 
  if (isset($_GET['deleteScName'])) {
    $deleteScName = $pdo->prepare('UPDATE user set Soundcloud = NULL where pk_user_id = ' . $_SESSION['userID']);
    $deleteScName->execute();
  }

  // ANCHOR Bio Validations und Änderungen
  if (isset($_GET['changeBioName'])) {
    unset($_SESSION['bioNameChange-Error']);
    //???
    $stmntGetBio = $pdo->prepare("SELECT Bio FROM user");
    // $stmntGetBio->execute();

    // keine Fehler
    if (!isset($_SESSION['bioNameChange-Error'])) {
      $updateBioName = $pdo->prepare('UPDATE user set Bio="' . $_GET['newBioName'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateBioName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Delete Bio  
  if (isset($_GET['deleteBioName'])) {
    $deleteBioName = $pdo->prepare('UPDATE user set Bio = NULL where pk_user_id = ' . $_SESSION['userID']);
    $deleteBioName->execute();
  }

  // ANCHOR Change Youtube Name 
  if (isset($_GET['changeYtName'])) {
    unset($_SESSION['ytNameChange-Error']);
    //???
    $stmntGetYt = $pdo->prepare("SELECT Youtube FROM user");
    // $stmntGetYt->execute();

    // keine Fehler
    if (!isset($_SESSION['ytNameChange-Error'])) {
      $updateYtName = $pdo->prepare('UPDATE user set Youtube="' . $_GET['newYtName'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateYtName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Delete Youtube  
  if (isset($_GET['deleteYtName'])) {
    $deleteYtName = $pdo->prepare('UPDATE user set YouTube = NULL where pk_user_id = ' . $_SESSION['userID']);
    $deleteYtName->execute();
  }

  // ANCHOR Change Location  
  if (isset($_GET['changeLocationName'])) {
    unset($_SESSION['locationNameChange-Error']);
    //???
    $stmntGetLocation = $pdo->prepare("SELECT Location FROM user");
    // $stmntGetLocation->execute();

    // keine Fehler
    if (!isset($_SESSION['locationNameChange-Error'])) {
      $updateLocationName = $pdo->prepare('UPDATE user set Location="' . $_GET['newLocationName'] . '" where pk_user_id = ' . $_SESSION['userID']);
      $updateLocationName->execute();
      header('Location:/user/my/settings');
    }
  }

  // ANCHOR Delete Location  
  if (isset($_GET['deleteLocationName'])) {
    $deleteLocationName = $pdo->prepare('UPDATE user set Location = NULL where pk_user_id = ' . $_SESSION['userID']);
    $deleteLocationName->execute();
  }

  // ANCHOR Delete Account 
  if (isset($_GET['deleteAccountConfirm'])) {
    $stmtDelUser = $pdo->prepare("INSERT INTO archivefiles SELECT * FROM files WHERE fk_user_id = :id; 
                                  DELETE FROM files WHERE fk_user_id = :id;
                                  INSERT INTO archiveuser SELECT * FROM user WHERE pk_user_id = :id; 
                                  DELETE FROM user WHERE pk_user_id = :id ");
    // define the in-parameters
    $stmtDelUser->bindParam('id', $_SESSION['userID'], PDO::PARAM_INT);
    $stmtDelUser->execute();

    session_destroy();
    header('Location:/home');
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
      i {
        float: left;
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
    // var_dump($_SESSION);
    // ANCHOR: PHP Zeugs
    //show login/register button if guest
    if (!isset($_SESSION['userID'])) {
      echo 'Nicht angemeldet';
    }
    //show username and id if logged in
    elseif ($_SESSION['userID'] > 0) {
      $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = " . $_SESSION['userID']);
      $stmntGetUserInfos->execute();
      $oldPassword = $pdo->prepare('SELECT Passwort from User where pk_user_id = ' . $_SESSION['userID']);
      // $oldPassword->execute();
      foreach ($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $_SESSION['userName'] = $row['Username'];
        $_SESSION['email'] = $row['Email'];
        $_SESSION['firstName'] = $row['FirstName'];
        $_SESSION['lastName'] = $row['LastName'];
        $_SESSION['instagram'] = $row['Insta'];
        $_SESSION['twitter'] = $row['Twitter'];
        $_SESSION['soundcloud'] = $row['Soundcloud'];
        $_SESSION['bio'] = $row['Bio'];
        $_SESSION['youtube'] = $row['YouTube'];
        $_SESSION['location'] = $row['Location'];
      }

      echo '<hr>';
      echo '<div class="profileForm"><i class="fa fa-user"> FirstName: ' . $_SESSION['firstName'] . '</i></div>';
      echo '<hr>';
      echo '<div class="profileForm"><i class="fa fa-user"> LastName: ' . $_SESSION['lastName'] . '</i></div>';
      echo '<hr>';
      echo '<div class="profileForm"><i class="fa fa-user">' . $_SESSION['userName'] . '</i></div>';
      echo '<br>';
      echo '<div class="profileForm"> Bio: ' . $_SESSION['bio']  . '</div>';
      echo '<hr>';
      echo (isset($_SESSION['instagram']) ? '<div class="profileForm"><a href="https://www.instagram.com/' . $_SESSION['instagram'] . '" target="_blank"><i class="fa fa-instagram">' . $_SESSION['instagram'] . '</i></a></div><br>' : '');
      echo (isset($_SESSION['twitter']) ? '<div class="profileForm"><a href="https://www.twitter.com/' . $_SESSION['twitter'] . '" target="_blank"><i class="fa fa-twitter">' . $_SESSION['twitter'] . '</i></a></div><br>' : '');
      echo (isset($_SESSION['soundcloud']) ? '<div class="profileForm"><a href="https://soundcloud.com/' . $_SESSION['soundcloud'] . '" target="_blank"><i class="fa fa-soundcloud">' . $_SESSION['soundcloud'] . '</i></a></div><br>' : '');
      echo (isset($_SESSION['email']) ? '<div class="profileForm"><i class="fa fa-envelope">' . $_SESSION['email'] . '</i></div><br>' : '');
      echo (isset($_SESSION['youtube']) ? '<div class="profileForm"><a href="https://www.youtube.com/channel/' . $_SESSION['youtube'] . '" target="_blank"><i class="fa fa-youtube">' . $_SESSION['youtube'] . '</i></a></div><br>' : '');
      echo (isset($_SESSION['location']) ? '<div class="profileForm"><i class="fa fa-map-marker">' . $_SESSION['location'] . '</i></div><br>' : '');
      echo '<hr>';
      echo '<hr>';

      // INSTAGRAM 

    }
    ?>


    <a href="/user/my"><i class="fa fa-arrow-circle-left fa-5x"></i></a>


    <!-- Username Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container" id="usernameForm">
      <input type="text" placeholder="Enter new Username" name="newUsername" id="change-username" value="<?php echo $_SESSION['userName'] ?>">
      <input type="submit" name="changeUsername" id="changeUsername" value="Change" />
      <!--index.php?newUsername=peter&changeUsername=Change-->
    </form>

    <!-- Email Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter new Email" name="newEmail" id="change-email" value="<?php echo $_SESSION['email'] ?>">
      <input type="submit" name="changeEmail" id="changeEmail" value="Change" />
      <!--index.php?newUsername=peter&changeUsername=Change-->
    </form>

    <!-- Password Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <div class="box">
      <input type="password" placeholder="Enter Password" name="newPassword" id="change-password" maxlength="30" required>
      <input type="password" placeholder="Repeat Password" name="newPasswordRepeat" id="change-password-repeat" maxlength="30" required>
      <input type="submit" name="changePassword" id="changePassword" value="Change" />
    </form>


    <!-- First Name Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter New First Name" name="newFirstName" id="change-firstName" value="<?php echo $_SESSION['firstName'] ?>">
      <input type="submit" name="changeFirstName" id="changeFirstName" value="Change" />
    </form>

    <!-- Last Name Change -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter New Last Name" name="newLastName" id="change-lastName" value="<?php echo $_SESSION['lastName'] ?>">
      <input type="submit" name="changeLastName" id="changeLastName" value="Change" />
    </form>

    <!-- Instagram Change / Instagram Connect -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Instagram Name" name="newInstagramName" id="change-instagramName" value="<?php echo $_SESSION['instagram'] ?>">
      <input type="submit" name="changeInstagramName" id="changeInstagramName" value="Change" />
      <input type="submit" name="deleteInstagramName" id="deleteInstagramName" value="Delete" />
    </form>

    <!-- Twitter Change / Twitter Connect -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Twitter Name" name="newTwitterName" id="change-twitterName" value="<?php echo $_SESSION['twitter'] ?>">
      <input type="submit" name="changeTwitterName" id="changeTwitterName" value="Change" />
      <input type="submit" name="deleteTwitterName" id="deleteTwitterName" value="Delete" />

    </form>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Sc Name" name="newScName" id="change-scName" value="<?php echo $_SESSION['soundcloud'] ?>">
      <input type="submit" name="changeScName" id="changeScName" value="Change" />
      <input type="submit" name="deleteScName" id="deleteScName" value="Delete" />
    </form>

    <!-- FIXME in Textarea wird die aktuelle Bio nicht angezeigt -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <textarea placeholder="Enter Bio" rows="4" cols="50" name="newBioName" id="change-bioName" value="<?php echo $_SESSION['bio'] ?>" maxlength="200"> <?php echo $_SESSION['bio'] ?> </textarea>
      <input type="submit" name="changeBioName" id="changeBioName" value="Change" />
      <input type="submit" name="deleteBioName" id="deleteBioName" value="Delete" />
    </form>

    <!-- Youtube Change / Youtube Connect -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Yt Name" name="newYtName" id="change-ytName" value="<?php echo $_SESSION['youtube'] ?>">
      <input type="submit" name="changeYtName" id="changeYtName" value="Change" />
      <input type="submit" name="deleteYtName" id="deleteYtName" value="Delete" />
    </form>

    <!-- Location Change / Location Connect -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="text" placeholder="Enter Location Name" name="newLocationName" id="change-LocationName" value="<?php echo $_SESSION['location'] ?>">
      <input type="submit" name="changeLocationName" id="changeLocationName" value="Change" />
      <input type="submit" name="deleteLocationName" id="deleteLocationName" value="Delete" />
    </form>

    <hr>
    <h3>Delete Account</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="button" name="deleteAccount" id="deleteAccount" value="Delete" onclick="openDeleteAccount()" />
    </form>
    <div id="deleteAccountForm">
      <div class="blocker" onclick="closeDeleteAccount()"></div>
      <div class="form-popup">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
          <h1>Are you sure you want to delete your account?</h1>
          <div>
            <button type="submit" class="loginButton" name="deleteAccountConfirm" id="deleteAccountConfirm"> Delete Account </button>
            <button type="button" class="cancelButton" onclick="closeDeleteAccount()"> Cancel </button>
          </div>
        </form>
      </div>
    </div>
    <br>
    <hr>
    <br>

    <script src="../../settings.js"></script>

  <?php
  $pdo = null;
} catch (PDOException $e) {
  //catch potentual error
  print "Error!: " . $e->getMessage() . "<br>";
  die();
}
  ?>