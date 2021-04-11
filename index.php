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
  if (isset($_SESSION['registerError']['id']) || isset($_SESSION['loginError']['id'])){
    require "php/loginError.php";
  }
  if (isset($_SESSION['uploadError'])) {
    require "php/uploadError.php";
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
    if (isset($_GET['quickLog'])) {
      session_destroy();
      session_start();
      $_SESSION['userID'] = '4';
      header('Location:index.php');
  }
    if (isset($_GET['head'])) {
      //session_destroy();
      header('Location:index.php');
    }
    //Go to form without JS Validations to test Serverside Validations
    if (isset($_GET['withoutValidations'])) {
      session_destroy();
      header('Location:without_validations/index.php');
    }
    //if register Button is pressed
    if (isset($_GET['registerSubmit'])) {
      require "php/register.php";
    }
    //if login button is pressed
    elseif (isset($_GET['loginSubmit'])) {
      require "php/login.php";
    }
    // FIXME edge :(((
    if (isset($_POST['f4pUpload-submit'])) {
      require "php/f4pUpload.php";
    }
    if (isset($_POST['taggedUpload-submit'])) {
      require "php/taggedUpload.php";
    }
    if (isset($_GET['downloaded_file'])) {
      require "php/download.php";
    }
    var_dump($_SESSION);
    require "php/blacklist.php";
    if(isset($_SESSION['downloadSuccess'])){
      // require "php/downloadSuccess.php";
    }elseif(isset($_SESSION['downloadError'])){
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
    //echo "<br><br>";
    //var_dump($_SESSION['tags']);

    // Upload Icon für Testzwecke
?>
  <!-- SECTION PopUps -->
  <!-- Login Form, das Formular zum Anmelden mit Username bzw. E-Mail und dem Passwort (nur für bereits registrierte User) -->
  <!-- ANCHOR: Login Form  -->
  <!-- Login Form-->
  <div id="loginForm">
    <div class="blocker" onclick="closeLogin()"></div>
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
    <div id="blocker2" class="blocker" onclick="closeRegister()"></div>
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
  <!-- Hinweis das man sich anmelden muss 
  FIXME von uploadLogin wenn man angemeldet ist wieder zurück zu upload form... vllt eintrag in session speichern den ich abfrage-->
  <div id="uploadLoginForm">
      <div class="blocker" onclick="closeUploadLogin();"></div>
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
    <div class="blocker" onclick="closeUpload();"></div>
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
    <div class="blocker" onclick="closeF4P();"></div>
      <form id="f4pForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-popup" enctype="multipart/form-data">
        <h1>F4P Upload</h1>
        <div>
          <!-- FreeForProfit Upload - Auswahl Beat -->
          <label for="f4pUpload-type-beat"><b>Beat</b></label>
          <input type="radio" id="f4pUpload-type-beat" name="f4pUpload-type" value="beat" onkeypress="return noenter();" required checked>
          <!-- FreeForProfit Upload - Auswahl Sample -->
          <label for="f4pUpload-type-sample"><b>Sample</b></label>
          <input type="radio" id="f4pUpload-type-sample" name="f4pUpload-type" value="sample" onkeypress="return noenter();" required>
          <!-- FreeForProfit  Upload - BPM -->
          <label for="f4pUpload-bpm"><b>BPM*</b></label>
          <input type="text" id="f4pUpload-bpm" name="f4pUpload-bpm" pattern="^\d{2,3}$" maxlength="3" value="123" onkeypress="return noenter();" required>
          <!-- FreeForProfit Upload - Key ---- SQL hats nd so mit case sensitivity, maybe value C bei C Major-->
          <label for="f4pUpload-key"><b>Key</b></label>
          <select name="f4pUpload-key" id="f4pUpload-key">
            <option value="0" disabled>Select a key</option>
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
          <label for="f4pUpload-title"><b>Title*</b></label>
          <input type="text" id="f4pUpload-title" name="f4pUpload-title" required maxlength="60" onkeypress="return noenter();" value="Hallo">
          <!-- Blacklist, checked Banned Words-->
          <!-- <button type="button" onclick="checkBanWords();"> Blacklist Check </button> -->
          <p>Maximum 200 Characters allowed</p>
          <!-- FreeForProfit - Notizen -->
          <label for="f4pUpload-notes"><b>Notes</b></label>
          <textarea id="f4pUpload-notes" rows="4" cols="50" maxlength="200" name="f4pUpload-desc"></textarea>
          <div id="f4pCountNotes">Characters left: 200</div>
          <!-- FreeForProfit - Tags -->
          <label for="f4pUpload-tags"><b>Tags (5)</b></label>
          <input type="text" id="f4pUpload-tags" onkeypress="return noenter();" maxlength="30">
          <!-- Hidden Input, der die Values vom F4P Tags Array nimmt -->
          <input type="hidden" id="f4pUpload-tags-hidden" name="f4pUpload-tags" value='' />
          <!-- Tags Output -->
          <div id="f4pOutput"></div>
          <div id="f4pCountTags">Characters left: 30</div>
          <!-- FreeForProfit - File Upload -->
          <label for="f4pUpload-file"><b>File</b></label>
          <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>-->
          <input type="file" accept=".mp3" id="f4pUpload-file" name="f4pUpload-file" onkeypress="return noenter();" required/>
          <!-- Alle Einträge vom Forms Löschen -->
          <button type="button" onclick="clearF4PForm();"> Clear All </button>
          <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
          <button type="submit" class="continueButton" name="f4pUpload-submit" value="Finish" onclick="checkBanWords(); radioButtonsF4P();  bpmF4P(); titleF4P(); fileF4P();" class="continue" id="f4pUpload-submit">Finish</button>
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
    <div class="blocker" onclick="closeTagged();"></div>
      <form id="tForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-popup" enctype="multipart/form-data">
        <!-- <form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get"> -->
        <h1>Tagged Upload</h1>
        <div>
          <!-- Free Tag zum Downloaden, falls eigenes Tag vorhanden ist -->
          <a id="tagDownload" href="FreeTag/FreeTag.mp3" download><label for="download"><b><i class="fa fa-download"> Download A Free Tag</i></b></label></a>
          <label for="tagInfo"><b><button type="button" class="classBtn" onclick="closeTagged(); openTagInfo();">Learn More About Tags</button></b></label><br>
          <!-- Tagged Upload - Auswahl Beat -->
          <label for="taggedUpload-type-beat"><b>Beat</b></label>
          <input type="radio" id="taggedUpload-type-beat" name="taggedUpload-type" value="beat" checked>
          <!-- Tagged Upload - Auswahl Sample -->
          <label for="taggedUpload-type-sample"><b>Sample</b></label>
          <input type="radio" id="taggedUpload-type-sample" name="taggedUpload-type" value="sample">
          <!-- Tagged Upload - Auswahl Snippet-->
          <label for="taggedUpload-type-snippet"><b>Snippet</b></label>
          <input type="radio" id="taggedUpload-type-snippet" name="taggedUpload-type" value="snippet">
          <!-- Tagged Upload - BPM -->
          <label for="taggedUpload-bpm"><b>BPM</b></label>
          <input type="text" id="taggedUpload-bpm" name="taggedUpload-bpm" pattern="^\d{2,3}$" value="123">
          <!-- Tagged Upload - Key -->
          <label for="taggedUpload-key"><b>Key</b></label>
          <select name="taggedUpload-key" id="taggedUpload-key">
            <option value="0" disabled>Select a key</option>
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
          <!-- Tagged - Title des Uploads -->
          <label for="taggedUpload-title"><b>Title*</b></label>
          <input type="text" id="taggedUpload-title" name="taggedUpload-title" required maxlength="60" value="Hallo">
          <!-- Blacklist, checked Banned Words-->
          <!-- <button type="button" onclick="checkBanWords();"> Blacklist Check </button> -->
          <p>Maximum 200 Characters allowed</p>
          <!-- Tagged - Notizen -->
          <label for="taggedUpload-notes"><b>Notes</b></label>
          <textarea id="taggedUpload-notes" rows="4" cols="50" maxlength="200" name="taggedUpload-desc"></textarea>
          <div id="taggedCountNotes">Characters left: 200</div>
          <!-- Tagged - Tags -->
          <label for="taggedUpload-tags"><b>Tags (5)</b></label>
          <input type="text" id="taggedUpload-tags" onkeypress="return noenter();" maxlength="30">
          <!-- Hidden Input, der die Values vom F4P Tags Array nimmt -->
          <input type="hidden" id="taggedUpload-tags-hidden" name="taggedUpload-tags" value='' />
          <!-- Tags Output -->
          <div id="taggedOutput"></div>
          <div id="taggedCountTags">Characters left: 30</div>
          <!-- Tagged - File Upload -->
          <label for="taggedUpload-file"><b> File</b></label>
          <!--<input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>-->
          <input type="file" accept=".mp3" id="taggedUpload-file" name="taggedUpload-file" required />
          <!-- Alle Einträge vom Forms Löschen -->
          <button type="button" onclick="clearTaggedForm();"> Clear All </button>
          <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
          <button type="submit" class="continueButton" name="taggedUpload-submit" value="Continue" class="continue" id="taggedUpload-submit">Finish</button>
          <!-- onclick="openUploadSuccess();" -->
          <button type="button" class="continueButton" name="Back" value="Back" class="continue" onclick="closeTagged(); openUpload();">Back</button>
          <button type="button" class="cancelButton" onclick="closeTagged();">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <div id="tagInfo">
    <div class="blocker" onclick="closeTagInfo();"></div>
    <div class="form-popup">
      <div>
        <img src="\images\tag_screenshot.jpg" width="500px">
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
    <div class="blocker" onclick="closeUploadSuccess();"></div>
    <div class="form-popup">
      <div>
        <h1>Congratulation!</h1>
        <h2>Your upload completed succesfully</h2>
        <!-- <button type="button" class="continueButton" onclick="closeUploadSuccess();" name="viewTrack" value="viewTrack" class="continue">View Your rack here</button> !-->
      </div>
    </div>
  </div>


  <?php
  //var_dump($_SESSION);
    if (isset($_SESSION['uploadError'])) {
      echo "Name: ";
      var_dump($_SESSION['uploadError']['name']);
      echo "<br><hr>ID: ";
      var_dump($_SESSION['uploadError']['id']);
      echo "<br><hr>Type: ";
      var_dump($_SESSION['uploadError']['type']);
      echo "<br><hr>Post: ";
      var_dump($_SESSION['uploadError']['post']);
      echo "<br><hr>Files: ";
      var_dump($_SESSION['uploadError']['files']);
      echo "<br><hr>";
      echo "<br>";
      # code...
    }
    if (isset($_SESSION['registerError']['id'])) {
      var_dump($_SESSION['registerError']['id']);
      var_dump($_SESSION['registerError']['get']);
    }
    echo "<br><hr><br>";
    var_dump($_SESSION); ?>

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
      <input type="submit" value="quickLog" name="quickLog">
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
