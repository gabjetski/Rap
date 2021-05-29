<!-- Login Form, das Formular zum Anmelden mit Username bzw. E-Mail und dem Passwort (nur für bereits registrierte User) -->
<!-- ANCHOR: Login Form  -->
<!-- Login Form-->
<div id="loginForm">
    <div class="blocker" onclick="closeLogin()"></div>
    <div class="form-popup">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <h1>Login</h1>
            <div>
                <!-- Username bzw. Email Adresse -->
                <label for="username"><b>Email/Username</b></label>
                <input type="text" placeholder="Enter Email or Username" name="input" id="login-input" required value="user">

                <!-- Password -->
                <label for="login-psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" id="login-psw" required value="passW1234567">
                <input type="checkbox" id="showLoginPw">show pw

                <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen". -->
                <button type="submit" class="loginButton" onclick="validateLoginForm();" name="loginSubmit" value="Login" id="loginButton">Login</button>
                <input type="button" class="signupButton" onclick="openRegister(); " value="You don't have an account yet? Sign Up here!" />
                <button type="button" class="cancelButton" onclick="closeLogin(); ">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Register Form, das Formular, das es Besuchern der Website erlaubt, einen Account zu erstellen. -->
<!-- ANCHOR: Register Form  -->
<div id="registerForm">
    <div id="blocker2" class="blocker" onclick="closeRegister()"></div>
    <div class="form-popup">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <fieldset>
                <!-- First Name -->
                <label for="firstName"><b>First Name</b></label>
                <input type="text" placeholder="Enter First Name" name="firstName" id="register-firstName" maxlength="50" value="Gab" required>
                <!-- Last Name -->
                <label for="lastName"><b>Last Name</b></label>
                <input type="text" placeholder="Enter Last Name" name="lastName" id="register-lastName" maxlength="50" value="Gab" required>
                <!-- Username -->
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" id="register-username" maxlength="20" value="user123" required>
                <!-- Email -->
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" id="register-email" value="gab@gmail.com" required>
                <!-- Password -->
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password (Please use a secure one)" name="psw" value="Hallo123" id="register-psw" required>
                <!-- Password Repeat -->
                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" id="register-psw-repeat" value="Hallo123" required>
                <input type="checkbox" id="showRegisterPw">show pw
                <br>
                <!-- TOS agreement -->
                <label for="tos"><b>I have read and agree to OUR NAMEs <a href="./agb.html" target="_blank">Terms of Service</a> & <a href="./privacyPolicy.html" target="_blank">Privacy Policy</a>.</b></label>
                <input type="checkbox" name="tos" id="register-tos" required checked></input>

                <!-- Buttons beim Register Form mit Funktionen "Sign Up", "zu Log In Form wechseln" und "Formular schließen". -->
                <button type="submit" class="newAccountButton" id="registerButton" onclick="validatePassword(); wrongUsername(); wrongPassword(); fName(); lName(); validateMail();" name="registerSubmit" value="Register">Sign Up</button>
                <button type="button" class="signupButton" onclick="openLogin()">Do you have an account already? Log In here!</button>
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-popup">
        <!-- <form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);
                            ?>" method="get"> -->
        <h1>Upload</h1>
        <div>
            You have to log in before Uploading to *our name*!
            <!-- Free For Profit Upload -->
            <button type="button" id="a" class="continueButton" onclick="openLogin(); closeUploadLogin();" name="F4P" value="f4p" class="continue">Log In</button>
            <button type="button" id="b" class="continueButton" onclick="openRegister(); closeUploadLogin();" name="F4P" value="f4p" class="continue">Register</button>

            <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
            <button type="button" class="cancelButton" onclick="closeUploadLogin()">Cancel</button>
        </div>
    </form>
</div>
<!-- FIXME Prolly den code in script.js? oder sonst den ganzen logregform related js code da rein
        auf jeden fall solts beinander sein -->
<script>
    showLogPw = document.getElementById("showLoginPw");
    showLogPw.addEventListener("click", function() {
        logPw = document.getElementById("login-psw");
        if (logPw.type === "password") {
            logPw.type = "text";
        } else {
            logPw.type = "password";
        }
    });

    showRegPw = document.getElementById("showRegisterPw");
    showRegPw.addEventListener("click", function() {
        regPw = document.getElementById("register-psw");
        regPwRep = document.getElementById("register-psw-repeat");
        if (regPw.type === "password") {
            regPw.type = "text";
            regPwRep.type = "text";
        } else {
            regPw.type = "password";
            regPwRep.type = "password";
        }
    });
</script>
</div>