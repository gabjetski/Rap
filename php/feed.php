<!--//TODO Comment Code-->

<?php
?>

<div id="settings" class="trackSettings" style="display: none;">
    <div id="blocker" onclick="closeSettings()" class="blocker"></div>
    <div class="form-popup">
        <form id="trackSettingsForm" action="<?php echo $_SESSION['header']; ?>" method="get" class="form-popup" enctype="multipart/form-data">
            <!-- <form id="trackSettingsForm" action="<?php  // echo htmlspecialchars($_SERVER["PHP_SELF"]); 
                                                        ?>" method="post" class="form-popup" enctype="multipart/form-data"> -->
            <h1>Edit Track</h1>
            <div>
                <input type="hidden" id="tset-track-id-hidden" name="tset-track-id" />
                <!-- FreeForProfit Upload - Auswahl Beat -->
                <label for="tset-type-beat"><b>Beat</b></label>
                <input type="radio" id="tset-type-beat" name="tset-type" value="beat" onkeypress="return noenter();">
                <!-- FreeForProfit Upload - Auswahl Sample -->
                <label for="tset-type-sample"><b>Sample</b></label>
                <input type="radio" id="tset-type-sample" name="tset-type" value="sample" onkeypress="return noenter();" required>

                <label for="tset-type-snippet" id="tset-type-snippet-label"><b>Snippet</b></label>
                <input type="radio" id="tset-type-snippet" name="tset-type" value="snippet" onkeypress="return noenter();" required>

                <!-- FreeForProfit  Upload - BPM -->
                <!-- <label for="tset-bpm"><b>BPM*</b></label> -->
                <input type="text" id="tset-bpm" name="tset-bpm" pattern="^\d{2,3}$" maxlength="3" value="123" onkeypress="return noenter();" required>
                <!-- <input type="text" id="tset-bpm" name="tset-bpm" value="123" onkeypress="return noenter();" required> -->
                <!-- FreeForProfit Upload - Key ---- SQL hats nd so mit case sensitivity, maybe value C bei C Major-->
                <label for="tset-key"><b>Key</b></label>
                <select name="tset-key" id="tset-key">
                    <option value="0">Select a key</option>
                    <option value="0">No key</option>
                    <option value="C">C Major</option>
                    <option value="Cm">C minor</option>
                    <option value="Db">Db Major</option>
                    <option value="C#m">C# minor</option>
                    <option value="D">D Major</option>
                    <option value="Dm">D minor</option>
                    <option value="Eb">Eb Major</option>
                    <option value="D#m">D# minor</option>
                    <option value="E">E Major</option>
                    <option value="Em">E minor</option>
                    <option value="F">F Major</option>
                    <option value="fm">F minor</option>
                    <option value="Gb">Gb Major</option>
                    <option value="F#m">F# minor</option>
                    <option value="G">G Major</option>
                    <option value="Gm">G minor</option>
                    <option value="Ab">Ab Major</option>
                    <option value="G#m">G# minor</option>
                    <option value="A">A Major</option>
                    <option value="Am">A minor</option>
                    <option value="Bb">Bb Major</option>
                    <option value="A#m">A# minor</option>
                    <option value="B">B Major</option>
                    <option value="bm">B minor</option>
                </select>
                <!-- FreeForProfit - Title des Uploads -->
                <label for="tset-title"><b>Title*</b></label>
                <input type="text" id="tset-title" name="tset-title" required maxlength="60" onkeypress="return noenter();">
                <!-- Blacklist, checked Banned Words-->
                <!-- <button type="button" onclick="checkBanWords();"> Blacklist Check </button> -->
                <p>Maximum 200 Characters allowed</p>
                <!-- FreeForProfit - Notizen -->
                <label for="tset-notes"><b>Notes</b></label>
                <textarea id="tset-notes" rows="4" cols="50" maxlength="200" name="tset-desc"></textarea>
                <div id="tset-CountNotes">Characters left: 200</div>
                <!-- FreeForProfit - Tags -->
                <label for="tset-tags"><b>Tags (5)</b></label>
                <input type="text" id="tset-tags" onkeypress="return noenter();" maxlength="30">
                <!-- Hidden Input, der die Values vom tset Tags Array nimmt -->
                <input type="hidden" id="tset-tags-hidden" name="tset-tags" value='' />
                <!-- Tags Output -->
                <div id="tset-Output"></div>
                <div id="tset-CountTags">Characters left: 30</div>
                <p class="error" id="tset-error" style="display: none;"></p>
                <button type="button" class="cancelButton" value="delete" onclick="delTrack1()" class="continue" id="tset-del">Delete Track</button>
                <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
                <button type="submit" class="continueButton" name="tset-submit" value="Finish" onclick="" class="continue" id="tset-submit">Finish</button>
                <!-- onclick="openUploadSuccess();" hinzufügen beim submit button-->
                <button type="button" class="continueButton" name="Back" value="Back" class="continue" onclick="closetset(); openUpload();">Back</button>
                <button type="button" class="cancelButton" onclick="closetset();">Cancel</button>
            </div>
            <div class="delAsk" id="delAsk" style="display: none;">
                <div id=" blocker" onclick="closeDelAsk()" class="blocker"></div>
                <div class="form-popup">
                    You really wanna delete the track?
                    <button type="submit" class="cancelButton" name="tset-del" value="deleteFin" class="continue" id="tset-del-fin">Yes</button>
                    <!-- onclick="openUploadSuccess();" hinzufügen beim submit button-->
                    <button type="button" class="continueButton" value="Back" class="continue" onclick="closeDelAsk()">No</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    let currPlayingID;
    let numb;
    const settings = document.getElementById('settings');
    const blocker = document.getElementById('blocker');

    const sett_title = document.getElementById('tset-title');
    const sett_id = document.getElementById('tset-track-id-hidden');
    const sett_tags = document.getElementById('tset-tags');
    const sett_desc = document.getElementById('tset-notes');
    const sett_bpm = document.getElementById('tset-bpm');
    const sett_keyID = document.getElementById('tset-key');
    const sett_type_beat = document.getElementById('tset-type-beat');
    const sett_type_sample = document.getElementById('tset-type-sample');
    const sett_type_snippet = document.getElementById('tset-type-snippet');

    let tsettags = [];
    let itset = 0;
    let tsetext = "";
    let tsetSplitText = [];
    let tsetextReplaced;

    function togglePlayPause(id) {
        eval('playBtn' + id).classList.toggle("hidden");
        eval('pauseBtn' + id).classList.toggle("hidden");
        //window['pauseBtn'+id].classList.toggle("hidden"); 
        //console.log('eeeee');
    }

    function togglePlayPauseMain() {
        if (currPlayingID != 0) {
            //togglePlayPause('M');
        }
    }

    function playTrack(id) {
        const allPlayer = document.getElementsByClassName('audioPlayer');
        for (let i = 0; i < allPlayer.length; i++) {
            if (allPlayer[i].paused == false) {
                togglePlayPause(allPlayer[i].id.replace('player', ''));
                //togglePlayPause('M');
            }
            allPlayer[i].pause();
        }
        eval('player' + id).play();

        currPlayingID = id;
        //togglePlayPause('M');
        togglePlayPauseMain();
        //console.log(id);
    }

    function pause(id) {
        eval('player' + id).pause();
        //window['player'+id].pause();
        currPlayingID = 0;
        togglePlayPauseMain();
        //togglePlayPause('M');
    }

    function newVolume(id) {
        eval('player' + id).volume = eval('volume' + id).value / 100;
        //window['player'+id].volume = window['volume'+id].value/100;
    }

    function newProgress(id) {
        eval('player' + id).currentTime = eval('progress' + id).value * eval('player' + id).duration / 100;
        //window['player'+id].volume = window['volume'+id].value/100;
    }

    function openInfo(id) {
        eval('songInfo' + id).classList.toggle('songInfoOpen');
    }

    function noenter() {
        return !(window.event && window.event.keyCode == 13);
    }

    function openSettings(id, title, tag1, tag2, tag3, tag4, tag5, desc, bpm, key_short, typeID, monetID, error) {
        deleteTagFields();
        tsettags = [];
        settings.style.display = 'block';

        sett_id.value = id;
        sett_title.value = title;
        tsettagsArr = [tag1, tag2, tag3, tag4, tag5];
        tsettagsArr.forEach(element => {
            // console.log(element);
            tagsTSET(element.substring(1));
        });
        sett_desc.value = desc;
        sett_keyID.value = key_short;
        if (monetID == 1) {
            sett_type_snippet.style.display = 'none';
            document.getElementById('tset-type-snippet-label').style.display = 'none';
        } else {
            sett_type_snippet.style.display = '';
            document.getElementById('tset-type-snippet-label').style.display = '';
        }
        switch (typeID) {
            case '1':
                sett_type_beat.checked = true;
                break;
            case '2':
                sett_type_sample.checked = true;
                break;
            case '3':
                sett_type_snippet.checked = true;
                break;
        }
        document.getElementById('tset-CountNotes').innerHTML = "Characters left: " + (200 - sett_desc.value.length);

        if (error) {
            let errorMsg;

            switch (error) {
                case '-1':
                    errorMsg = 'Please select a type';
                    break;
                case '-2':
                    errorMsg = 'Please enter a BPM between 0 and 999';
                    break;
                case '-3':
                    errorMsg = 'Please enter a valid title';
                    break;
                case '-4':
                    errorMsg = 'Please enter a valid description';
                    break;

                default:
                    errorMsg = 'Something went wrong';
                    break;
            }
            document.getElementById('tset-error').style.display = '';
            document.getElementById('tset-error').innerHTML = errorMsg;

        } else {
            document.getElementById('tset-error').style.display = 'none';
            document.getElementById('tset-error').innerHTML = '';
        }
    }

    function closeSettings(id) {
        settings.style.display = 'none';
    }
    document.getElementById('tset-notes').onkeyup = function() {
        document.getElementById('tset-CountNotes').innerHTML = "Characters left: " + (200 - this.value.length);
    };

    function deleteTagFields() {
        tsettags = [];
        let allTags = document.querySelectorAll('.tagsListing');
        const allTagsParent = document.getElementById('tset-Output');


        allTags.forEach(element => {
            allTagsParent.removeChild(element);
            console.log(element);
        });
        tsettags = [];
        itset = 0;
        tsetext = "";
        tsetSplitText = [];
        tsetextReplaced;
    }


    function tagsTSET(a) {
        let tsetStr = a;
        let tsetWordArray = tsetStr.split(' ').filter(char => char !== "");
        let tsetResult = "#";
        tsetSplitText = [];

        if (tsetWordArray.length === 0) {
            return false;
        }
        tsetResult = tsetResult + tsetWordArray.map(word => {
            let tsetCapitalizedWord = word.charAt(0).toUpperCase() + word.slice(1);
            return tsetCapitalizedWord;
        }).join('');

        if (tsettags.includes(tsetResult) === false) {
            tsettags.push(tsetResult);
            document.getElementById('tset-tags-hidden').value = tsettags;
            tsetext += "<h1 class='tagsListing' id='tsetag" + itset + "'>" + tsettags[itset] + "<button id='tsetBtn" + itset + "' class='btn deleteTags' onclick='deletetsettags(this.id);' type='button'><i class='fa fa-close'></i></button>" + "</h1>";
            tsetextReplaced = tsetext.replace(/<h1/g, ",<h1");
            tsetSplitText = tsetextReplaced.split(",");
            tsetSplitText.splice(0, 1);
            document.getElementById("tset-tags").value = '';
            let tsetDiv = document.getElementById('tset-Output').innerHTML = tsetext;
            itset++;
        } else {
            document.getElementById("tset-tags").setCustomValidity("u already used this tag");
            document.getElementById("tset-tags").reportValidity();
        }

        if (tsettags.length >= 5) {
            document.getElementById("tset-tags").disabled = true;
            document.getElementById('tset-tags').onkeyup = function() {
                document.getElementById('tset-CountTags').innerHTML = "Characters left: " + (30 - this.value.length);
            };
        }
    }
    // tset-Event Listener für das Hinzufügen von Tags
    document.addEventListener('keyup', function(e) {
        if (e.code === 'Enter' && tsettags.length < 5) {
            tagsTSET(document.getElementById("tset-tags").value);
        }
    });

    // tset-Funktion für das Löschen von Tags
    function deletetsettags(tsetBtnId) {
        tsetBtn = document.getElementById(tsetBtnId);
        tsetBtnNum = parseInt(tsetBtnId.substring(7), 10);
        tsettags.splice(tsetBtnNum, 1);
        tsetSplitText[tsetBtnNum] = "";
        itset = tsettags.length;

        // console.log('numb: ' + tsetBtnNum);
        // console.log('other: ' + tsettags.length);

        for (let k = tsetBtnNum; k < tsettags.length; k++) {
            document.getElementById("tsetag" + (k + 1)).id = "tsetag" + k;
            document.getElementById("tsetBtn" + (k + 1)).id = "tsetBtn" + k;
            tsetSplitText[k + 1] = "<h1 class='tagsListing' id='tsetag" + (k) + "'>" + tsettags[k] + "<button id='tsetBtn" + (k) + "' class='btn deleteTags' onclick='deletetsettags(this.id);' type='button'><i class='fa fa-close'></i></button>" + "</h1>";

            // console.log('k: ' + k + ' - Text: ' + tsetSplitText[k + 1]);
        }

        if (tsettags.length < 5) {
            document.getElementById("tset-tags").disabled = false;
        }

        for (let j = 0; j < tsetSplitText.length; j++) {
            if (tsetSplitText[j] == '') {
                tsetSplitText.splice(j, 1);
            }
        }
        // console.log(tsetBtn.parentNode);
        tsetBtn.parentNode.parentNode.removeChild(tsetBtn.parentNode);
        tsetext = tsetSplitText.toString();
        tsetext = tsetext.replace(/,/g, '');
        document.getElementById('tset-tags-hidden').value = tsettags;
        gettsetFocus();
    }

    function gettsetFocus() {
        document.getElementById("tset-tags").focus();
    }

    function delTrack1() {
        document.getElementById('delAsk').style.display = '';
        console.log('test');
    }

    function closeDelAsk() {
        document.getElementById('delAsk').style.display = 'none';
    }
