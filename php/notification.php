<div id="notisForm">
    <div class="blocker" onclick="closeNotisForm()"></div>
    <div class="form-popup">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
            <h1>Bitte Notifications </h1>
            <div>
                <!-- Username bzw. Email Adresse -->
                <label><b> Notifications Test Hallo </b></label>

                <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen". -->
                <button type="button" class="cancelButton" onclick="closeNotisForm()">Close</button>
            </div>
        </form>
    </div>
</div>
