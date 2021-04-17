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
    <a href="/user/my/settings"><i class="fa fa-gear fa-5x"></i></a>
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
      foreach ($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $_SESSION['userName'] = $row['Username'];
        $_SESSION['mail'] = $row['Email'];
        $_SESSION['insta'] = $row['Insta'];
        $_SESSION['twitter'] = $row['Twitter'];
      }
      echo '<div class="profileForm"><i class="fa fa-user">' . $_SESSION['userName'] . '</i></div>';
      echo '<div class="profileForm"><i class="fa fa-envelope">' . $_SESSION['mail'] . '</i></div>';
      echo '<div class="profileForm"><a href="https://www.instagram.com/' . $_SESSION['insta'] . '" target="_blank"><i class="fa fa-instagram">' . $_SESSION['insta'] . '</i></a></div>';
      echo '<div class="profileForm"><a href="https://twitter.com/' . $_SESSION['twitter'] . '" target="_blank"><i class="fa fa-twitter">' . $_SESSION['twitter'] . '</i></a></div>';
    }
    ?>

    <!--<input type="text" placeholder="Enter new Username" name="newUsername" id="newUsername" required>
    <input type="button" class="changeUsername" onclick="changeUsername();" value="Change" />

      
        $updateUsername = $pdo->prepare('UPDATE user set Username="newUsername" where pk_user_id = '<?php //echo $_SESSION['userID']; 
                                                                                                    ?>');
          $updateUsername->execute();-->
    <br>
    <hr>
    <br>

    <?php
    $feedPurp = 'profile';
    require "./feed.php";
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-container">
      <input type="submit" value="quickLog" name="quickLog">
    </form>


  <?php
  $pdo = null;
} catch (PDOException $e) {
  //catch potentual error
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}

  ?>