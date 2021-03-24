<?php
    session_start();
    try {
      //database connection
        $pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
      //function to htmlspecialchar Arrays -> prevent injections
        function filter(&$value) {
          $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="script.js" defer></script>
  </head>
  
  <?php 
  //implement loginError.php if Procedure calls error (id < 0)
  if (isset($_SESSION['registerError']) || isset($_SESSION['loginError'])){

    //var_dump($_SESSION['errGet']);
    //echo '<br>';
    require "loginError.php";
    //echo '<br>';
    //var_dump($_SESSION);
  }
?>
  <body>
  <h2>Rap Plattform</h2>
  <?php
  //Reset or reload page
    if (isset($_GET['reset'])) {
        session_destroy();
        header('Location:index.php');
    }
    if (isset($_GET['head'])) {
      //session_destroy();
      header('Location:index.php');
    }
    //Go to form without JS Validations to test Serverside Validations
    if (isset($_GET['withoutValidations'])) {
      session_destroy();
      header('Location:index_ohneValidations.php');
    }
    //if register Button is pressed
    if (isset($_GET['registerSubmit'])) {
      //htmlspecialchar Get Array to store it safely
      array_walk_recursive($_GET, "filter");
      //check if password match Validations (Password-Validation already here and not in SQL cause the database only gets it hashed [shq])
      if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.\-ÄÜÖäüö]{7,30}$/',$_GET['psw'])) {
        //Prepare Procedure call
        $stmtCreateUser = $pdo->prepare("CALL createUser(?, ?, ?, ?, ?, ?, @id)");
        //define the in-parameters
        $stmtCreateUser->bindParam(1, $_GET['firstName'], PDO::PARAM_STR, 4000);
        $stmtCreateUser->bindParam(2, $_GET['lastName'], PDO::PARAM_STR, 4000);
        $stmtCreateUser->bindParam(3, $_GET['username'], PDO::PARAM_STR, 4000);
        $stmtCreateUser->bindParam(4, $_GET['email'], PDO::PARAM_STR, 5000);
        $stmtCreateUser->bindParam(5, sha1($_GET['psw']), PDO::PARAM_STR, 4000);
        $stmtCreateUser->bindParam(6, sha1($_GET['psw-repeat']), PDO::PARAM_STR, 4000);

        // 调用存储过程  !!Wichtig!!
        $stmtCreateUser->execute();

        //Select the out parameter into variable
        $sql = "SELECT @id AS id";
        $stmtGetId = $pdo->prepare($sql);
        $stmtGetId->execute();
        foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
            $id = $row['id'];
        }
        //check if id is negative which means an error is thrown
        if ($id < 0) {
            $_SESSION['registerError'] = $id;
            $_SESSION['errGet'] = $_GET;
            header('Location:index.php');
        }
        //else log in
        else{
            $_SESSION['userID'] = $id;
            unset($_SESSION['registerError']);
            unset($_SESSION['loginError']);
            unset($_SESSION['errGet']);
            header('Location:index.php');
        }
      }
      //if password doesnt match validations
      else{
        //also set error
        $_SESSION['registerError'] = '-10';
        $_SESSION['errGet'] = $_GET;
        header('Location:index.php');
      }
    }
    //if login button is pressed
    elseif (isset($_GET['loginSubmit'])) {
      //htmlspecialchar Get Array to store it safely
      array_walk_recursive($_GET, "filter");
      
      //Prepare Procedure call
      $stmtLoginUser = $pdo->prepare("CALL loginUser(?, ?, @id)");
      //define the in-parameters
      $stmtLoginUser->bindParam(1, $_GET['input'], PDO::PARAM_STR, 5000);
      $stmtLoginUser->bindParam(2, sha1($_GET['psw']), PDO::PARAM_STR, 4000);

      // 调用存储过程  !!Wichtig!!
      $stmtLoginUser->execute();

      //Select the out parameter into variable
      $sql = "SELECT @id AS id";
      $stmtGetId = $pdo->prepare($sql);
      $stmtGetId->execute();
      foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
          $id = $row['id'];
      }
      
      //check if id is negative which means an error is thrown
      if ($id < 0) {
          $_SESSION['loginError'] = $id;
          $_SESSION['errGet'] = $_GET;
          header('Location:index.php');
      }
      //else log in
      else{
          $_SESSION['userID'] = $id;
          unset($_SESSION['loginError']);
          unset($_SESSION['registerError']);
          header('Location:index.php');
      }
    }

    //show login/register button if guest
    if (!isset($_SESSION['userID'])) {
        echo '<button class="openForm" onclick="openLogin()">Log In/Register</button>';
    }
    //show username and id if logged in
    elseif($_SESSION['userID'] > 0){
        $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = ".$_SESSION['userID']);
        $stmntGetUserInfos->execute();
        foreach($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row){
            $_SESSION['userUName'] = $row['Username'];
        }
        echo '<div class="openForm">'.$_SESSION['userID'].' - '.$_SESSION['userUName'].'</div>';
    }

    // Upload Icon für Testzwecke
    echo '<i class="fa fa-upload fa-3x" onclick="openUpload()"></i>';
