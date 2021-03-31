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
    <title>Rap</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="script.js" defer></script>
  </head>

  <?php
  //implement loginError.php if Procedure calls error (id < 0)
  if (isset($_SESSION['registerError']) || isset($_SESSION['loginError'])){
    require "php/loginError.php";
  }
?>
  <body>
  <h2>Rap Plattform</h2>
  <?php
  // ANCHOR: PHP Zeugs
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
      require "php/register.php";
    }
    //if login button is pressed
    elseif (isset($_GET['loginSubmit'])) {
      require "php/login.php";
    }
    if (isset($_POST['f4pUpload-submit'])) {
      require "php/f4pUpload.php";
    }
    if (isset($_POST['taggedUpload-submit'])) {
      require "php/taggedUpload.php";
    }
    if (isset($_GET['downloaded_file'])) {
      require "php/download.php";
    }
    if(isset($_SESSION['downloadError'])){
      echo "<br>";
      echo "<br>";
      echo $_SESSION['downloadError'];
      echo "<br>";
      var_dump($_SESSION['downloadError_GET']);
      echo "<br>";
      echo "<br>";
    }
    if (isset($_SESSION['uploadSuccess'])) {
      echo "File - {$_SESSION['uploadSuccess']} was succesfully uploaded";
    }elseif (isset($_SESSION['uploadError'])) {
      echo "There was an Error while uploading the file {$_SESSION['uploadError']['name']}<br>
            Error-id: {$_SESSION['uploadError']['id']}";
    }
    //var_dump($_SESSION);
    //show login/register button if guest
    if (!isset($_SESSION['userID'])) {
        echo '<button class="openForm" onclick="openLogin()">Log In/Register</button>';
        echo '<i class="fa fa-upload fa-3x" onclick="openUploadLogin()"></i>';
    }
    //show username and id if logged in
    elseif($_SESSION['userID'] > 0){
        $stmntGetUserInfos = $pdo->prepare("SELECT * FROM user WHERE pk_user_id = ".$_SESSION['userID']);
        $stmntGetUserInfos->execute();
        foreach($stmntGetUserInfos->fetchAll(PDO::FETCH_ASSOC) as $row){
            $_SESSION['userUName'] = $row['Username'];
        }
        echo '<div class="openForm">'.$_SESSION['userID'].' - '.$_SESSION['userUName'].'</div>';
        echo '<i class="fa fa-upload fa-3x" onclick="openUpload()"></i>';
    }
    //var_dump($_SESSION);
    echo "<br><br>";
    var_dump($_SESSION['tags']);

    // Upload Icon für Testzwecke
?>
  <!-- SECTION PopUps -->
  <!-- Login Form, das Formular zum Anmelden mit Username bzw. E-Mail und dem Passwort (nur für bereits registrierte User) -->
  <!-- ANCHOR: Login Form  -->
  <!-- Login Form-->
  <div id="loginForm">
    <div class="blocker1" onclick="closeLogin()"></div>
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
  <!-- ANCHOR: Register Form  -->
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

