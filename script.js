// Funktionen, um die Formulare beim Klicken des Login/Register Button zu öffnen
const login = document.getElementById("loginForm");
const register = document.getElementById("registerForm");

// Login Formular öffnen
function openLogin() {
    login.style.display = "block";
    register.style.display = "none";
}

// Login Formular schließen 
function closeLogin() {
    login.style.display = "none";
}

// Register Formular öffnen
function openRegister() {
    register.style.display = "block";
    login.style.display = "none";
}

// Register Formular schließen
function closeRegister() {
    register.style.display = "none";
}

function error(id, msg) {
    let oldCode = document.getElementById(id).innerHTML;
    let newcode = '<p class="error>'+msg+'</p>'+oldCode;
    document.getElementById(id).innerHTML = newcode;
}

// Funktion, um beim Registrieren zu checken, ob die Passwörter übereinstimmen
function validatePassword(){
    let password = document.getElementById("register-psw");
    let confirm_password = document.getElementById("register-psw-repeat");

    if(password.value === confirm_password.value) {
    confirm_password.setCustomValidity("");
    } else {
    confirm_password.setCustomValidity("Passwords Don't Match");
    }
}


// Funktionen der Password Validations 
    // Funktion, wenn das Passwort zu kurz bzw. zu lang ist und ob Special Character verwendet wurden, die nicht erlaubt sind
    function wrongPassword(){ 
        let password  = document.getElementById("register-psw");
        const patternSpecial = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-z0-9!?{}@#$%^&*_.-]{7,30}/);
        const pattern = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{7,30}$/)
        
        if(password.value.length < 7){
            password.setCustomValidity("Password has to be between 7 and 30 characters long");
        } else if (password.value.length > 30){
            password.setCustomValidity("Username has to be between 7 and 30 characters long");
        } else if (patternSpecial.test(password.value) === false){
            password.setCustomValidity("We are sorry but we dont allow to use this special character");
        } else if(pattern.test(password.value) === false){
            password.setCustomValidity("Please make sure to use at least one upper and lowercase character and at least one digit");
        } else {s
            password.setCustomValidity("");
        }
    } 

    // Funktionen der Username Validations
    // Funktion, wenn der Username zu kurz bzw. zu lang ist und ob Special Character verwendet wurden, die nicht erlaubt sind 
    function wrongUsername(){
        let registerUsername = document.getElementById("register-username");
        const pattern = new RegExp(/^[a-zA-Z0-9_.\-]+$/);

        if(registerUsername.value.length < 3){
            registerUsername.setCustomValidity("Username has to be between 3 and 20 characters long");
        } else if(registerUsername.value.length > 20){
            registerUsername.setCustomValidity("Username has to be between 3 and 20 characters long");
        } else if(pattern.test(registerUsername.value) === false) {
            registerUsername.setCustomValidity("Invalid characters, please make sure to only use _ . and -");
        } else {
            registerUsername.setCustomValidity("");
        }
    }