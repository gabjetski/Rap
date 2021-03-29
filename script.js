// Funktionen, um die Formulare beim Klicken des Login/Register/Upload Button zu öffnen
const login = document.getElementById("loginForm");
const register = document.getElementById("registerForm");
const upload = document.getElementById("uploadForm");
const uploadLogin = document.getElementById("uploadLoginForm");
const f4p = document.getElementById("freeForProfitForm");
const tag = document.getElementById("taggedForm");
const tagInfo = document.getElementById("tagInfo");
const uploadSuccess = document.getElementById("uploadSuccess");



// Login
    // Formular öffnen
function openLogin() {
    login.style.display = "block";
    register.style.display = "none";
}

    // Formular schließen
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

function openUploadSuccess() {
    uploadSuccess.style.display = "block";
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
// Upload Formular öffnen
function openUploadLogin(){
    uploadLogin.style.display = "block";
}

// Upload Formular schließen
function closeUploadLogin(){
    uploadLogin.style.display = "none";
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

function closeUploadSuccess() {
    uploadSuccess.style.display = "none";
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

// FIXME wenn man manchmal tags löscht, und dann ein neues reinschreibt, hört es bei 4 auf (disabled Textarea)
// TODO wenn ein Tag eine Max Länge von X hat, ein neues Tag machen (automatisch Space)
function makeHashtag(){
    let str = document.getElementById('fTags').value;
    str = str.replace(/[-!$%^&*()_+|~=`{}\[\]:";'<>?,.@#£\/]/g, '');
    let tagged = str.replace(/#/g, '').replace(/([^" "]+)/g, '#'+'$1');
    document.getElementById('fTags').value = tagged;
    let hashtags = str.match(/[#]/g);
}

let count;
function countWord() {
    let words = document.getElementById("fTags").value;
    count = 0;
    var split = words.split(' ');
    for (var i = 0; i < split.length; i++) {
        if (split[i] != "") {
            count += 1;
        }
    }
    document.addEventListener('keyup', event => {
        if (event.code === 'Space' && count == 5) { 
            document.getElementById("fTags").disabled = true;
        }
      });
    document.getElementById("show")
        .innerHTML = count;
}


// Funktion, um Max Länge von Notes nicht zu überschreiten
document.getElementById('fNotes').onkeyup = function () {
    document.getElementById('count').innerHTML = "Characters left: " + (200 - this.value.length);
  };

// FIXME Funktion, um zu erlauben, Tags zu editen 
function editTags(){
    
}

function notesLength(){
    let maxL = 60
    document.getElementById("fNotes").keyup(function(e){
        document.getElementById("count").text("Cha Left: " + (maxL - $(this).val().length));
    })
}
// Funktion um alle Einträge im Form zu löschen 
function clearF4PForm(){
    document.getElementById("fSample").checked = false;
    document.getElementById("fBeat").checked = false;
    document.getElementById("fTitle").value = '';
    document.getElementById("fBpm").value = '';
    document.getElementById("fNotes").value = '';
    document.getElementById("fTags").value = '';
    count = 0;
    document.getElementById("fTags").disabled= false;

    document.getElementById("fFile").value = '';
    document.getElementById("fKey").value='';
}

function clearTaggedForm(){
    document.getElementById("tSample").checked = false;
    document.getElementById("tBeat").checked = false;
    document.getElementById("tSnippet").checked = false;
    document.getElementById("tTitle").value = '';
    document.getElementById("tBpm").value = '';
    document.getElementById("tNotes").value = '';
    document.getElementById("tTags").value = '';
    document.getElementById("tTags").disable= false;
    document.getElementById("tFile").value = '';
    document.getElementById("tKey").value='';

}



// Funktion, um keine Buchstaben in BPM schreiben zu können
function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    });
  }


    setInputFilter(document.getElementById("fBpm"), function(value) {
        return /^-?\d*$/.test(value)  && (value === "" | parseInt(value) <= 240); });

        
    setInputFilter(document.getElementById("tBpm"), function(value) {
        return /^-?\d*$/.test(value)  && (value === "" | parseInt(value) <= 240); });