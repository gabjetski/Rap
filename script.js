// Funktionen, um die Formulare beim Klicken des Login/Register/Upload Button zu öffnen
const login = document.getElementById("loginForm");
const register = document.getElementById("registerForm");
const upload = document.getElementById("uploadForm");
const uploadLogin = document.getElementById("uploadLoginForm");
const f4p = document.getElementById("freeForProfitForm");
const tag = document.getElementById("taggedForm");
const tagInfo = document.getElementById("tagInfo");
const uploadSuccess = document.getElementById("uploadSuccess");


// ANCHOR !ALLE! Formulare, die mittels "PopUp" geöffnet und geschlossen werden können
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

// Tag Info des Tagged Uploads öffnen
function openTagInfo() {
  tagInfo.style.display = "block";
}

// Tag Info des Tagged Uploads schließen
function closeTagInfo() {
  tagInfo.style.display = "none";
}

// TODO Upload Success Nachricht noch ausgeben
function openUploadSuccess() {
    uploadSuccess.style.display = "block";
}

// TODO Upload Success Nachricht schließen lassen (sollte nach einer Zeit selbst verschwinden)
function closeUploadSuccess() {
    uploadSuccess.style.display = "none";
}

// Upload Formular öffnen, bei dem zwischen F4P und Tagged entschieden werden kann
function openUpload(){
    upload.style.display = "block";
}

// Upload Formular schließen, bei dem zwischen F4P und Tagged entschieden werden kann
function closeUpload(){
    upload.style.display = "none";
}

// Anmelde Formular öffnen, das erscheint, wenn man auf den Upload Button drückt aber nicht angemeldet ist
function openUploadLogin(){
    uploadLogin.style.display = "block";
}

// Anmelde Formular schließen, das erscheint, wenn man auf den Upload Button drückt aber nicht angemeldet ist
function closeUploadLogin(){
    uploadLogin.style.display = "none";
}

// F4P-Upload-Formular mit weiteren Informationen zum Beat öffnen
function openF4P(){
    f4p.style.display = "block";
}

// F4P-Upload-Formular mit weiteren Informationen zum Beat schließen
function closeF4P(){
    f4p.style.display = "none";
}

// Tagged-Upload-Formular mit weiteren Informationen zum Beat öffnen
function openTagged(){
    tag.style.display = "block";
}

// Tagged-Upload-Formular mit weiteren Informationen zum Beat schließen
function closeTagged(){
    tag.style.display = "none";
}


// ANCHOR Funktionen beim Anmelden bzw. Registrieren
// Funktion, um beim Registrieren zu checken, ob beide Passwörter übereinstimmen (PW & Repeat PW)
function validatePassword(){
    let password = document.getElementById("register-psw");
    let confirm_password = document.getElementById("register-psw-repeat");

    if(password.value === confirm_password.value) {
    confirm_password.setCustomValidity("");
    } else {
    confirm_password.setCustomValidity("Passwords Don't Match");
    }
}


// Funktion für Passwort Validation beim Registrieren, d.h. wenn das Passwort zu kurz bzw. zu lang ist und ob Special Character verwendet wurden, die nicht erlaubt sind
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

// Funktion für Username Validation beim Registrieren, d.h. wenn der Username zu kurz bzw. zu lang ist und ob Special Character verwendet wurden, die nicht erlaubt sind
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

// Funktion für Vornamen Validation beim Registrieren, d.h. wenn der Vorname zu kurz ist und ob Special Character verwendet wurden 
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

// Funktion für Nachnamen Validation beim Registrieren, d.h. wenn der Nachname zu kurz ist und ob Special Character verwendet wurden 
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

// ANCHOR (Validierungs-) Funktionen beim Uploaden von Werken
// Funktion für RadioButtons Validation für F4P, um zu checken, ob ein Radio Button ausgewählt wurde (Pflichtfeld im Formular)
function radioButtonsF4P(){
    let beat = document.getElementById("f4pUpload-type-beat");
    let sample = document.getElementById("f4pUpload-type-sample");

    if(beat.checked === false && sample.checked === false){
        beat.setCustomValidity("Please select an option");
    } else {
        beat.setCustomValidity('');
    }
}

// Funktion für BMP Validation für F4P, um zu checken, ob BPM eingegeben wurde (Pflichtfeld im Formular)
function bpmF4P(){
    let bpm = document.getElementById("f4pUpload-bpm");

    if(bpm.value === ""){
        bpm.setCustomValidity("Please enter your bpm");
    } else {
        bpm.setCustomValidity("");
    }
}

// Funktion für Titel Validation für F4P, um zu checken, ob ein Titel eingegeben wurde (Pflichtfeld im Formular)
function titleF4P(){
    let title = document.getElementById("f4pUpload-title");
    if (title.value === "") {
        title.setCustomValidity("Please enter a title");
    } else {
        title.setCustomValidity("");
    }
}

