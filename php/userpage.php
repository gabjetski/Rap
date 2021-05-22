<?php
session_start();
require_once 'autoload.php';
$_SESSION['header'] = "/user/{$_GET['userID']}";
try {
  //database connection
  $pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
  //function to htmlspecialchar Arrays -> prevent injections
  function filter(&$value)
  {
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

  if (!isset($_GET['userID'])) {
    header('Location:/home');
  }
  if (isset($_GET['reset'])) {
    session_destroy();
    header('Location:/user/' . $_GET['userID']);
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    header('Location:/user/' . $_GET['userID']);
  }
  if (isset($_GET['quickLog'])) {
    session_destroy();
    session_start();
    $_SESSION['userID'] = '4';
    header('Location:/user/' . $_GET['userID']);
  }
  if ($_SESSION['userID'] == $_GET['userID']) {
    header('Location:/user/my');
  }
?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Rap</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


  </head>

  <body>
    <h2><a href="/home"> Rap Plattform</a></h2>
    <?php 
     //show login/register button if guest
 if ($userPerm->permission($_SESSION['userID'], 3)) {
  require_once './logRegForms.php';
  echo '<button class="openForm" onclick="openLogin()">Log In/Register</button>';
  echo '<i class="fa fa-upload fa-3x" onclick="openUploadLogin()"></i>';
}
//show username and id if logged in
elseif (!$userPerm->permission($_SESSION['userID'], 3)) {
  $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = " . $_SESSION['userID']);
  $stmntGetUserInfos->execute();
  foreach ($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $_SESSION['userUName'] = $row['Username'];
  }
  echo '
<script src="../global.js" defer></script>
<div id="dropMenu">
  <div class="dropContainer">

    <div id="navToggle" class="nav-toggle">
      <a href="user/my"><div class="openForm">' . $_SESSION['userID'] . ' - ' . $_SESSION['userUName'] . '</div></a>
    </div>


    <div id="dropNav" class="dropNav">
      <ul id="list">
        <li class="dropList">
          <h3> <a href="user/my"> View Profile </a></h3>
        </li>
        <li class="dropList">
          <h3> <a href="user/my/settings"> Settings </a></h3>
        </li>
        <li class="dropList">
          <h3>
            Notifications
          </h3>
        </li>
        <li class="dropList">
          <h3>
            <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="get" class="form-container">
              <input type="submit" value="Log Out" name="logout">
            </form>
          </h3>
        </li>
      </ul>
    </div>

  </div>
</div>
';
}
    if ($userPerm->permission($_SESSION['userID'], 6)) {
      echo <<< setIcon
      <a href="/user/{$_GET['userID']}/settings"><i class="fa fa-gear fa-5x"></i></a>
      <hr>
      setIcon;
    }
    // ANCHOR: PHP Zeugs
    $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = " . $_GET['userID']);
    $stmntGetUserInfos->execute();
    foreach ($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row) {
      $_SESSION['userName'] = $row['Username'];
      $_SESSION['mail'] = $row['Email'];
      $_SESSION['insta'] = $row['Insta'];
      $_SESSION['twitter'] = $row['Twitter'];
      $_SESSION['soundcloud'] = $row['Soundcloud'];
      $_SESSION['bio'] = $row['Bio'];
      $date = strtotime($row['user_added']);
      $_SESSION['userSince'] = date("Y-m-d", $date); //FIXME DB new runnen
    }
    echo '<hr>';
    echo '<div class="profileForm"><i class="fa fa-user">' . $_SESSION['userName'] . '</i></div>';
    echo '<br>';
    echo (isset($_SESSION['userSince']) ? '<div class="profileForm">User since: ' . $_SESSION['userSince'] . '</div><br>' : '');
    echo '<div class="profileForm"> Bio: ' . $_SESSION['bio']  . '</div>';
    echo '<hr>';
    echo (isset($_SESSION['insta']) ? '<div class="profileForm"><a href="https://www.instagram.com/' . $_SESSION['insta'] . '" target="_blank"><i class="fa fa-instagram">' . $_SESSION['insta'] . '</i></a></div><br>' : '');
    echo (isset($_SESSION['twitter']) ? '<div class="profileForm"><a href="https://twitter.com/' . $_SESSION['twitter'] . '" target="_blank"><i class="fa fa-twitter">' . $_SESSION['twitter'] . '</i></a></div><br>' : '');
    echo (isset($_SESSION['Soundcloud']) ? '<div class="profileForm"><a href="https://soundcloud.com/' . $_SESSION['Soundcloud'] . '" target="_blank"><i class="fa fa-soundcloud">' . $_SESSION['Soundcloud'] . '</i></a></div><br>' : '');
    echo (isset($_SESSION['mail']) ? '<div class="profileForm"><i class="fa fa-envelope">' . $_SESSION['mail'] . '</i></div>' : '');

    echo (!isset($_SESSION['insta']) && !isset($_SESSION['twitter']) && !isset($_SESSION['soundcloud']) && !isset($_SESSION['mail']) ? 'This user has no contact details' : '');

    ?>
    <br>
    <hr>
    <br>

    <?php
    $feedPurp = 'user';
    require "./feed.php";
    ?>
  <?php
  $pdo = null;
} catch (PDOException $e) {
  //catch potentual error
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

  ?>