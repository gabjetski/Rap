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

  if (!isset($_GET['userID'])) {
    header('Location:/home');
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
    // ANCHOR: PHP Zeugs
    $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = " . $_GET['userID']);
    $stmntGetUserInfos->execute();
    foreach ($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row) {
    }
    
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