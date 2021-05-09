<?php
class feedEntry
{
    public $fileData;
    public $uploaderData;
    public $otherInfo;

    function __construct($id, $purp)
    {

        if ($purp == 'main') {
            $pathAddition = "";
        } elseif ($purp == 'user') {
            $pathAddition = "../../";
        } elseif ($purp == 'profile') {
            $pathAddition = "../../";
        } elseif ($purp == 'search') {
            $pathAddition = "../../";
        }


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
                'path' => htmlspecialchars($row['Path']),
                'downloadPath' => str_replace('#', '%23', htmlspecialchars($row['Path'])),
                'realPath' => $pathAddition . "uploads/" . str_replace('#', '%23', htmlspecialchars($row['Path'])),
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

        $showDownload = true;
        if ($_SESSION['userID'] != 1) {
            $stmntLookForSimularDownload = $this->pdo->prepare("SELECT * FROM user_downloaded_file WHERE fk_user_id = ? AND fk_files_id = ?");
            $stmntLookForSimularDownload->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR, 5000);
            $stmntLookForSimularDownload->bindParam(2, $this->fileData['id'], PDO::PARAM_STR, 5000);
            $stmntLookForSimularDownload->execute();

            $showDownload = $stmntLookForSimularDownload->rowCount() == 0;
        }
        if (isset($_SESSION['download'][$this->fileData['id']])) {
            $showDownload = false;
        }
        if (!isset($_SESSION['header'])) {
            $_SESSION['header'] = '/home';
        }
        $this->otherInfo = array(
            'showDownload' => $showDownload,
            // {$_SERVER['PHP_SELF']}?downloaded_file={$this->fileData['downloadPath']}&username_file={$this->uploaderData['username']}&title_file={$this->fileData['title']}
            'downloadLink' => "http://{$_SERVER['SERVER_NAME']}{$_SESSION['header']}?downloaded_file={$this->fileData['downloadPath']}&username_file={$this->uploaderData['username']}&title_file={$this->fileData['title']}"
        );
    }

    function playerFunctions()
    {
        return <<< returnFunctions
        <script>
            const playBtn{$this->fileData['id']} = document.getElementById("playBtn{$this->fileData['id']}");
            const pauseBtn{$this->fileData['id']} = document.getElementById("pauseBtn{$this->fileData['id']}");
            const progress{$this->fileData['id']} = document.getElementById("progress{$this->fileData['id']}");
            const player{$this->fileData['id']} = document.getElementById("player{$this->fileData['id']}");

            const infoBtn{$this->fileData['id']} = document.getElementById("openInfo{$this->fileData['id']}");

            player{$this->fileData['id']}.volume = 0.35;

            const volume{$this->fileData['id']} = document.getElementById("volume{$this->fileData['id']}");

            volume{$this->fileData['id']}.addEventListener("change", function(){newVolume({$this->fileData['id']});});

            progress{$this->fileData['id']}.addEventListener("change", function(){console.log(progress{$this->fileData['id']}.value);newProgress({$this->fileData['id']});});
            progress{$this->fileData['id']}.addEventListener("mousedown", function(){pause({$this->fileData['id']});});
            progress{$this->fileData['id']}.addEventListener("mouseup", function(){
                if(playBtn{$this->fileData['id']}.classList.contains('hidden')){
                    playTrack({$this->fileData['id']});
                }
            });

            playBtn{$this->fileData['id']}.addEventListener("click", function(){playTrack({$this->fileData['id']});});
            playBtn{$this->fileData['id']}.addEventListener("click", function(){togglePlayPause({$this->fileData['id']});});

            pauseBtn{$this->fileData['id']}.addEventListener("click", function(){pause({$this->fileData['id']});});
            pauseBtn{$this->fileData['id']}.addEventListener("click", function(){togglePlayPause({$this->fileData['id']});});

            infoBtn{$this->fileData['id']}.addEventListener("click", function(){openInfo({$this->fileData['id']});});



            let testPlayer{$this->fileData['id']} = document.getElementById('player4');
            let testProgessBar{$this->fileData['id']} = document.getElementById('progess4');

            player{$this->fileData['id']}.ontimeupdate = function(){
                //console.log('Hallo');
                //console.log(testPlayer{$this->fileData['id']}.value);
            }


            player{$this->fileData['id']}.ontimeupdate = function(){
                progress{$this->fileData['id']}.value = player{$this->fileData['id']}.currentTime / player{$this->fileData['id']}.duration*100;
                if(player{$this->fileData['id']}.currentTime == player{$this->fileData['id']}.duration){
                    if(playBtn{$this->fileData['id']}.classList.contains('hidden')){
                        togglePlayPause({$this->fileData['id']});
                        //togglePlayPause('M');
                    }
                }
                //console.log(player{$this->fileData['id']}.currentTime);
            };


            //let vid{$this->fileData['id']} = document.getElementById('volume4');
            //vid{$this->fileData['id']}.volume = 0.2;

        </script>
        returnFunctions;
    }

    function infoTags()
    {
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
        return rtrim($tags, ", ");
    }

    function profileEdit()
    {
        return <<< returnCode
        <button id="openSettings{$this->fileData['id']}">Edit</button>
                    <script>
                        numb = {$this->fileData['id']};
                        const openSettings{$this->fileData['id']} = document.getElementById('openSettings{$this->fileData['id']}');
    
                        openSettings{$this->fileData['id']}.addEventListener("click", function() {
                            openSettings("{$this->fileData['id']}", "{$this->fileData['title']}", "{$this->fileData['tag1']}", "{$this->fileData['tag2']}", "{$this->fileData['tag3']}", "{$this->fileData['tag4']}", "{$this->fileData['tag5']}", "{$this->fileData['description']}", "{$this->fileData['bpm']}", "{$this->fileData['key_short']}", "{$this->fileData['type']}", "{$this->fileData['monet']}", "");
                        });
                        blocker.addEventListener("click", function() {
                            closeSettings(numb);
                        });
                    </script>
        returnCode;
    }

    function getPlayerCode($purp)
    {
        $returnCode = <<< returnCode
        <!--Server: {$_SERVER['SERVER_NAME']}<br>
        Self: {$_SERVER['PHP_SELF']}-->
        <div class="songPlayer">
        <h3 class="songTitle"> {$this->fileData['title']} - by <a href="http://{$_SERVER['SERVER_NAME']}/user/{$this->fileData['user_id']}"> {$this->uploaderData['username']} </a></h3>
            <div id="songInfo{$this->fileData['id']}" class="songInfo">
                <h3>Description:</h3>
                <div>{$this->fileData['description']}</div><br>
                <div><b>{$this->fileData['bpm']} bpm, {$this->fileData['key_root']} {$this->fileData['key_add']}</b></div>
                <h3>Tags:</h3>
                <div>
                    <div>{$this->infoTags()}</div>
                </div>
            </div>
            <div class="songControls">
                <audio class="audioPlayer" id="player{$this->fileData['id']}" src="{$this->fileData['realPath']}"></audio>
                <button class="songPlayPause" id="playBtn{$this->fileData['id']}"> Play </button>
                <button class="songPlayPause hidden" id="pauseBtn{$this->fileData['id']}"> Pause </button>
                <input type="range" min="0" max="100" value="35" id="volume{$this->fileData['id']}">
                <input type="range" id="progress{$this->fileData['id']}" value="0" max="100" style="width:400px;"></input>
            </div>
            
            <button id="openInfo{$this->fileData['id']}">INFO</button>
        returnCode;
        if ($purp == 'profile') {
            $returnCode .= $this->profileEdit();
        }
        if ($this->fileData['monet'] == 1) {
            $returnCode .= "<a href=\"{$this->otherInfo['downloadLink']}\" ";
            if ($this->otherInfo['showDownload']) {
                $returnCode .= "onclick=\"addDownloadCount({$this->fileData['id']})\"";
            }
            $returnCode .= "><i class=\"fa fa-download fa-2x\"></i></a>
                <br>
                <span id='downloads{$this->fileData['id']}'>{$this->fileData['downloads']}</span> Downloads";
        } else {
            $returnCode .= "<span>Contact the Artist for access to this File!</span>";
        }
        $returnCode .=
            "</div>
            {$this->playerFunctions()}
        <br>";
        return $returnCode;
    }
}
