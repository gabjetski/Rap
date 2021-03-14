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
  </head>

  <body>
  <h2>Rap Plattform</h2>

  <?php 
    if (isset($_GET['reset'])) {
        session_destroy();
        header('Location:main.php');
    }
    var_dump($_SESSION);
    if (isset($_GET['registerSubmit'])) {

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
            header('Location:main.php');
        }else{
            $_SESSION['userID'] = $id;
            unset($_SESSION['registerError']);
            unset($_SESSION['loginError']);
            header('Location:main.php');
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
            header('Location:main.php');
        }else{
            $_SESSION['userID'] = $id;
            unset($_SESSION['loginError']);
            unset($_SESSION['registerError']);
            header('Location:main.php');
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

  
  <div id="loginForm">
    <div id="blocker1" onclick="closeLogin()"></div>
    <div class="form-popup">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
        <h1>Login</h1>
        <div>
          <label for="username"><b>Email/Username</b></label>
          <input type="text" placeholder="Enter Email or Username" name="email" required>

          <label for="login-psw"><b>Password</b></label>
          <input type="password" placeholder="Enter Password" name="login-psw" id="login-psw" required>

          <button type="submit" class="loginButton">Login</button>
            <button type="submit" class="signupButton" onclick="openRegister()">You don't have an account yet? Sign Up </button>
          <button type="button" class="cancelButton" onclick="closeLogin()">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  
  <div id="registerForm">
    <div id="blocker2" onclick="closeRegister()"></div>
    <div class="form-popup">
      <form action="index.html">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <fieldset>
            <label for="firstName"><b>Your First Name</b></label>
            <input type="text" placeholder="Enter First Name" name="firstName" required>

            <label for="lastName"><b>Your Last Name</b></label>
            <input type="text" placeholder="Enter Last Name" name="lastName" required>

            <label for="username"><b>Your Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="email"><b>Your Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>

            <button type="submit" class="newAccountButton" onclick="validatePassword()">Sign Up</button>
            <button type="submit" class="signupButton" onclick="openLogin()">Do you have an account already? Sign In here</button>
            <button type="button" class="cancelButton" onclick="closeRegister()">Cancel</button>
        </fieldset>
      </form>
    </div>
  </div>

  <script>
    const login = document.getElementById("loginForm");
    const register = document.getElementById("registerForm");

    function openLogin() {
      login.style.display = "block";
      register.style.display = "none";
    }

    function closeLogin() {
      login.style.display = "none";
    }

    function openRegister() {
      register.style.display = "block";
      login.style.display = "none";
    }

    function closeRegister() {
      register.style.display = "none";
    }

    let password = document.getElementById("psw");
    let confirm_password = document.getElementById("psw-repeat");

    function validatePassword(){
      if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }

  </script>
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