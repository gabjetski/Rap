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