?>
  <!-- Login Form, das Formular zum Anmelden mit Username bzw. E-Mail und dem Passwort (nur für bereits registrierte User) -->
  <div id="loginForm">
    <div id="blocker1" onclick="closeLogin()"></div>
    <div class="form-popup">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
        <h1>Login</h1>
        <div>
          <!-- Username bzw. Email Adresse -->
          <label for="username"><b>Email/Username</b></label>
          <input type="text" placeholder="Enter Email or Username" name="input" id="login-input" required value="user">

          <!-- Password -->
          <label for="login-psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" id="login-psw" required value="passW1234567">

          <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen". -->
          <button type="submit" class="loginButton" name="loginSubmit" value="Login" id="loginButton">Login</button>
          <input type="button" class="signupButton" onclick="openRegister()" value="You don't have an account yet? Sign Up here!" />
          <button type="button" class="cancelButton" onclick="closeLogin()">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Register Form, das Formular, das es Besuchern der Website erlaubt, einen Account zu erstellen. -->
  <div id="registerForm">
    <div id="blocker2" onclick="closeRegister()"></div>
    <div class="form-popup">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <fieldset>
            <!-- First Name -->
            <label for="firstName"><b>Your First Name</b></label>
            <input type="text" placeholder="Enter First Name" name="firstName" id="register-firstName" required value="fName">
            <!-- Last Name -->
            <label for="lastName"><b>Your Last Name</b></label>
            <input type="text" placeholder="Enter Last Name" name="lastName" id="register-lastName" required value="lName">
            <!-- Username -->
            <label for="username"><b>Your Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" id="register-username" required value="user">
            <!-- Email -->
            <label for="email"><b>Your Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="register-email" pattern ="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Must contain a valid mail" required value="email@mail.com">
            <!-- Password -->
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password (Please use a secure one)" name="psw" id="register-psw" required value="passW1234567">
            <!-- Password Repeat -->
            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="register-psw-repeat" required value="passW1234567">
            <!-- TOS agreement -->
            <label for="tos"><b>I have read and agree to OUR NAMEs <a href="./agb.html" target="_blank">Terms of Service</a> & <a href="./privacyPolicy.html" target="_blank">Privacy Policy</a>.</b></label>
            <input type="checkbox" name="tos" id="register-tos" required checked></input>

            <!-- Buttons beim Register Form mit Funktionen "Sign Up", "zu Log In Form wechseln" und "Formular schließen". -->
            <button type="submit" class="newAccountButton" id="registerButton" onclick="validatePassword(); wrongUsername(); wrongPassword(); fName(); lName()" name="registerSubmit" value="Register">Sign Up</button>
            <button type="submit" class="signupButton" onclick="openLogin()">Do you have an account already? Log In here!</button>
            <button type="button" class="cancelButton" onclick="closeRegister()">Cancel</button>
        </fieldset>
      </form>
    </div>
  </div>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" class="form-container">
        <input type="submit" value="Reset" name="reset">
    </form>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" class="form-container">
        <input type="submit" value="Head" name="head">
    </form>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" class="form-container">
        <input type="submit" value="withoutValidations" name="withoutValidations">
    </form>
  </body>
</html>
<?php
        $pdo = null;
    } catch (PDOException $e) {
      //catch potentual error
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
?>

<!-- PopUp-Formulare für das Uploaden -->
    <div id="uploadForm">
    <div id="blocker1"></div>
    <div class="form-popup">
        <!-- <form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get"> -->
        <h1>Upload</h1>
        <div>
          <!-- Free For Profit Upload -->
          <label for="f4p"><b>Free For Profit</b></label>
          <input type="radio" id="f4p" name="category" value="FreeForProfit">
          <!-- Tagged Upload -->
          <label for="tagged"><b>Tagged</b></label>
          <input type="radio" id="tagged" name="category" value="Tagged">

          <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
          <button type="button" class="continueButton" name="Continue" value="Continue" id="continue">Weiter</button>
          <button type="button" class="cancelButton" onclick="closeUpload()">Cancel</button> 
        </div>
      </form>
    </div>
  </div> 
