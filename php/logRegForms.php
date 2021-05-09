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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
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
                <input type="text" placeholder="Enter Email" name="email" id="register-email" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Must contain a valid mail" required value="email@mail.com">
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
</div>