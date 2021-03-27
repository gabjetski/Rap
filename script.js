// Funktionen, um die Formulare beim Klicken des Login/Register/Upload Button zu öffnen
const login = document.getElementById("loginForm");
const register = document.getElementById("registerForm");
const upload = document.getElementById("uploadForm");
const f4p = document.getElementById("f4pForm");
const tag = document.getElementById("taggedForm");
const tagInfo = document.getElementById("tagInfo");



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

// Tag Info öffnen
function openTagInfo() {
  tagInfo.style.display = "block";
}

function closeTagInfo() {
  tagInfo.style.display = "none";
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

// Upload Formular öffnen
function openUpload(){
    upload.style.display = "block";
}

// Upload Formular schließen
function closeUpload(){
    upload.style.display = "none";
}

// Upload Formular mit weiteren Informationen zum Beat öffnen - F4P Version
function openF4P(){
    f4p.style.display = "block";
}

// Upload Formular mit weiteren Informationen zum Beat schließen - F4P Version
function closeF4P(){
    f4p.style.display = "none";
}

// Upload Formular mit weiteren Informationen zum Beat öffnen - Tagged Version
function openTagged(){
    tag.style.display = "block";
}

function closeTagged(){
    tag.style.display = "none";
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
        //const patternSpecial = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-z0-9!?{}@#$%^&*_.-]{7,30}/);
        const pattern = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!?{}@#$%^&*_.\-ÄÜÖäüö]{7,30}$/);
        const patternSpecial = new RegExp(/^[a-zA-Z0-9!?{}@#$%^&*_.\-ÄÜÖäüö]{7,30}$/);

        if(password.value.length < 7){
            password.setCustomValidity("Password has to be between 7 and 30 characters long");
        } else if (password.value.length > 30){
            password.setCustomValidity("Username has to be between 7 and 30 characters long");
        } else if(patternSpecial.test(password.value) === true && pattern.test(password.value) === false){
            password.setCustomValidity("Please make sure to use at least one upper and lowercase character and at least one digit");
        } else if(patternSpecial.test(password.value) === true && pattern.test(password.value) === true){
            password.setCustomValidity("");
        } else if(pattern.test(password.value) === false){
            password.setCustomValidity("We are sorry but we dont allow to use this special character");
        }
    }

    // Funktionen der Username Validations
    // Funktion, wenn der Username zu kurz bzw. zu lang ist und ob Special Character verwendet wurden, die nicht erlaubt sind
    function wrongUsername(){
        let registerUsername = document.getElementById("register-username");
        const pattern = new RegExp(/^[a-zA-Z0-9ÄÜÖäüö_.-]{3,20}$/);

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

    function fName(){
        let fName = document.getElementById("register-firstName");
        const pattern = new RegExp(/^[a-zA-ZÄÜÖäüö]{1,}$/);

        console.log(pattern.test(fName.value));

        if(fName.value.length < 1){
            fName.setCustomValidity("Your first name can't be empty");
        } else if(pattern.test(fName.value) === false){
            fName.setCustomValidity("Please use a real first name");
        } else {
            fName.setCustomValidity("");
        }
    }

    function lName(){
        let lName = document.getElementById("register-lastName");
        const pattern = new RegExp(/^[a-zA-ZÄÜÖäüö]{1,}$/);

        console.log(pattern.test(fName.value));

        if(lName.value.length < 1){
            lName.setCustomValidity("Your last name can't be empty");
        } else if(pattern.test(lName.value) === false){
            lName.setCustomValidity("Please use a real last name");
        } else {
            lName.setCustomValidity("");
        }
    }

    function restrictedUpload(file) {
     var Filesize = file.files[0].size;
     if (Filesize > 100 * 1024){ //MIB
         alert("Filesize exceeds 100MIB");
     }
    }

    //  Funktion für den zweiten Kategorien Check (zwischen Beat, Sample und Snippet
    // File Uploadd
    function dateiauswahl(evt) {
		// FileList-Objekt des input-Elements auslesen, auf dem
		// das change-Event ausgelöst wurde (event.target)
		var files = evt.target.files;
		// Deklarierung eines Array Objekts mit Namen "fragmente". Hier werden die Bausteine
		// für die erzeugte Listenausgabe gesammelt.
		var fragmente = [];
		// Zählschleife; bei jedem Durchgang den Namen, Typ und
		// die Dateigröße der ausgewählten Dateien zum Array hinzufügen
		for (var i = 0, f; f = files[i]; i++) {
			fragmente.push('<li><strong>', f.name, '</strong> (', f.type || 'n/a',
				') - ', f.size, ' bytes</li>');
		}
		// Alle Fragmente im fragmente Array aneinanderhängen, in eine unsortierte Liste einbetten
		// und das alles als HTML-Inhalt in das output-Elements mit id='dateiListe' einsetzen.
		document.getElementById('dateiListe')
			.innerHTML = '<ul>' + fragmente.join('') + '</ul>';
	}
	// UI-Events erst registrieren wenn das DOM bereit ist!
document.addEventListener("DOMContentLoaded", function () {
	// Falls neue Eingabe, neuer Aufruf der Auswahlfunktion
	document.getElementById('dateien')
		.addEventListener('change', dateiauswahl, false);
});


// Funktion, die nach jedem Space ein Hashtag in den Text gibt


function hashtags(e){
    document.addEventListener('keyup', event => {
        if (event.code === 'Space') {
          console.log("space")
        }
      })
}


function makeHashtag(){
    let str = document.getElementById("notes").value;
    let wordArray = str.split(' ').filter(char => char !== "");
    let result = "#";

    if(wordArray.length === 0){
        return false;
    }
    result = result + wordArray.map(word => {
        let capitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
        return capitalizedWord;
    }).join('');

    if(result.length > 100){
        return false;
    } else {
        console.log(result);
        return result;
    }
};