// Funktion für Datei Validation für F4P, um zu checken, ob ein Werk hochgeladen wurde (Pflichtfeld im Formular, hier wird nicht auf Größe, Länge, ... geachtet)
function fileF4P(){
    let file = document.getElementById("f4pUpload-file");

    if(file.value === ""){
        file.setCustomValidity("Please upload a file");
    } else {
        file.setCustomValidity("");
    }
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

// F4P - Funktion, um den BPM Input einzugrenzen (von 1-999) 
setInputFilter(document.getElementById("f4pUpload-bpm"), function(value) {
    return /^-?\d*$/.test(value)  && (value === "" | parseInt(value) <= 999); });

// Tagged - Funktion, um den BPM Input einzugrenzen (von 1-999)     
setInputFilter(document.getElementById("taggedUpload-bpm"), function(value) {
    return /^-?\d*$/.test(value)  && (value === "" | parseInt(value) <= 999); });


// ANCHOR Grundlegende Funktionen die richtige Ausgabe der Tags bzw. der selbstdefinierten "Kategorien";
let tags = [];
let words = document.getElementById("f4pUpload-tags").value;
let i = 0;
let text = "";
let splitText = [];
let textReplaced;


// F4P-Event Listener für das Hinzufügen von Tags
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


        tags.push(result);
        text += "<h1 class='tagsListing' id='tag" + i + "'>" + tags[i] + "<button id='btn" + i + "' class='btn deleteTags' onclick='deleteF4PTags(this.id);' type='button'><i class='fa fa-close'></i></button>" + "</h1>";
        textReplaced = text.replace(/<h1/g, ",<h1");
        splitText = textReplaced.split(",");
        splitText.splice(0, 1);
        document.getElementById("f4pUpload-tags").value = '';
        let div = document.getElementById('output').innerHTML = text;
        i++;
        if (tags.length >= 5){
                document.getElementById("f4pUpload-tags").disabled = true;
                document.getElementById('f4pUpload-tags').onkeyup = function () {
                document.getElementById('countTags').innerHTML = "Characters left: " + 30;
                  };
            }
    }
  });

// F4P-Funktion für das Löschen von Tags
function deleteF4PTags(btnId){
    btn = document.getElementById(btnId);
    btnNum = parseInt(btnId.substring(3), 10);
    tags.splice(btnNum, 1);
    splitText[btnNum] = "";
    i = tags.length;

    for(let k = btnNum; k < tags.length; k++){
            document.getElementById("tag" + (k+1)).id = "tag" + k;
            document.getElementById("btn" + (k+1)).id = "btn" + k;
            splitText[k+1] = "<h1 class='tagsListing' id='tag" + (k) + "'>" + tags[k] + "<button id='btn" + (k) + "' class='btn deleteTags' onclick='deleteF4PTags(this.id);' type='button'><i class='fa fa-close'></i></button>" + "</h1>";
    }

    if(tags.length < 5){
        document.getElementById("f4pUpload-tags").disabled = false;
    }

    for (let j = 0; j < splitText.length; j++){
        if (splitText[j] == '') {
            splitText.splice(j, 1);
        }
    }
    btn.parentNode.parentNode.removeChild(btn.parentNode);
    text = splitText.toString();
    text = text.replace(/,/g, '');
    return noenter();
}

// Enter Funktion - Bei Drücken der Enter Taste wird das Formular nicht submittet, sondern wieder ins Input Field gefocussed
function noenter() {
    return !(window.event && window.event.keyCode == 13); 
}

// ANCHOR Funktion, um Max Länge von diversen Dingen nicht zu überschreiten
    // TODO nicht mit 200 sondern Variable vielleicht möglich?
// F4P - Überschreitung der Notes
document.getElementById('f4pUpload-notes').onkeyup = function () {
    document.getElementById('countNotes').innerHTML = "Characters left: " + (200 - this.value.length);
};

// Tagged - Überschreitung der Notes
document.getElementById('f4pUpload-tags').onkeyup = function () {
    document.getElementById('countTags').innerHTML = "Characters left: " + (30 - this.value.length);
};

// Nachdem Enter gedrückt wurde und das Tag hinzugefügt wurde, wieder den Zähler der Character auf 30 setzen
document.addEventListener('keyup', function(e){
    if (e.code === 'Enter') {
        document.getElementById('countTags').innerHTML = "Characters left: " + (30);
    }
});


// ANCHOR Funktionen für das Löschen von Input
// F4P - alle Einträge im Form löschen 
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
    text = "";
    i = 0;
    document.getElementById('output').innerHTML = 'Tags: ';
    let tagsListing = document.getElementsByClassName('tagsListing');
    //tagsListing.parentNode.removeChild(tagsListing);
}

// Tagged - alle Einträge im Form löschen 
// TODO noch ergänzen mit F4P Elemente die gelöscht werden sollen
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


// ANCHOR Download-Anzeige Funktione 
function addDownloadCount(id) {
    const count = document.getElementById('downloads'+id);
    const oldNumber = count.innerHTML;
    count.innerHTML = parseInt(oldNumber,10) + 1;
    //alert(oldNumber);
}