</script>

<?php
if (!isset($feedPurp) || $feedPurp == 'main') {
    // select all songs which schould be displayed
    $stmntGetSongs = $pdo->prepare('SELECT * FROM files INNER JOIN user ON user.pk_user_id = files.fk_user_id
    INNER JOIN keysignature k ON files.fk_key_signature_id = k.pk_key_signature_id ORDER BY pk_files_id DESC'); // TODO Inner join mit feed, das nur Files auusm Feed gezeigt werden
    $stmntGetSongs->execute();
    $pathAddition = "";
    //fetch the results
    if ($stmntGetSongs->rowCount() == 0) {
        echo "Looks like you are the first person here. Feel free to upload and present your work to the world :)";
    }
} elseif ($feedPurp == 'user') {
    // select all songs which schould be displayed
    $stmntGetSongs = $pdo->prepare('SELECT * FROM files 
                                    INNER JOIN user ON user.pk_user_id = files.fk_user_id 
                                    INNER JOIN keysignature k ON files.fk_key_signature_id = k.pk_key_signature_id 
                                    WHERE pk_user_id = ? 
                                    ORDER BY pk_files_id DESC');
    $stmntGetSongs->bindParam(1, $_GET['userID'], PDO::PARAM_STR, 5000);
    $stmntGetSongs->execute();
    $pathAddition = "../../";
    //fetch the results
    if ($stmntGetSongs->rowCount() == 0) {
        echo "Looks like this user hasn't shared his creativity. Maybe he'll post one day :)";
    }
} elseif ($feedPurp == 'profile') {
    // select all songs which schould be displayed
    $stmntGetSongs = $pdo->prepare('SELECT * FROM files 
                                    INNER JOIN user ON user.pk_user_id = files.fk_user_id  
                                    INNER JOIN keysignature k ON files.fk_key_signature_id = k.pk_key_signature_id 
                                    WHERE pk_user_id = ? 
                                    ORDER BY pk_files_id DESC');
    $stmntGetSongs->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR, 5000);
    $stmntGetSongs->execute();
    $pathAddition = "../../";
    //fetch the results
    if ($stmntGetSongs->rowCount() == 0) {
        echo "You could start uploading your beats :)";
    }
} elseif ($feedPurp == 'search') {
    // select all songs which schould be displayed
    $stmntGetSongs = $pdo->prepare('SELECT * FROM files 
                                    INNER JOIN user ON user.pk_user_id = files.fk_user_id 
                                    where Title like :keyword OR Tag1 LIKE :keyword OR 
                                    Tag2 LIKE :keyword OR Tag3 LIKE :keyword OR 
                                    Tag4 LIKE :keyword OR Tag5 LIKE :keyword
                                    OR Username LIKE :keyword
                                    ORDER BY pk_files_id DESC');
    $stmntGetSongs->bindParam(':keyword', $keyword, PDO::PARAM_STR);
    $stmntGetSongs->execute();
    $pathAddition = "../../";
    //fetch the results
    if ($stmntGetSongs->rowCount() == 0) {
        echo "No Tracks found with title " .  $_GET['searchTerm'];
    }
} 



foreach ($stmntGetSongs->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $id = $row['pk_files_id'];

    if (!isset($feedPurp)) {
        $feedPurp = 'main';
    }
    $$id = new feedEntry($id, $feedPurp);
    echo $$id->getPlayerCode($feedPurp);
    // echo "<pre>";
    // var_dump(htmlspecialchars($$id->getPlayerCode($feedPurp)));
    // echo "</pre>";
} ?>