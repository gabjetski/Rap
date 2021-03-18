<?php 
    session_start(); 
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Register Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
  </head>
  <!-- Onload Funktion (wird immer beim Aufruf der Seite geladen) -->
  <script type="text/javascript">
    function funk(){
      alert('k');
    }
    </script>
    
  <?php if (isset($_SESSION['registerError']) || isset($_SESSION['loginError'])){
    require "loginError.php";
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
        header('Location:index.php');
    }
    var_dump($_SESSION);
    if (isset($_GET['registerSubmit'])) {
      if ($_GET['psw'] == '^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.-]{7,30}$') {
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
              $_SESSION['registerError'] = $id;
              $_SESSION['errGet'] = $_GET;
              header('Location:index.php');
          }else{
              $_SESSION['userID'] = $id;
              unset($_SESSION['registerError']);
              unset($_SESSION['loginError']);
              header('Location:index.php');
            }
      }else{
        $_SESSION['registerError'] = '-10';   //------------------------------------- id -10 just temporarily
        $_SESSION['errGet'] = $_GET;
        header('Location:index.php');
      }
    }
    elseif (isset($_GET['loginSubmit'])) {

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
            $_SESSION['loginError'] = $id;
            $_SESSION['errGet'] = $_GET;
            header('Location:index.php');
        }else{
            $_SESSION['userID'] = $id;
            unset($_SESSION['loginError']);
            unset($_SESSION['registerError']);
            header('Location:index.php');
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
          <input type="text" placeholder="Enter Email or Username" name="input" id="login-input" required>

          <!-- Password -->
          <label for="login-psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="psw" id="login-psw" required>

          <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen". -->
          <button type="submit" class="loginButton" name="loginSubmit" value="Login" id="loginButton">Login</button>
          <button type="submit" class="signupButton" onclick="openRegister()">You don't have an account yet? Sign Up here!</button>
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
            <input type="text" placeholder="Enter First Name" name="firstName" id="register-firstName" pattern="^[a-zA-Z]+$" title="Use a real first name" required>
            <!-- Last Name -->
            <label for="lastName"><b>Your Last Name</b></label>
            <input type="text" placeholder="Enter Last Name" name="lastName" id="register-lastName" pattern="^[a-zA-Z]+$" title="Use a real last name" required>
            <!-- Username -->
            <label for="username"><b>Your Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" id="register-username" required>
            <!-- Email -->
            <label for="email"><b>Your Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="register-email" pattern ="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Must contain a valid mail" required>
            <!-- Password -->
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="register-psw" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.-]{7,30}$" required>
            <!-- Password Repeat -->
            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="register-psw-repeat" required>
            <!-- TOS agreement -->
            <label for="tos"><b>You must read and agree to our <a href="./agb.html" target="_blank">Terms of Service</a> in order to create an account.</b></label>
            <input type="checkbox" name="tos" id="register-tos" required></input>

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
  </body>
</html>
<?php 
        $pdo = null;
    } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
    }
?>