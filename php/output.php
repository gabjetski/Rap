<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Rap</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <script src="../script.js" defer></script>
  <script src="../global.js" defer></script>
</head>

<body>
  <h2><a href="/home"> Rap Plattform</a></h2>
  <button onclick="history.go(-1);"><i class="fa fa-arrow-circle-left fa-5x"></i></button>
</body>

</html>
<?php
session_start();
require_once 'autoload.php';


//show login/register button if guest
if (Permissions::permission($_SESSION['userID'], 3)) {
  require_once './logRegForms.php';
  echo '<button class="openForm" onclick="openLogin()">Log In/Register</button>';
  echo '<i class="fa fa-upload fa-3x" onclick="openUploadLogin()"></i>';
}
//show username and id if logged in
elseif (!Permissions::permission($_SESSION['userID'], 3)) {
  $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = " . $_SESSION['userID']);
  $stmntGetUserInfos->execute();
  foreach ($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $_SESSION['userUName'] = $row['Username'];
  }
  echo '
<script src="global.js" defer></script>
<div id="dropMenu">
  <div class="dropContainer">

    <div id="navToggle" class="nav-toggle">
      <a href="../user/my"><div class="openForm">' . $_SESSION['userID'] . ' - ' . $_SESSION['userUName'] . '</div></a>
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
require 'searchbar.php';
try {
  //database connection
  $pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
  require_once "autoload.php";
  // $_SESSION['pdo'] = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
  //function to htmlspecialchar Arrays -> prevent injections
  function filter(&$value)
  {
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

  // ANCHOR User hat Search Button gedrückt
  if (isset($_GET['searchButton']) && !empty($_GET['searchTerm'])) {
    // ANCHOR Usernamen ausgeben 
    $keyword = $_GET['searchTerm'];
    echo "<br>";
    $stmntGetUsernames = $pdo->prepare("SELECT Username, pk_user_id FROM user where Username like :keyword");
    $keyword = "%" . $keyword . "%";
    $stmntGetUsernames->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    echo "<br>";
    $stmntGetUsernames->execute();
    echo "<br>";

    if ($stmntGetUsernames->rowCount() > 0) {
      foreach ($stmntGetUsernames->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo "Usernames with " . '"' .  $_GET['searchTerm'] . '"';
        echo "<br>";
        echo "<a href=\"http://{$_SERVER['SERVER_NAME']}/user/{$row['pk_user_id']}\">" . $row['Username'] . "</a><br />\n";
      }
    } else {
      echo "No Users found with " . '"' . $_GET['searchTerm'] . '"';
    }

    // ANCHOR Tracks ausgeben 
    // echo "<br>";
    // $stmntGetTracks = $pdo->prepare("SELECT Title FROM files where Title like :keyword");
    // $stmntGetTracks->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    // echo "<br>";
    // $stmntGetTracks->execute();
    // echo "Tracks in " . $_GET['searchTerm'];
    // echo "<br>";
    // foreach ($stmntGetTracks->fetchAll(PDO::FETCH_ASSOC) as $row) {
    //   echo "Alle Tracks : " . $row['Title'] . "</a><br />\n";
    // }

    // if ($stmntGetTracks->rowCount() > 0) {
    //   foreach ($stmntGetTracks->fetchAll(PDO::FETCH_ASSOC) as $row) {
    //     echo "Alle Tracks : " . $row['Title'] . "</a><br />\n";
    //   }
    // } else {
    //   echo "No Tracks found with " . '"' . $_GET['searchTerm'] . '"';
    // }
    echo "<br>";
    $feedPurp = 'search';
    require "./feed.php";

    // ANCHOR Tags ausgeben 

    $stmntGetTags = $pdo->prepare("SELECT Tag1, Tag2, Tag3, Tag4, Tag5, Title FROM files where Tag1 LIKE :keyword OR Tag2 LIKE :keyword OR Tag3 LIKE :keyword OR Tag4 LIKE :keyword OR Tag5 LIKE :keyword");
    $stmntGetTags->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    echo "<br>";
    $stmntGetTags->execute();
    if ($stmntGetTags->rowCount() > 0) {
      foreach ($stmntGetTags->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo "Tracks with Tag  : " . $row['Title'] . "</a><br />\n";
      }
    } else {
      echo "No Tags found with " . '"' . $_GET['searchTerm'] . '"';
    }


    // If keyword empty

    // Pfeil zurück Ideen für Output Seite




    // If keyword empty

    // Pfeil zurück Ideen für Output Seite


  } else {
    echo "";
  }
  $pdo = null;
} catch (PDOException $e) {
  //catch potentual error
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
