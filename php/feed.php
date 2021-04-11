<?php
//TODO Comment Code
echo "<script>
        function togglePlayPause(id){
            eval('playBtn'+id).classList.toggle(\"hidden\");
            eval('pauseBtn'+id).classList.toggle(\"hidden\"); 
                //window['pauseBtn'+id].classList.toggle(\"hidden\"); 
            //console.log('eeeee');
        }

        function playTrack(id){
                //window['player'+id].play();
            const allPlayer = document.getElementsByClassName('audioPlayer')
            console.log(allPlayer);
            for(let i = 0; i<allPlayer.length; i++){
                if(allPlayer[i].paused == false){
                    console.log('false: '+i)
                    togglePlayPause(allPlayer.length-i);
                }
                console.log(allPlayer[i].paused);
                allPlayer[i].pause();
            }
            //allPlayer.foreach(element => element.pause());        
            eval('player'+id).play();  
        }

        function pause(id){
            eval('player'+id).pause();
                //window['player'+id].pause();
        }

        function newVolume(id){
            eval('player'+id).volume = eval('volume'+id).value/100;;
                //window['player'+id].volume = window['volume'+id].value/100;
        }

        function newProgress(id){
            eval('player'+id).currentTime = eval('progress'+id).value * eval('player'+id).duration/100;
                //window['player'+id].volume = window['volume'+id].value/100;
        }

        function openInfo(id){
            eval('songInfo'+id).display = block;
        }
    </script>";
// select all songs which schould be displayed
$stmntGetSongs = $pdo->prepare('SELECT * FROM files INNER JOIN user ON user.pk_user_id = files.fk_user_id ORDER BY pk_files_id DESC'); // TODO Inner join mit feed, das nur Files auusm Feed gezeigt werden
$stmntGetSongs->execute();
//fetch the results
if ($stmntGetSongs->rowCount() == 0) {
    echo "Looks like you are the first person here. Feel free to upload and present your work to the world :)";
}
foreach ($stmntGetSongs->fetchAll(PDO::FETCH_ASSOC) as $row){
    //set the path of the file
    $path = str_replace('#','%23',$row['Path']);
    //select count of downloads for that file
    $stmntGetDownloads = $pdo->prepare('SELECT * FROM user_downloaded_file WHERE fk_files_id = ?;');
    $stmntGetDownloads->bindParam(1, $row['pk_files_id'], PDO::PARAM_STR, 5000);
    $stmntGetDownloads->execute();
    $downloadsCount = $stmntGetDownloads->rowCount();

    echo "
    <div class=\"songPlayer\">
    <div class=\"songTitle\"> {$row['Title']} - by {$row['Username']} </div>
        <div class=\"songControls\">
            <audio class=\"audioPlayer\" id=\"player{$row['pk_files_id']}\" src=\"./uploads/{$path}\"></audio>
            <button class=\"songPlayPause\" id=\"playBtn{$row['pk_files_id']}\"> Play </button>
            <button class=\"songPlayPause hidden\" id=\"pauseBtn{$row['pk_files_id']}\"> Pause </button>
            <input type=\"range\" min=\"0\" max=\"20\" value=\"10\" id=\"volume{$row['pk_files_id']}\">
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

        if($row['fk_monet_id'] == 1){
            $showDownload = true;
            if (isset($_SESSION['userID'])) {
                $stmntLookForSimularDownload = $pdo->prepare("SELECT * FROM user_downloaded_file WHERE fk_user_id = ? AND fk_files_id = ?");
                $stmntLookForSimularDownload->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR, 5000);
                $stmntLookForSimularDownload->bindParam(2, $row['pk_files_id'], PDO::PARAM_STR, 5000);
                $stmntLookForSimularDownload->execute();
                
                $showDownload = $stmntLookForSimularDownload->rowCount() == 0;
            }
            if(isset($_SESSION['download'][$row['pk_files_id']])){
                $showDownload = false;
            }

            echo "<a href=\"index.php?downloaded_file={$path}&username_file={$row['Username']}&title_file={$row['Title']}\" ";
            if ($showDownload) {
                echo "onclick=\"addDownloadCount({$row['pk_files_id']})\"";
            }
            echo"><i class=\"fa fa-download fa-2x\"></i></a>
                <br>
                <span id='downloads{$row['pk_files_id']}'>{$downloadsCount}</span> Downloads"; 
        }
        else {
            echo "<span>Contact the Artist for access to this File!</span>"; 
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

        player{$row['pk_files_id']}.volume = 0.5;

        const volume{$row['pk_files_id']} = document.getElementById(\"volume{$row['pk_files_id']}\");

        volume{$row['pk_files_id']}.addEventListener(\"change\", function(){newVolume({$row['pk_files_id']});});
        
        progress{$row['pk_files_id']}.addEventListener(\"change\", function(){newProgress({$row['pk_files_id']});});
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
            console.log('Hallo');
            //console.log(testPlayer{$row['pk_files_id']}.value);
        }


        player{$row['pk_files_id']}.ontimeupdate = function(){
            progress{$row['pk_files_id']}.value = player{$row['pk_files_id']}.currentTime / player{$row['pk_files_id']}.duration*100;
            if(player{$row['pk_files_id']}.currentTime == player{$row['pk_files_id']}.duration){
                if(playBtn{$row['pk_files_id']}.classList.contains('hidden')){
                    togglePlayPause({$row['pk_files_id']});
                    //console.log('yeet');
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
<div class="mainPlayer">
    <button class="songPlayPause" id="playBtnM"> Play </button>
    <button class="songPlayPause hidden" id="pauseBtnM"> Pause </button>
    <input type="range" min="0" max="20" value="10" id="volumeM">
    <input type="range" id="progressM" value="0" max="100" style="width:400px;"></input>
        
</div>
