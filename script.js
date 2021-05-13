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
    confirm_password.setCustomValidity("Passwords don't match");
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
    const pattern = new RegExp(/^[a-zA-ZÄÜÖäüö]{1,50}$/);

    if(fName.value.length < 1){
        fName.setCustomValidity("Your first name can't be empty");
    } else if(fName.value.length > 50){
        fName.setCustomValidity("Your first name is too long");
    } else if(pattern.test(fName.value) === false){
        fName.setCustomValidity("Please use a real first name");
    } else {
        fName.setCustomValidity("");
    }
}

// Funktion für Nachnamen Validation beim Registrieren, d.h. wenn der Nachname zu kurz ist und ob Special Character verwendet wurden 
function lName(){
    let lName = document.getElementById("register-lastName");
    const pattern = new RegExp(/^[a-zA-ZÄÜÖäüö]{1,50}$/);

    if(lName.value.length < 1){
        lName.setCustomValidity("Your last name can't be empty");
    } else if(lName.value.length > 50){
        lName.setCustomValidity("Your last is too long");
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
// F4P Tags
let f4pTags = [];
let iF4P = 0;
let f4pText = "";
let f4pSplitText = [];
let f4pTextReplaced;

//TODO: evtl checken ob tag field gefocussed is (anm. Gerhart)
// F4P-Event Listener für das Hinzufügen von Tags
document.addEventListener('keyup', function(e){
    let f4pInput = document.getElementById("f4pUpload-tags");
    if (f4pInput === document.activeElement) {
        if (e.code === 'Enter' && f4pTags.length < 5) {
            let f4pStr = document.getElementById("f4pUpload-tags").value;
            let f4pWordArray = f4pStr.split(' ').filter(char => char !== "");
            let f4pResult = "#";
            f4pSplitText = [];

            if(f4pWordArray.length === 0){
                return false;
            }
                f4pResult = f4pResult + f4pWordArray.map(word => {
                let f4pCapitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
                return f4pCapitalizedWord;
            }).join('');

            if(f4pTags.includes(f4pResult) === false){
                f4pTags.push(f4pResult);
                document.getElementById('f4pUpload-tags-hidden').value = f4pTags;
                f4pText += "<h1 class='tagsListing' id='f4pTag" + iF4P + "'>" + f4pTags[iF4P] + "<button id='f4pBtn" + iF4P + "' class='btn deleteTags' onclick='deleteF4PTags(this.id);' type='button'><i class='fa fa-close'></i></button>" + "</h1>";
                f4pTextReplaced = f4pText.replace(/<h1/g, ",<h1");
                f4pSplitText = f4pTextReplaced.split(",");
                f4pSplitText.splice(0, 1);
                document.getElementById("f4pUpload-tags").value = '';
                let f4pDiv = document.getElementById('f4pOutput').innerHTML = f4pText;
                iF4P++;
            } else {
                document.getElementById("f4pUpload-tags").setCustomValidity("u already used this tag");
                document.getElementById("f4pUpload-tags").reportValidity();
            }

            if (f4pTags.length >= 5){
                    document.getElementById("f4pUpload-tags").disabled = true;
                    document.getElementById('f4pUpload-tags').onkeyup = function () {
                        document.getElementById('f4pCountTags').innerHTML = "Characters left: " + (30 - this.value.length);
                    };
                }
        }
    }
  });

// F4P-Funktion für das Löschen von Tags
function deleteF4PTags(f4pBtnId){
    f4pBtn = document.getElementById(f4pBtnId);
    f4pBtnNum = parseInt(f4pBtnId.substring(6), 10);
    f4pTags.splice(f4pBtnNum, 1);
    f4pSplitText[f4pBtnNum] = "";
    iF4P = f4pTags.length;
    

    console.log('numb: ' + f4pBtnNum);
    console.log('other: ' + f4pTags.length);

    for(let k = f4pBtnNum; k < f4pTags.length; k++){
            document.getElementById("f4pTag" + (k+1)).id = "f4pTag" + k;
            document.getElementById("f4pBtn" + (k+1)).id = "f4pBtn" + k;
            f4pSplitText[k+1] = "<h1 class='tagsListing' id='f4pTag" + (k) + "'>" + f4pTags[k] + "<button id='f4pBtn" + (k) + "' class='btn deleteTags' onclick='deleteF4PTags(this.id);' type='button'><i class='fa fa-close'></i></button>" + "</h1>";
    }

    if(f4pTags.length < 5){
        document.getElementById("f4pUpload-tags").disabled = false;
    }

    for (let j = 0; j < f4pSplitText.length; j++){
        if (f4pSplitText[j] == '') {
            f4pSplitText.splice(j, 1);
        }
    }

    f4pBtn.parentNode.parentNode.removeChild(f4pBtn.parentNode);
    f4pText = f4pSplitText.toString();
    f4pText = f4pText.replace(/,/g, '');
    document.getElementById('f4pUpload-tags-hidden').value = f4pTags;
    getF4PFocus();
}


// ANCHOR Tagged Upload Funktionen 
let taggedTags = [];
let iTagged = 0;
let taggedText = "";
let taggedSplitText = [];
let taggedTextReplaced;

// TODO CustomValidity buggt fett rum und wenn man 2 mal das selbe tag eingibt und enter drückt wird characters length trd auf 30 gesetzt
// Tagged-Event Listener für das Hinzufügen von Tags
document.addEventListener('keyup', function(e){
    let taggedInput = document.getElementById("taggedUpload-tags");
    if (taggedInput === document.activeElement) {
        if (e.code === 'Enter' && taggedTags.length < 5) {
            let taggedStr = document.getElementById("taggedUpload-tags").value;
            let taggedWordArray = taggedStr.split(' ').filter(char => char !== "");
            let taggedResult = "#";
            taggedSplitText = [];

            if(taggedWordArray.length === 0){
                return false;
            }
            taggedResult = taggedResult + taggedWordArray.map(word => {
            let taggedCapitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
            return taggedCapitalizedWord;
            }).join('');

            if (taggedTags.includes(taggedResult) === false) {
                taggedTags.push(taggedResult);
                document.getElementById('taggedUpload-tags-hidden').value = taggedTags;
                taggedText += "<h1 class='tagsListing' id='taggedTag" + iTagged + "'>" + taggedTags[iTagged] + "<button id='taggedBtn" + iTagged + "' class='btn deleteTags' onclick='deletetaggedTags(this.id);' type='button'><i class='fa fa-close'></i></button>" + "</h1>";
                let taggedDiv = document.getElementById('taggedOutput').innerHTML = taggedText;
                taggedTextReplaced = taggedText.replace(/<h1/g, ",<h1");
                taggedSplitText = taggedTextReplaced.split(",");
                taggedSplitText.splice(0, 1);
                document.getElementById("taggedUpload-tags").value = '';
                iTagged++;
            } else {
                document.getElementById("taggedUpload-tags").setCustomValidity("u already used this tag");
                document.getElementById("taggedUpload-tags").reportValidity();
            }

            if (taggedTags.length >= 5){
                    document.getElementById("taggedUpload-tags").disabled = true;
                    document.getElementById('taggedUpload-tags').onkeyup = function () {
                    document.getElementById('taggedCountTags').innerHTML = "Characters left: " + (30 - this.value.length);
                }
            }   
        }
    }
  });

// Tagged-Funktion für das Löschen von Tags
function deletetaggedTags(taggedBtnId){
    taggedBtn = document.getElementById(taggedBtnId);
    taggedBtnNum = parseInt(taggedBtnId.substring(9), 10);
    taggedTags.splice(taggedBtnNum, 1);
    taggedSplitText[taggedBtnNum] = "";
    iTagged = taggedTags.length;

    for(let k = taggedBtnNum; k < taggedTags.length; k++){
            document.getElementById("taggedTag" + (k+1)).id = "taggedTag" + k;
            document.getElementById("taggedBtn" + (k+1)).id = "taggedBtn" + k;
            taggedSplitText[k+1] = "<h1 class='tagsListing' id='taggedTag" + (k) + "'>" + taggedTags[k] + "<button id='taggedBtn" + (k) + "' class='btn deleteTags' onclick='deletetaggedTags(this.id);' type='button'><i class='fa fa-close'></i></button>" + "</h1>";
    }

    if(taggedTags.length < 5){
        document.getElementById("taggedUpload-tags").disabled = false;
    }

    for (let j = 0; j < taggedSplitText.length; j++){
        if (taggedSplitText[j] == '') {
            taggedSplitText.splice(j, 1);
        }
    }

    taggedBtn.parentNode.parentNode.removeChild(taggedBtn.parentNode);
    taggedText = taggedSplitText.toString();
    taggedText = taggedText.replace(/,/g, '');
    document.getElementById('taggedUpload-tags-hidden').value = taggedTags;
    getTaggedFocus();
}

// Enter Funktion - Bei Drücken der Enter Taste wird das Formular nicht submittet, sondern wieder ins Input Field gefocussed
function noenter() {
    return !(window.event && window.event.keyCode == 13); 
}

// F4P - Input Focus
function getF4PFocus() {
    document.getElementById("f4pUpload-tags").focus();
}

function getTaggedFocus() {
    document.getElementById("taggedUpload-tags").focus();
}

// ANCHOR Funktion, um Max Länge von diversen Dingen nicht zu überschreiten
    // F4P  
    // TODO nicht mit 200 sondern Variable vielleicht möglich?
// F4P - Überschreitung der Notes
document.getElementById('f4pUpload-notes').onkeyup = function () {
    document.getElementById('f4pCountNotes').innerHTML = "Characters left: " + (200 - this.value.length);
};

// Tagged - Überschreitung der Notes
document.getElementById('taggedUpload-notes').onkeyup = function () {
    document.getElementById('taggedCountNotes').innerHTML = "Characters left: " + (200 - this.value.length);
};

// F4P - Überschreitung der Tags
document.getElementById('f4pUpload-tags').onkeyup = function () {
    document.getElementById('f4pCountTags').innerHTML = "Characters left: " + (30 - this.value.length);
};

// Tagged - Überschreitung der Tags
document.getElementById('taggedUpload-tags').onkeyup = function () {
    document.getElementById('taggedCountTags').innerHTML = "Characters left: " + (30 - this.value.length);
};

// F4P - Nachdem Enter gedrückt wurde und das Tag hinzugefügt wurde, wieder den Zähler der Character auf 30 setzen
document.addEventListener('keyup', function(e){
    if (e.code === 'Enter') {
        document.getElementById('f4pCountTags').innerHTML = "Characters left: " + (30);
    }
});

// Tagged - Nachdem Enter gedrückt wurde und das Tag hinzugefügt wurde, wieder den Zähler der Character auf 30 setzen
document.addEventListener('keyup', function(e){
    if (e.code === 'Enter') {
        document.getElementById('taggedCountTags').innerHTML = "Characters left: " + (30);
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
    document.getElementById('f4pCountNotes').innerHTML = "Characters left: " + 200;
    document.getElementById('f4pCountTags').innerHTML = "Characters left: " + 30;
    document.getElementById("f4pUpload-tags").disabled= false;
    document.getElementById("f4pUpload-file").value = '';
    document.getElementById("f4pUpload-key").value='';
    f4pTags = [];
    f4pText = "";
    iF4P = 0;
    document.getElementById('f4pOutput').innerHTML = '';
    //let tagsListing = document.getElementsByClassName('tagsListing');
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
    taggedTags = [];
    taggedText = "";
    iTagged = 0;
    document.getElementById('taggedOutput').innerHTML = '';
    //let tagsListing = document.getElementsByClassName('tagsListing');
}

// Uploaddata Validations
function fileValidation() {
    const fi = document.getElementById('f4pUpload-file');

    
    // Check if any file is selected.
    if (fi.files.length > 0) {
        for (let i = 0; i <= fi.files.length - 1; i++) {
            let fsize = fi.files.item(i).size;
            let file = Math.round((fsize / 1024));
            
            // The size of the file.
            if (file >= 1000) {
                fi.value = '';
                document.getElementById('errorFile').style.display = 'block';
                document.getElementById('errorFile').innerHTML = 'Select smaller file';
            } 
        }
    }
}
function fileValidation2() {
    let fi = document.getElementById('taggedUpload-file');
    
    // Check if any file is selected.
    if (fi.files.length > 0) {
        for (let i = 0; i <= fi.files.length - 1; i++) {
            let fsize = fi.files.item(i).size;
            let file = Math.round((fsize / 1024));
            
            // The size of the file.
            if (file >= 100000) {
                fi.value = '';
                document.getElementById('errorFile2').style.display = 'block';
                document.getElementById('errorFile2').innerHTML = 'Select smaller file';
            } 
        }
    }
}



