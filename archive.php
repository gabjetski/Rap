<!--<?php /* 
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
  <h2>Anmelde Form</h2>
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
        
        // 调用存储过程
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
            header('Location:main.php');
        }
    }
    if (!isset($_SESSION['userID'])) {
        
?>
  <button class="register-button" onclick="openForm()">Login</button>

  <div class="form-popup" id="myForm">
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="get" class="form-container">
      <h1 class="logininhalt">Register</h1>
      <p class="fillin">Please fill in this form to create an account.</p>
      <div class="textinhalt">

        <label for="firstName"><b>Your First Name</b></label>
        <input type="text" placeholder="Enter First" name="firstName" required>

        <label for="lastName"><b>Your Last Name</b></label>
        <input type="text" placeholder="Enter Last" name="lastName" required>

        <label for="username"><b>Your Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>

        <label for="email"><b>Your Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>

        <button type="submit" class="newAccbtn" name="registerSubmit" value="Register">Registrieren</button>
        <button type="button" class="cancelbtn" onclick="closeForm()">Abbrechen</button>


      </div>
    </form>
  </div>

  <?php 
  }

?>
    <script>
        function openForm() {
        document.getElementById("myForm").style.display = "block";
        }

        function closeForm() {
        document.getElementById("myForm").style.display = "none";
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
    }    */ ?>-->