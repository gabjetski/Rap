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
    let password = document.getElementById("psw");
    let confirm_password = document.getElementById("psw-repeat");

    if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
    } else {
    confirm_password.setCustomValidity('');
    }
}

//console.log(document.getElementById('regUsername').value.length);
// Funktionen der Username Validations
    // Funktion, wenn der Username zu kurz bzw. zu lang ist und ob Special Character verwendet wurden, die nicht erlaubt sind 
    function wrongUsernameLength(){
        let registerUsername = document.getElementById("regUsername");
        const pattern = new RegExp(/^[a-zA-Z0-9_.\-]+$/);

        console.log(pattern.test(registerUsername.value));

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