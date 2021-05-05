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

    function getPlayerCodeMain()
    {
        $echoTag = '';
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

        if ($this->fileData['monet'] == 1) {
            $showDownload = true;
            if (isset($_SESSION['userID'])) {
                $stmntLookForSimularDownload = $this->pdo->prepare("SELECT * FROM user_downloaded_file WHERE fk_user_id = ? AND fk_files_id = ?");
                $stmntLookForSimularDownload->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR, 5000);
                $stmntLookForSimularDownload->bindParam(2, $this->fileData['id'], PDO::PARAM_STR, 5000);
                $stmntLookForSimularDownload->execute();

                $showDownload = $stmntLookForSimularDownload->rowCount() == 0;
            }
            if (isset($_SESSION['download'][$this->fileData['id']])) {
                $showDownload = false;
            }

            $echoTag .= "<a href=\"index.php?downloaded_file={$this->fileData['path']}&username_file={$this->uploaderData['username']}&title_file={$this->fileData['title']}\" ";
            if ($showDownload) {
                $echoTag .= "onclick=\"addDownloadCount({$this->fileData['id']})\"";
            }
            $echoTag .= "><i class=\"fa fa-download fa-2x\"></i></a>
                <br>
                <span id='downloads{$this->fileData['id']}'>{$this->fileData['downloads']}</span> Downloads";
        } else {
            $echoTag .= "<span>Contact the Artist for access to this File!</span>";
        }

        $echoTag .=
            "</div>";
        // $echoTag .= " <script>
        //     const playBtn{$this->fileData['id']} = document.getElementById(\"playBtn{$this->fileData['id']}\");
        //     const pauseBtn{$this->fileData['id']} = document.getElementById(\"pauseBtn{$this->fileData['id']}\");
        //     const progress{$this->fileData['id']} = document.getElementById(\"progress{$this->fileData['id']}\");
        //     const player{$this->fileData['id']} = document.getElementById(\"player{$this->fileData['id']}\");

        //     const infoBtn{$this->fileData['id']} = document.getElementById(\"openInfo{$this->fileData['id']}\");

        //     player{$this->fileData['id']}.volume = 0.35;

        //     const volume{$this->fileData['id']} = document.getElementById(\"volume{$this->fileData['id']}\");

        //     volume{$this->fileData['id']}.addEventListener(\"change\", function(){newVolume({$this->fileData['id']});});

        //     progress{$this->fileData['id']}.addEventListener(\"change\", function(){console.log(progress{$this->fileData['id']}.value);newProgress({$this->fileData['id']});});
        //     progress{$this->fileData['id']}.addEventListener(\"mousedown\", function(){pause({$this->fileData['id']});});
        //     progress{$this->fileData['id']}.addEventListener(\"mouseup\", function(){
        //         if(playBtn{$this->fileData['id']}.classList.contains('hidden')){
        //             playTrack({$this->fileData['id']});
        //         }
        //     });

        //     playBtn{$this->fileData['id']}.addEventListener(\"click\", function(){playTrack({$this->fileData['id']});});
        //     playBtn{$this->fileData['id']}.addEventListener(\"click\", function(){togglePlayPause({$this->fileData['id']});});

        //     pauseBtn{$this->fileData['id']}.addEventListener(\"click\", function(){pause({$this->fileData['id']});});
        //     pauseBtn{$this->fileData['id']}.addEventListener(\"click\", function(){togglePlayPause({$this->fileData['id']});});

        //     infoBtn{$this->fileData['id']}.addEventListener(\"click\", function(){openInfo({$this->fileData['id']});});



        //     let testPlayer{$this->fileData['id']} = document.getElementById('player4');
        //     let testProgessBar{$this->fileData['id']} = document.getElementById('progess4');

        //     player{$this->fileData['id']}.ontimeupdate = function(){
        //         //console.log('Hallo');
        //         //console.log(testPlayer{$this->fileData['id']}.value);
        //     }


        //     player{$this->fileData['id']}.ontimeupdate = function(){
        //         progress{$this->fileData['id']}.value = player{$this->fileData['id']}.currentTime / player{$this->fileData['id']}.duration*100;
        //         if(player{$this->fileData['id']}.currentTime == player{$this->fileData['id']}.duration){
        //             if(playBtn{$this->fileData['id']}.classList.contains('hidden')){
        //                 togglePlayPause({$this->fileData['id']});
        //                 //togglePlayPause('M');
        //             }
        //         }
        //         //console.log(player{$this->fileData['id']}.currentTime);
        //     };


        //     //let vid{$this->fileData['id']} = document.getElementById('volume4');
        //     //vid{$this->fileData['id']}.volume = 0.2;

        // </script>";
        $echoTag .= "<br>";

        return $echoTag;
    }
}
