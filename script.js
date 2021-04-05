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

    function radioButtonsF4P(){
        let beat =document.getElementById("f4pUpload-type-beat");
        let sample = document.getElementById("f4pUpload-type-sample");

        if(beat.checked === false && sample.checked === false){
            beat.setCustomValidity("Please select an option");
        } else {
            beat.setCustomValidity('');
        }
    }

    function bpmF4P(){
        let bpm = document.getElementById("f4pUpload-bpm");

        if(bpm.value === ""){
            bpm.setCustomValidity("Please enter your bpm");
        } else {
            bpm.setCustomValidity("");
        }
    }

    function titleF4P(){
        let title = document.getElementById("f4pUpload-title");
        if (title.value === "") {
            title.setCustomValidity("Please enter a title");
        } else {
            title.setCustomValidity("");
        }
    }

    function fileF4P(){
        let file = document.getElementById("f4pUpload-file");

        if(file.value === ""){
            file.setCustomValidity("Please upload a file");
        } else {
            file.setCustomValidity("");
        }
    }



/* Make Hashtag 2
function makeHashtag2(){
    let str = document.getElementById("f4pUpload-tags").value;
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
}; */

// "Funktion" für die Tags, um sie auszugeben und in einem Array zu speicher 
// TODO Focus ins Input Field nach Enter, Enter disablen als submit für ganzes Form, schön im HTML zeigen 
let tags = [];
let words = document.getElementById("f4pUpload-tags").value;
let i = 0;
let text = "";
let splitText = [];
document.addEventListener('keyup', function(e){
    if (e.code === 'Enter' && tags.length < 5) {
        let str = document.getElementById("f4pUpload-tags").value;
        let wordArray = str.split(' ').filter(char => char !== "");
        let result = "#";
        splitText = [];

        if(wordArray.length === 0){
            return false;
        }
            result = result + wordArray.map(word => {
            let capitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
            return capitalizedWord;
        }).join('');

        if(tags.length == 0){
            text = "";
        }

        tags.push(result);
        console.log(tags);
        text += "<h1 class='tagsListing' id='tag" + i + "'>" + tags[i] + "<button id='btn" + i + "' class='btn deleteTags' onclick='deleteF4PTags(this.id);' type='button'><i class='fa fa-close'></i></button> <button id='btnEdit" + i + "' class='btn editTags' type='button'><i class='fa fa-edit'></i></button>" + "</h1>";
        let textReplaced = text.replace(/<h1/g, ",<h1");
        splitText = textReplaced.split(",");
        console.log(splitText);
        document.getElementById("f4pUpload-tags").value = '';
        let div = document.getElementById('output').innerHTML = text;
        console.log(text);
        i++;
        if (tags.length >= 5){
                document.getElementById("f4pUpload-tags").disabled = true;
                document.getElementById('f4pUpload-tags').onkeyup = function () {
                    document.getElementById('countTags').innerHTML = "Characters left: " + 30;
                  };
            }
    }
  });

  function deleteF4PTags(btnId){
    btn = document.getElementById(btnId);
    btnNum = parseInt(btnId.substring(3), 10);
    tags.splice(btnNum, 1);
    console.log(btnId);
    console.log(btnNum);
    splitText[btnNum+1] = "";
    console.log(splitText);
    btn.parentNode.parentNode.removeChild(btn.parentNode);
    console.log(text);
    text = splitText.toString();
    text = text.replace(/,/g, '');
    console.log(text);
    console.log(tags);
  }

  
// Enter Funktion - Bei Drücken der Enter Taste wird das Formular nicht submittet
function noenter() {
    return !(window.event && window.event.keyCode == 13); 
}


// Funktion, um Max Länge von Notes nicht zu überschreiten
    // TODO nicht mit 200 sondern Variable
document.getElementById('f4pUpload-notes').onkeyup = function () {
    document.getElementById('countNotes').innerHTML = "Characters left: " + (200 - this.value.length);
  };

  document.getElementById('f4pUpload-tags').onkeyup = function () {
    document.getElementById('countTags').innerHTML = "Characters left: " + (30 - this.value.length);
  };


// Funktion um alle Einträge im Form zu löschen 
function clearF4PForm(){
    document.getElementById("f4pUpload-type-sample").checked = false;
    document.getElementById("f4pUpload-type-beat").checked = false;
    document.getElementById("f4pUpload-title").value = '';
    document.getElementById("f4pUpload-bpm").value = '';
    document.getElementById("f4pUpload-notes").value = '';
    document.getElementById("f4pUpload-tags").value = '';
    document.getElementById('countNotes').innerHTML = "Characters left: " + 200;
    document.getElementById('countTags').innerHTML = "Characters left: " + 30;
    document.getElementById("f4pUpload-tags").disabled= false;
    document.getElementById("f4pUpload-file").value = '';
    document.getElementById("f4pUpload-key").value='';
    tags = [];
    i = 0;
    document.getElementById('output').innerHTML = 'Tags: ';
    let tagsListing = document.getElementsByClassName('tagsListing');
    tagsListing.parentNode.removeChild(tagsListing);
}

function clearTaggedForm(){
    document.getElementById("taggedUpload-type-sample").checked = false;
    document.getElementById("taggedUpload-type-beat").checked = false;
    document.getElementById("taggedUpload-type-snippet").checked = false;
    document.getElementById("taggedUpload-title").value = '';
    document.getElementById("taggedUpload-bpm").value = '';
    document.getElementById("taggedUpload-notes").value = '';
    document.getElementById("taggedUpload-tags").value = '';
    document.getElementById("taggedUpload-tags").disable= false;
    document.getElementById("taggedUpload-file").value = '';
    document.getElementById("taggedUpload-key").value='';

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


setInputFilter(document.getElementById("f4pUpload-bpm"), function(value) {
    return /^-?\d*$/.test(value)  && (value === "" | parseInt(value) <= 999); });

    
setInputFilter(document.getElementById("taggedUpload-bpm"), function(value) {
    return /^-?\d*$/.test(value)  && (value === "" | parseInt(value) <= 999); });


function addDownloadCount(id) {
    const count = document.getElementById('downloads'+id);
    const oldNumber = count.innerHTML;
    count.innerHTML = parseInt(oldNumber,10) + 1;
    //alert(oldNumber);
}