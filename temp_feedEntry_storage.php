<?php
class feedEntry
{
    public $pdo;
    public $id;
    public $title;
    public $path;
    public $tag1;
    public $tag2;
    public $tag3;
    public $tag4;
    public $tag5;
    public $description;
    public $user_id;
    public $bpm;
    public $key_id;
    public $type;
    public $monet;
    public $date;

    public $fileData;
    public $uploaderData;

    function feedEntry($id)
    {

        $this->pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');

        $stmntGetFileData = $this->pdo->prepare("SELECT * FROM files 
                                        INNER JOIN keysignature k ON fk_key_signature_id = k.pk_key_signature_id 
                                        INNER JOIN user u ON fk_user_id = u.pk_user_id 
                                        WHERE pk_files_id = :id");
        $stmntGetFileData->bindParam('id', $id);
        $stmntGetFileData->execute();

        foreach ($stmntGetFileData->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $this->fileData = array(
                'id' => $row['pk_files_id'],
                'title' => $row['Title'],
                'path' => $row['Path'],
                'tag1' => $row['Tag1'],
                'tag2' => $row['Tag2'],
                'tag3' => $row['Tag3'],
                'tag4' => $row['Tag4'],
                'tag5' => $row['Tag5'],
                'description' => $row['Description'],
                'user_id' => $row['fk_user_id'],
                'bpm' => $row['fk_bpm_id'],
                'key_id' => $row['fk_key_signature_id'],
                'key_short' => $row['short'],
                'key_root' => $row['root_note'],
                'key_add' => $row['Addition'],
                'type' => $row['fk_upload_type_id'],
                'monet' => $row['fk_monet_id'],
                'date' => $row['file_added'],
            );
            $this->uploaderData = array(
                'id' => $row['pk_user_id'],
                'username' => $row['Username']
            );
        }

        $stmntGetDownloads = $this->pdo->prepare('SELECT * FROM user_downloaded_file WHERE fk_files_id = ?;');
        $stmntGetDownloads->bindParam(1, $this->fileData['id'], PDO::PARAM_STR, 5000);
        $stmntGetDownloads->execute();
        $this->fileData['downloads'] = $stmntGetDownloads->rowCount();
    }

    function getPlayerCode($purp)
    {
        $echoTag = '';

        if ($purp != 'profile') {
            $tags = "";
            $notags = 0;
            for ($i = 1; $i <= 5; $i++) {
                // $kk = 'id'
                if ($this->fileData['tag' . $i] != "") {
                    $tags .= $this->fileData['tag' . $i]  . ", ";
                } else {
                    $notags++;
                }
                if ($notags == 5) {
                    $tags = "The artist has not added any tags to this Track!";
                }
            }
            $tags = rtrim($tags, ", ");
            $echoTag .= "
        <div class=\"songPlayer\">
        <h class=\"songTitle\"> {$this->fileData['title']} - by <a href=\"http://{$_SERVER['SERVER_NAME']}/user/{$this->fileData['user_id']}\"> {$this->uploaderData['username']} </a></h>
            <div id=\"songInfo{$this->id}\" class=\"songInfo\">
                <h3>Description:</h3>
                <div>{$this->fileData['description']}</div>
                <div>{$this->fileData['bpm']} bpm, {$this->fileData['key_root']} {$this->fileData['key_add']}</div>
                <h3>Tags:</h3>
                <div>
                    <div>$tags</div>
                </div>
            </div>
            <div class=\"songControls\">
                <audio class=\"audioPlayer\" id=\"player{$this->fileData['id']}\" src=\"{$this->fileData['path']}\"></audio>
                <button class=\"songPlayPause\" id=\"playBtn{$this->fileData['id']}\"> Play </button>
                <button class=\"songPlayPause hidden\" id=\"pauseBtn{$this->fileData['id']}\"> Pause </button>
                <input type=\"range\" min=\"0\" max=\"100\" value=\"35\" id=\"volume{$this->fileData['id']}\">
                <input type=\"range\" id=\"progress{$this->fileData['id']}\" value=\"0\" max=\"100\" style=\"width:400px;\"></input>
            </div>
            
            <button id=\"openInfo{$this->fileData['id']}\">INFO</button>
            ";

            // if ($this->fileData['monet'] == 1) {
            //     $showDownload = true;
            //     if (isset($_SESSION['userID'])) {
            //         $stmntLookForSimularDownload = $pdo->prepare("SELECT * FROM user_downloaded_file WHERE fk_user_id = ? AND fk_files_id = ?");
            //         $stmntLookForSimularDownload->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR, 5000);
            //         $stmntLookForSimularDownload->bindParam(2, $row['pk_files_id'], PDO::PARAM_STR, 5000);
            //         $stmntLookForSimularDownload->execute();

            //         $showDownload = $stmntLookForSimularDownload->rowCount() == 0;
            //     }
            //     if (isset($_SESSION['download'][$row['pk_files_id']])) {
            //         $showDownload = false;
            //     }

            //     echo "<a href=\"index.php?downloaded_file={$path}&username_file={$row['Username']}&title_file={$row['Title']}\" ";
            //     if ($showDownload) {
            //         echo "onclick=\"addDownloadCount({$row['pk_files_id']})\"";
            //     }
            //     echo "><i class=\"fa fa-download fa-2x\"></i></a>
            //         <br>
            //         <span id='downloads{$row['pk_files_id']}'>{$downloadsCount}</span> Downloads";
            // } else {
            $echoTag .= "<span>Contact the Artist for access to this File!</span>";
            // }
    } elseif ($feedPurp == 'profile') {
        $tags = "";
        $notags = 0;
        for ($i = 1; $i <= 5; $i++) {
            if ($row['Tag' . $i] != "") {
                $tags .= $row['Tag' . $i] . ", ";
            } else {
                $notags++;
            }
            if ($notags == 5) {
                $tags = "The artist has not added any tags to this Track!";
            }
        }
        $tags = rtrim($tags, ", ");
        echo "
        <div class=\"songPlayer\">
        <h class=\"songTitle\"> {$row['Title']} - by <a href=\"http://{$_SERVER['SERVER_NAME']}/user/{$row['pk_user_id']}\"> {$row['Username']} </a></h>
            <div id=\"songInfo{$row['pk_files_id']}\" class=\"songInfo\">
                <h3>Description:</h3>
                <div>{$row['Description']}</div>
                <div>{$row['fk_bpm_id']} bpm, {$row['root_note']} {$row['Addition']}</div>
                <h3>Tags:</h3>
                <div>
                    <div>$tags</div>
                </div>
            </div>
            <div class=\"songControls\">
                <audio class=\"audioPlayer\" id=\"player{$row['pk_files_id']}\" src=\"{$path}\"></audio>
                <button class=\"songPlayPause\" id=\"playBtn{$row['pk_files_id']}\"> Play </button>
                <button class=\"songPlayPause hidden\" id=\"pauseBtn{$row['pk_files_id']}\"> Pause </button>
                <input type=\"range\" min=\"0\" max=\"100\" value=\"35\" id=\"volume{$row['pk_files_id']}\">
                <input type=\"range\" id=\"progress{$row['pk_files_id']}\" value=\"0\" max=\"100\" style=\"width:400px;\"></input>
            </div>
            
            <button id=\"openInfo{$row['pk_files_id']}\">INFO</button>
            <button id=\"openSettings{$row['pk_files_id']}\">Edit</button>
        ";
        $stmntGetKey = $pdo->prepare('SELECT * FROM keysignature WHERE pk_key_signature_id = ' . $row['fk_key_signature_id']);
        $stmntGetKey->execute();
        foreach ($stmntGetKey->fetchAll(PDO::FETCH_ASSOC) as $rowKey) {
            $keyVal = $rowKey['short'];
        }
?>


        <script>
            numb = <?php echo $row['pk_files_id']; ?>;
            const openSettings<?php echo $row['pk_files_id']; ?> = document.getElementById('openSettings<?php echo $row['pk_files_id']; ?>');

            openSettings<?php echo $row['pk_files_id']; ?>.addEventListener("click", function() {
                openSettings("<?php echo $row['pk_files_id'] . '", "' . $row['Title'] . '", "' . $row['Tag1'] . '", "' . $row['Tag2'] . '", "' . $row['Tag3'] . '", "' . $row['Tag4'] . '", "' . $row['Tag5'] . '", "' . $row['Description'] . '", "' . $row['fk_bpm_id'] . '", "' . $keyVal . '", "' . $row['fk_upload_type_id'] . '", "' . $row['fk_monet_id']; ?>", "");
            });
            blocker.addEventListener("click", function() {
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
    echo
    "</div>";
    echo " <script>
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
        return $echoTag;
    }
}