<!-- PopUp-Formulare für das Uploaden -->
  <!-- Hinweis das man sich anmelden muss -->
  <div id="uploadLoginForm">
      <div class="blocker1" onclick="closeUploadLogin();"></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" class="form-popup">
          <!-- <form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get"> -->
          <h1>Upload</h1>
          <div>
            You have to log in before Uploading to *our name*!
            <!-- Free For Profit Upload -->
            <button type="button"  id="a" class="continueButton" onclick="openLogin(); closeUploadLogin();" name="F4P" value="f4p" class="continue">Log In</button>
            <button type="button"  id="b" class="continueButton" onclick="openRegister(); closeUploadLogin();" name="F4P" value="f4p" class="continue">Register</button>

            <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
            <button type="button" class="cancelButton" onclick="closeUploadLogin()">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Entscheidung zwischen Free4Profit und Tagged Upload -->
  <div id="uploadForm">
    <div class="blocker1" onclick="closeUpload();"></div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get" class="form-popup">
        <!-- <form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get"> -->
        <h1>Upload</h1>
        <div>
          <!-- Free For Profit Upload -->
          <button type="button" id="f4p" class="continueButton" onclick="openF4P(); closeUpload();" name="F4P" value="f4p" class="continue">Free For Profit</button>

          <!-- Tagged Upload -->
          <button type="button" id="taggedButton" class="continueButton" onclick="closeUpload(); openTagged();" name="Tagged" value="tagged" class="continue">Tagged</button>

          <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
          <button type="button" class="cancelButton" onclick="closeUpload()">Cancel</button>
        </div>
      </form>
    </div>
  </div>


   <!-- PopUp-Formulare für das Uploaden -->
   <!-- ANCHOR FreeForProfit Upload Formular-->
    <!-- FreeForProfit - Informationen über den Beat, wie z.B. BPM, Titel und weitere -->
  <div id="freeForProfitForm">
    <div class="blocker1" onclick="closeF4P();"></div>
      <form id="f4pForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-popup" enctype="multipart/form-data">
        <h1>F4P Upload</h1>
        <div>
          <!-- FreeForProfit Upload - Auswahl Beat -->
          <label for="fBeat"><b>Beat</b></label>
          <input type="radio" id="fBeat" name="f4pUpload-type" value="beat" required checked>
          <!-- FreeForProfit Upload - Auswahl Beat -->
          <label for="fSample"><b>Sample</b></label>
          <input type="radio" id="fSample" name="f4pUpload-type" value="sample" required>
          <!-- FreeForProfit  Upload - BPM -->
          <label for="fBpm"><b>BPM*</b></label>
          <input type="text" id="fBpm" name="f4pUpload-bpm" pattern="^\d{2,3}$" maxlength="3" value="123" required>
          <!-- FreeForProfit Upload - Key ---- SQL hats nd so mit case sensitivity, maybe value C bei C Major-->
          <label for="fKey"><b>Key</b></label>
          <select name="f4pUpload-key" id="fKey">
            <option value="" disabled>Select a key</option>
            <option value="C" selected>C Major</option>
            <option value="Cm">C minor</option>
            <option value="Db">Db Major</option>
            <option value="C#m">C# minor</option>
            <option value="D">D Major</option>
            <option value="Dm">D minor</option>
            <option value="Eb">Eb Major</option>
            <option value="D#m">D# minor</option>
            <option value="E">E Major</option>
            <option value="Em">E minor</option>
            <option value="F">F Major</option>
            <option value="fm">F minor</option>
            <option value="Gb">Gb Major</option>
            <option value="F#m">F# minor</option>
            <option value="G">G Major</option>
            <option value="Gm">G minor</option>
            <option value="Ab">Ab Major</option>
            <option value="G#m">G# minor</option>
            <option value="A">A Major</option>
            <option value="Am">A minor</option>
            <option value="Bb">Bb Major</option>
            <option value="A#m">A# minor</option>
            <option value="B">B Major</option>
            <option value="bm">B minor</option>
          </select>
          <!-- FreeForProfit - Title des Uploads -->
          <label for="fTitle"><b>Title*</b></label>
          <input type="text" id="fTitle" name="f4pUpload-title" required maxlength="60" value="Hallo">
          <button type="button" onclick="checkBanWords();"> Blacklist Check </button>
          <p>Maximum 200 Characters allowed</p>
          <!-- FreeForProfit - Notizen -->
          <label for="fNotes"><b>Notes</b></label>
          <textarea id="fNotes" rows="4" cols="50" maxlength="200" name="f4pUpload-desc"></textarea>
          <div id="count">Characters left: 200</div>
          <div id="msg"></div>
          <!-- FIXME Hashtag Funktion -->
          <p>Maximum 120 Characters allowed</p>
          <!-- FreeForProfit - Tags -->
          <label for="fTags"><b>Tags (5)</b></label>
          <textarea id="fTags" rows="4" cols="50" oninput="countWord();" onkeyup="makeHashtag();" name="f4pUpload-tags" value=""></textarea>
          <p> Word Count:
          <span id="show">0</span>
          </p>
          <button type="button" onclick="editTags();">Edit Tags </button>
          <!-- FreeForProfit - File Upload -->
          <label for="fFile"><b>File</b></label>
          <input type="file" accept=".mp3" id="fFile" name="f4pUpload-file" required/>
          <button type="button" onclick="clearF4PForm();"> Clear All </button>
          <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
          <button type="submit" class="continueButton" name="f4pUpload-submit" value="Finish" onclick="checkBanWords();" class="continue">Finish</button>
          <!-- onclick="openUploadSuccess();" hinzufügen beim submit button-->
          <button type="button" class="continueButton" name="Back" value="Back" class="continue" onclick="closeF4P(); openUpload();">Back</button>
          <button type="button" class="cancelButton" onclick="closeF4P();">Cancel</button>
        </div>
      </form>
    </div>
  </div>

   <!-- PopUp-Formulare für das Uploaden -->
   <!-- ANCHOR Tagged Upload Formular-->
    <!-- Informationen über den Beat, wie z.B. BPM, Titel und weitere -->
  <div id="taggedForm">
    <div class="blocker1" onclick="closeTagged();"></div>
      <form id="tForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-popup" enctype="multipart/form-data">
        <!-- <form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get"> -->
        <h1>Tagged Upload</h1>
        <div>

          <!-- Free Tag zum Downloaden, falls eigenes Tag vorhanden ist -->
          <a id="tagDownload" href="FreeTag/FreeTag.mp3" download><label for="download"><b<i class="fa fa-download"> Download A Free Tag</i></label></a>
          <label for="tagInfo"><b><button type="button" class="classBtn" onclick="closeTagged(); openTagInfo();">Learn More About Tags</button></b></label><br>
          <!-- Tagged Upload - Auswahl Beat -->
          <label for="tBeat"><b>Beat</b></label>
          <input type="radio" id="tBeat" name="taggedUpload-type" value="beat" checked>
          <!-- Tagged Upload - Auswahl Sample -->
          <label for="tSample"><b>Sample</b></label>
          <input type="radio" id="tSample" name="taggedUpload-type" value="sample">
          <!-- Tagged Upload - Auswahl Snippet-->
          <label for="tSnippet"><b>Snippet</b></label>
          <input type="radio" id="tSnippet" name="taggedUpload-type" value="snippet">
          <!-- Tagged Upload - BPM -->
          <label for="tBpm"><b>BPM</b></label>
          <input type="text" id="tBpm" name="taggedUpload-bpm" pattern="^\d{2,3}$" value="123">
          <!-- Tagged Upload - Key -->
          <label for="tKey"><b>Key</b></label>
          <select name="taggedUpload-key" id="tKey">
            <option value="C">C Major</option>
            <option value="Cm">C minor</option>
            <option value="Db" selected>Db Major</option>
            <option value="C#m">C# minor</option>
            <option value="D">D Major</option>
            <option value="Dm">D minor</option>
            <option value="Eb">Eb Major</option>
            <option value="D#m">D# minor</option>
            <option value="E">E Major</option>
            <option value="Em">E minor</option>
            <option value="F">F Major</option>
            <option value="Fm">F minor</option>
            <option value="Gb">Gb Major</option>
            <option value="F#m">F# minor</option>
            <option value="G">G Major</option>
            <option value="Gm">G minor</option>
            <option value="Ab">Ab Major</option>
            <option value="G#m">G# minor</option>
            <option value="A">A Major</option>
            <option value="Am">A minor</option>
            <option value="Bb">Bb Major</option>
            <option value="A#m">A# minor</option>
            <option value="B">B Major</option>
            <option value="Bm">B minor</option>
          </select>
          <!-- Title des Uploads -->
          <label for="tTitle"><b>Title*</b></label>
          <input type="text" id="tTitle" name="taggedUpload-title" required maxlength="60" value="Hallo">
          <p>Maximum 60 Characters allowed</p>
          <!-- Notizen -->
          <label for="tNotes"><b>Notes</b></label>
          <textarea id="tNotes" rows="4" cols="50" name="taggedUpload-desc"></textarea>
          <!-- FIXME Hashtag Funktion -->
          <p>Maximum 120 Characters allowed</p>
          <!-- Tags -->
          <label for="tTags"><b>Tags (5)</b></label>
          <textarea id="tTags" rows="4" cols="50" name="taggedUpload-tags"></textarea>
          <!-- File Upload -->
          <label for="tFile"><b> File</b></label>
          <input type="file" accept=".mp3" id="tFile" name="taggedUpload-file" required />
          <button type="button" onclick="clearTaggedForm();"> Clear All </button>
          <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
          <button type="submit" class="continueButton" name="taggedUpload-submit" value="Continue" class="continue">Finish</button>
          <!-- onclick="openUploadSuccess();" -->
          <button type="button" class="continueButton" name="Back" value="Back" class="continue" onclick="closeTagged(); openUpload();">Back</button>
          <button type="button" class="cancelButton" onclick="closeTagged();">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <div id="tagInfo">
    <div class="blocker1" onclick="closeTagInfo();"></div>
    <div class="form-popup">
      <div>
        <h1>Why should I use tags?</h1>
        <ul>
          <li>Tags help ensure your work doesn't get stolen</li>
          <li>If someone does steal your beat you can easily identify it</li>
          <li>Using your own tag helps build your brand</li>
        </ul>
        <button type="button" class="continueButton" name="Back" value="Back" class="continue" onclick="openTagged(); closeTagInfo();">Back</button>
      </div>
    </div>
  </div>

  <div id="uploadSuccess">
    <div class="blocker1" onclick="closeUploadSuccess();"></div>
    <div class="form-popup">
      <div>
        <h1>Congratulation!</h1>
        <h2>Your upload completed succesfully</h2>
        <button type="button" class="continueButton" onclick="closeUploadSuccess();" name="viewTrack" value="viewTrack" class="continue">View Your rack here</button>
      </div>
    </div>
  </div>


  <!-- !SECTION
  SECTION Body
  ANCHOR: Feed-->
  <div class="feed">
  <br><hr><hr>
  <?php
  if (!isset($_GET['page']) || $_GET['page'] == 'home') {
    require 'php/feed.php';
  }
  ?>
  </div>

  <!------------------always at bottom for testing--------------- -->
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
