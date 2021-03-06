<?php 
    session_start(); 
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');

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
    <script src="script_ohneValidations.js" defer></script>
  </head>
  <!-- Onload Funktion (wird immer beim Aufruf der Seite geladen) -->
  <script type="text/javascript">
    function funk(){
      alert('k');
    }
    </script>
    
  <?php if (isset($_SESSION['registerError']['id']) || isset($_SESSION['loginError']['id'])){
    
    var_dump($_SESSION['registerError']['get']);
    echo '<br>';
    require "loginError.php";
    echo '<br>';
    var_dump($_SESSION);
    /*echo '<script type="text/javascript">
          window.onload = openLogin;
          </script>';*/
  }
?>
  <body>
  <h2>Rap Plattform</h2>

  <?php 
    if (isset($_GET['reset'])) {
        session_destroy();
        header('Location:index_ohneValidations.php');
    }
    if (isset($_GET['head'])) {
        //session_destroy();
        header('Location:index_ohneValidations.php');
    }
    if (isset($_GET['main'])) {
      session_destroy();
      header('Location:index.php');
    }
    if (isset($_GET['registerSubmit'])) {
      array_walk_recursive($_GET, "filter");
      if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.\-ÄÜÖäüö]{7,30}$/',$_GET['psw'])) {
          $stmtCreateUser = $pdo->prepare("CALL createUser(?, ?, ?, ?, ?, ?, @id)");
          $stmtCreateUser->bindParam(1, $_GET['firstName'], PDO::PARAM_STR, 4000); 
          $stmtCreateUser->bindParam(2, $_GET['lastName'], PDO::PARAM_STR, 4000); 
          $stmtCreateUser->bindParam(3, $_GET['username'], PDO::PARAM_STR, 4000); 
          $stmtCreateUser->bindParam(4, $_GET['email'], PDO::PARAM_STR, 5000); 
          $stmtCreateUser->bindParam(5, sha1($_GET['psw']), PDO::PARAM_STR, 4000); 
          $stmtCreateUser->bindParam(6, sha1($_GET['psw-repeat']), PDO::PARAM_STR, 4000); 
          
          // 调用存储过程  !!Wichtig!! 
          $stmtCreateUser->execute();

          $sql = "SELECT @id AS id";
          $stmtGetId = $pdo->prepare($sql);
          $stmtGetId->execute();

          foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
              $id = $row['id'];
          }
          if ($id < 0) {
              $_SESSION['registerError']['id'] = $id;
              $_SESSION['registerError']['get'] = $_GET;
              header('Location:index_ohneValidations.php');
          }else{
              $_SESSION['userID'] = $id;
              unset($_SESSION['registerError']['id']);
              unset($_SESSION['loginError']['id']);
              unset($_SESSION['registerError']['get']);
              header('Location:index_ohneValidations.php');
            }
      }else{
        $_SESSION['registerError']['id'] = '-10';   //------------------------------------- id -10 just temporarily
        $_SESSION['registerError']['get'] = $_GET;
        header('Location:index_ohneValidations.php');
      }
    }
    elseif (isset($_GET['loginSubmit'])) {
      array_walk_recursive($_GET, "filter");

        $stmtLoginUser = $pdo->prepare("CALL loginUser(?, ?, @id)");
        $stmtLoginUser->bindParam(1, $_GET['input'], PDO::PARAM_STR, 5000); 
        $stmtLoginUser->bindParam(2, sha1($_GET['psw']), PDO::PARAM_STR, 4000); 
        
        // 调用存储过程  !!Wichtig!! 
        $stmtLoginUser->execute();

        $sql = "SELECT @id AS id";
        $stmtGetId = $pdo->prepare($sql);
        $stmtGetId->execute();

        foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
            $id = $row['id'];
        }
        if ($id < 0) {
            $_SESSION['loginError']['id'] = $id;
            $_SESSION['registerError']['get'] = $_GET;
            header('Location:index_ohneValidations.php');
        }else{
            $_SESSION['userID'] = $id;
            unset($_SESSION['loginError']['id']);
            unset($_SESSION['registerError']['id']);
            header('Location:index_ohneValidations.php');
        }
    }

    if (!isset($_SESSION['userID'])) {
        echo '<button class="openForm" onclick="openLogin()">Log In/Register</button>';
    }elseif($_SESSION['userID'] > 0){
        $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = ".$_SESSION['userID']);
        $stmntGetUserInfos->execute();
        foreach($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row){
            $_SESSION['userUName'] = $row['Username'];
        }
        echo '<div class="openForm">'.$_SESSION['userID'].' - '.$_SESSION['userUName'].'</div>';
    }
        
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
            <input type="text" placeholder="Enter Email" name="email" id="register-email" required value="email@mail.com">
            <!-- Password -->
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password (Please use a secure one)" name="psw" id="register-psw" required value="passW1234567">
            <!-- Password Repeat -->
            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="register-psw-repeat" required value="passW1234567">
            <!-- TOS agreement -->
            <label for="tos"><b>I have read and agree to OUR NAMEs <a href="./agb.html" target="_blank">Terms of Service</a>.</b></label>
            <input type="checkbox" name="tos" id="register-tos" required checked></input>

            <!-- Buttons beim Register Form mit Funktionen "Sign Up", "zu Log In Form wechseln" und "Formular schließen". -->
            <button type="submit" class="newAccountButton" id="registerButton" onclick="validatePassword(); wrongUsername(); wrongPassword()" name="registerSubmit" value="Register">Sign Up</button>
            <button type="submit" class="signupButton" onclick="openLogin()">Do you have an account already? Log In here!</button>
            <button type="button" class="cancelButton" onclick="closeRegister()">Cancel</button>
        </fieldset>
      </form>
    </div>
  </div>
  
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" class="form-container">
        <input type="submit" value="Reset" name="reset">
    </form>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" class="form-container">
        <input type="submit" value="Head" name="head">
    </form>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" class="form-container">
        <input type="submit" value="Main" name="main">
    </form>
  </body>
</html>
<?php 
        $pdo = null;
    } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
    }
?>