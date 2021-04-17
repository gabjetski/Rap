<!--//TODO Comment Code-->
<script>
    let currPlayingID;

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
                //console.log('false: '+i);
                togglePlayPause(allPlayer.length - i);
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
        eval('songInfo' + id).style.display = 'block';
    }

    function openSettings(id) {
        eval('settings' + id).style.display = 'block';
    }

    function closeSettings(id) {
        eval('settings' + id).style.display = 'none';
    }
</script>

<?php
if (!isset($feedPurp) || $feedPurp == 'main') {
    // select all songs which schould be displayed
    $stmntGetSongs = $pdo->prepare('SELECT * FROM files INNER JOIN user ON user.pk_user_id = files.fk_user_id ORDER BY pk_files_id DESC'); // TODO Inner join mit feed, das nur Files auusm Feed gezeigt werden
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
                                    WHERE pk_user_id = ? 
                                    ORDER BY pk_files_id DESC');
    $stmntGetSongs->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR, 5000);
    $stmntGetSongs->execute();
    $pathAddition = "../../";
    //fetch the results
    if ($stmntGetSongs->rowCount() == 0) {
        echo "Looks like this user hasn't shared his creativity. Maybe he'll post one day :)";
    }
}


# code...
foreach ($stmntGetSongs->fetchAll(PDO::FETCH_ASSOC) as $row) {
    //set the path of the file
    $path = $pathAddition . "uploads/" . str_replace('#', '%23', $row['Path']);
    //select count of downloads for that file
    $stmntGetDownloads = $pdo->prepare('SELECT * FROM user_downloaded_file WHERE fk_files_id = ?;');
    $stmntGetDownloads->bindParam(1, $row['pk_files_id'], PDO::PARAM_STR, 5000);
    $stmntGetDownloads->execute();
    $downloadsCount = $stmntGetDownloads->rowCount();
    if (!isset($feedPurp) || $feedPurp != 'profile') {
        echo "
    <div class=\"songPlayer\">
    <div class=\"songTitle\"> {$row['Title']} - by <a href=\"user/{$row['pk_user_id']}\"> {$row['Username']} </a></div>
        <div class=\"songControls\">
            <audio class=\"audioPlayer\" id=\"player{$row['pk_files_id']}\" src=\"{$path}\"></audio>
            <button class=\"songPlayPause\" id=\"playBtn{$row['pk_files_id']}\"> Play </button>
            <button class=\"songPlayPause hidden\" id=\"pauseBtn{$row['pk_files_id']}\"> Pause </button>
            <input type=\"range\" min=\"0\" max=\"100\" value=\"35\" id=\"volume{$row['pk_files_id']}\">
            <input type=\"range\" id=\"progress{$row['pk_files_id']}\" value=\"0\" max=\"100\" style=\"width:400px;\"></input>
        </div>
        
        <button id=\"openInfo{$row['pk_files_id']}\">INFO</button>
        <div id=\"songInfo{$row['pk_files_id']}\" class=\"songInfo\">
            <div id=\"blocker{$row['pk_files_id']}\" class=\"blocker\"></div>
            <div class=\"form-popup\">
                <div>HALLOO</div>
            </div>
        </div>
        ";

        if ($row['fk_monet_id'] == 1) {
            $showDownload = true;
            if (isset($_SESSION['userID'])) {
                $stmntLookForSimularDownload = $pdo->prepare("SELECT * FROM user_downloaded_file WHERE fk_user_id = ? AND fk_files_id = ?");
                $stmntLookForSimularDownload->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR, 5000);
                $stmntLookForSimularDownload->bindParam(2, $row['pk_files_id'], PDO::PARAM_STR, 5000);
                $stmntLookForSimularDownload->execute();

                $showDownload = $stmntLookForSimularDownload->rowCount() == 0;
            }
            if (isset($_SESSION['download'][$row['pk_files_id']])) {
                $showDownload = false;
            }

            echo "<a href=\"index.php?downloaded_file={$path}&username_file={$row['Username']}&title_file={$row['Title']}\" ";
            if ($showDownload) {
                echo "onclick=\"addDownloadCount({$row['pk_files_id']})\"";
            }
            echo "><i class=\"fa fa-download fa-2x\"></i></a>
                <br>
                <span id='downloads{$row['pk_files_id']}'>{$downloadsCount}</span> Downloads";
        } else {
            echo "<span>Contact the Artist for access to this File!</span>";
        }
    } elseif ($feedPurp == 'profile') {
        echo "
    <div class=\"songPlayer\">
    <div class=\"songTitle\"> {$row['Title']} - by <a href=\"user/{$row['pk_user_id']}\"> {$row['Username']} </a></div>
        <div class=\"songControls\">
            <audio class=\"audioPlayer\" id=\"player{$row['pk_files_id']}\" src=\"{$path}\"></audio>
            <button class=\"songPlayPause\" id=\"playBtn{$row['pk_files_id']}\"> Play </button>
            <button class=\"songPlayPause hidden\" id=\"pauseBtn{$row['pk_files_id']}\"> Pause </button>
            <input type=\"range\" min=\"0\" max=\"100\" value=\"35\" id=\"volume{$row['pk_files_id']}\">
            <input type=\"range\" id=\"progress{$row['pk_files_id']}\" value=\"0\" max=\"100\" style=\"width:400px;\"></input>
        </div>
        
        <button id=\"openInfo{$row['pk_files_id']}\">INFO</button>
        <div id=\"songInfo{$row['pk_files_id']}\" class=\"songInfo\">
            <div id=\"blocker{$row['pk_files_id']}\" class=\"blocker\"></div>
            <div class=\"form-popup\">
                <div>HALLOO</div>
            </div>
        </div>
        <button id=\"openSettings{$row['pk_files_id']}\">Edit</button>
        ";
?>
        <div id="settings<?php echo $row['pk_files_id'] ?>" class="trackSettings">
            <div id="blocker<?php echo $row['pk_files_id'] ?>" onclick="closeSettings(<?php echo $row['pk_files_id'] ?>)" class="blocker"></div>
            <div class="form-popup">
                <form id="f4pForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-popup" enctype="multipart/form-data">
                    <h1>F4P Upload</h1>
                    <div>
                    <!-- FreeForProfit Upload - Auswahl Beat -->
                    <label for="f4pUpload-type-beat"><b>Beat</b></label>
                    <input type="radio" id="f4pUpload-type-beat" name="f4pUpload-type" value="beat" onkeypress="return noenter();" required <?php if ($row['fk_upload_type'] == 1) {
                        echo "checked";
                    } ?>>
                    <!-- FreeForProfit Upload - Auswahl Sample -->
                    <label for="f4pUpload-type-sample"><b>Sample</b></label>
                    <input type="radio" id="f4pUpload-type-sample" name="f4pUpload-type" value="sample" onkeypress="return noenter();" required <?php if ($row['fk_upload_type'] == 2) {
                        echo "checked";
                    } ?>>
                    <!-- FreeForProfit  Upload - BPM -->
                    <label for="f4pUpload-bpm"><b>BPM*</b></label>
                    <input type="text" id="f4pUpload-bpm" name="f4pUpload-bpm" pattern="^\d{2,3}$" maxlength="3" value="123" onkeypress="return noenter();" required>
                    <!-- FreeForProfit Upload - Key ---- SQL hats nd so mit case sensitivity, maybe value C bei C Major-->
                    <label for="f4pUpload-key"><b>Key</b></label>
                    <select name="f4pUpload-key" id="f4pUpload-key">
                        <option value="0" disabled>Select a key</option>
                        <option value="C" selected>C Major</option>
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
                    <label for="f4pUpload-title"><b>Title*</b></label>
                    <input type="text" id="f4pUpload-title" name="f4pUpload-title" required maxlength="60" onkeypress="return noenter();" value="Hallo">
                    <!-- Blacklist, checked Banned Words-->
                    <!-- <button type="button" onclick="checkBanWords();"> Blacklist Check </button> -->
                    <p>Maximum 200 Characters allowed</p>
                    <!-- FreeForProfit - Notizen -->
                    <label for="f4pUpload-notes"><b>Notes</b></label>
                    <textarea id="f4pUpload-notes" rows="4" cols="50" maxlength="200" name="f4pUpload-desc"></textarea>
                    <div id="f4pCountNotes">Characters left: 200</div>
                    <!-- FreeForProfit - Tags -->
                    <label for="f4pUpload-tags"><b>Tags (5)</b></label>
                    <input type="text" id="f4pUpload-tags" onkeypress="return noenter();" maxlength="30">
                    <!-- Hidden Input, der die Values vom F4P Tags Array nimmt -->
                    <input type="hidden" id="f4pUpload-tags-hidden" name="f4pUpload-tags" value='' />
                    <!-- Tags Output -->
                    <div id="f4pOutput"></div>
                    <div id="f4pCountTags">Characters left: 30</div>
                    <!-- FreeForProfit - File Upload -->
                    <label for="f4pUpload-file"><b>File</b></label>
                    <!-- <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>-->
                    <input type="file" accept=".mp3" id="f4pUpload-file" name="f4pUpload-file" onkeypress="return noenter();" required />
                    <!-- Alle Einträge vom Forms Löschen -->
                    <button type="button" onclick="clearF4PForm();"> Clear All </button>
                    <!-- Buttons beim Login Form mit Funktionen "Login", "zu Register Form wechseln" und "Formular schließen" -->
                    <button type="submit" class="continueButton" name="f4pUpload-submit" value="Finish" onclick="checkBanWords(); radioButtonsF4P();  bpmF4P(); titleF4P(); fileF4P();" class="continue" id="f4pUpload-submit">Finish</button>
                    <!-- onclick="openUploadSuccess();" hinzufügen beim submit button-->
                    <button type="button" class="continueButton" name="Back" value="Back" class="continue" onclick="closeF4P(); openUpload();">Back</button>
                    <button type="button" class="cancelButton" onclick="closeF4P();">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const numb = <?php echo $row['pk_files_id']; ?>;
            const openSetting<?php echo $row['pk_files_id']; ?> = document.getElementById('openSettings' + numb);
            const blocker<?php echo $row['pk_files_id']; ?> = document.getElementById('blocker' + numb);
            const settings<?php echo $row['pk_files_id']; ?> = document.getElementById('settings' + numb);

            eval('openSettings' + numb).addEventListener("click", function() {
                openSettings(numb);
            });
            eval('blocker' + numb).addEventListener("click", function() {
                closeSettings(numb);
            });
        </script>

<?php

        if ($row['fk_monet_id'] == 1) {
            $showDownload = true;
            if (isset($_SESSION['userID'])) {
                $stmntLookForSimularDownload = $pdo->prepare("SELECT * FROM user_downloaded_file WHERE fk_user_id = ? AND fk_files_id = ?");
                $stmntLookForSimularDownload->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR, 5000);
                $stmntLookForSimularDownload->bindParam(2, $row['pk_files_id'], PDO::PARAM_STR, 5000);
                $stmntLookForSimularDownload->execute();

                $showDownload = $stmntLookForSimularDownload->rowCount() == 0;
            }
            if (isset($_SESSION['download'][$row['pk_files_id']])) {
                $showDownload = false;
            }

            echo "<a href=\"index.php?downloaded_file={$path}&username_file={$row['Username']}&title_file={$row['Title']}\" ";
            if ($showDownload) {
                echo "onclick=\"addDownloadCount({$row['pk_files_id']})\"";
            }
            echo "><i class=\"fa fa-download fa-2x\"></i></a>
                <br>
                <span id='downloads{$row['pk_files_id']}'>{$downloadsCount}</span> Downloads";
        } else {
            echo "<span>Contact the Artist for access to this File!</span>";
        }
    }
    //FIXME volume bar changes for all
    //TODO general soundbar on bottom
    echo
    "</div>
    <script>
        const playBtn{$row['pk_files_id']} = document.getElementById(\"playBtn{$row['pk_files_id']}\");
        const pauseBtn{$row['pk_files_id']} = document.getElementById(\"pauseBtn{$row['pk_files_id']}\");
        const progress{$row['pk_files_id']} = document.getElementById(\"progress{$row['pk_files_id']}\");
        const player{$row['pk_files_id']} = document.getElementById(\"player{$row['pk_files_id']}\");

        const infoBtn{$row['pk_files_id']} = document.getElementById(\"openInfo{$row['pk_files_id']}\");

        player{$row['pk_files_id']}.volume = 0.35;

        const volume{$row['pk_files_id']} = document.getElementById(\"volume{$row['pk_files_id']}\");

        volume{$row['pk_files_id']}.addEventListener(\"change\", function(){newVolume({$row['pk_files_id']});});
        
        progress{$row['pk_files_id']}.addEventListener(\"change\", function(){console.log(progress{$row['pk_files_id']}.value);newProgress({$row['pk_files_id']});});
        progress{$row['pk_files_id']}.addEventListener(\"mousedown\", function(){pause({$row['pk_files_id']});});
        progress{$row['pk_files_id']}.addEventListener(\"mouseup\", function(){
            if(playBtn{$row['pk_files_id']}.classList.contains('hidden')){
                playTrack({$row['pk_files_id']});
            }
        });

        playBtn{$row['pk_files_id']}.addEventListener(\"click\", function(){playTrack({$row['pk_files_id']});});
        playBtn{$row['pk_files_id']}.addEventListener(\"click\", function(){togglePlayPause({$row['pk_files_id']});});

        pauseBtn{$row['pk_files_id']}.addEventListener(\"click\", function(){pause({$row['pk_files_id']});});
        pauseBtn{$row['pk_files_id']}.addEventListener(\"click\", function(){togglePlayPause({$row['pk_files_id']});});

        infoBtn{$row['pk_files_id']}.addEventListener(\"click\", function(){openInfo({$row['pk_files_id']});});


        
        let testPlayer{$row['pk_files_id']} = document.getElementById('player4');
        let testProgessBar{$row['pk_files_id']} = document.getElementById('progess4');

        player{$row['pk_files_id']}.ontimeupdate = function(){
            //console.log('Hallo');
            //console.log(testPlayer{$row['pk_files_id']}.value);
        }


        player{$row['pk_files_id']}.ontimeupdate = function(){
            progress{$row['pk_files_id']}.value = player{$row['pk_files_id']}.currentTime / player{$row['pk_files_id']}.duration*100;
            if(player{$row['pk_files_id']}.currentTime == player{$row['pk_files_id']}.duration){
                if(playBtn{$row['pk_files_id']}.classList.contains('hidden')){
                    togglePlayPause({$row['pk_files_id']});
                    //togglePlayPause('M');
                }
            }
            //console.log(player{$row['pk_files_id']}.currentTime);
        };


        //let vid{$row['pk_files_id']} = document.getElementById('volume4');
        //vid{$row['pk_files_id']}.volume = 0.2;

    </script>";
    echo "<br>";
}
?>
<!--<div class="mainPlayer">
    <button class="songPlayPause" id="playBtnM"> Play </button>
    <button class="songPlayPause hidden" id="pauseBtnM"> Pause </button>
    <input type="range" min="0" max="20" value="10" id="volumeM">
    <input type="range" id="progressM" value="0" max="100" style="width:400px;"></input>
</div>-->
<script>
    /*const playBtnM = document.getElementById('playBtnM');
    const pauseBtnM = document.getElementById('pauseBtnM');
    const progressM = document.getElementById('progressM');
    const playerM = document.getElementById('playerM');*/
</script>