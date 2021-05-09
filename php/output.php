<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Rap</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <script src="script.js" defer></script>
</head>

<body>
  <h2><a href="/home"> Rap Plattform</a></h2>
  <button onclick="history.go(-1);"><i class="fa fa-arrow-circle-left fa-5x"></i></button>
</body>

</html>
<?php

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
    echo "Usernames with " . $_GET['searchTerm'];
    echo "<br>";

    if ($stmntGetUsernames->rowCount() > 0) {
      foreach ($stmntGetUsernames->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo "Alle Usernames: <a href=\"http://{$_SERVER['SERVER_NAME']}/user/{$row['pk_user_id']}\">" . $row['Username'] . "</a><br />\n";
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
