<?php
// select all songs which schould be displayed
$stmntGetSongs = $pdo->prepare('SELECT * FROM files INNER JOIN user ON user.pk_user_id = files.fk_user_id'); // TODO Inner join mit feed, das nur Files auusm Feed gezeigt werden
$stmntGetSongs->execute();

//fetch the results
foreach ($stmntGetSongs->fetchAll(PDO::FETCH_ASSOC) as $row){
    //set the path of the file
    $path = str_replace('#','%23',$row['Path']);
    //select count of downloads for that file
    $stmntGetDownloads = $pdo->prepare('SELECT * FROM user_downloaded_file WHERE fk_files_id = ?;');
    $stmntGetDownloads->bindParam(1, $row['pk_files_id'], PDO::PARAM_STR, 5000);
    $stmntGetDownloads->execute();
    $downloadsCount = $stmntGetDownloads->rowCount();
    //html code for file - Media Player and Download link
    // TODO add Elias Media Player
    echo "<div id='track{$row['pk_files_id']}'>
        {$path}<br>
        {$row['Title']} - by {$row['Username']}<br>
        <audio controls>
            <source src=\"./uploads/{$path}\" type=\"audio/mpeg\">
            Your browser does not support the audio element.
        </audio>
        <a href=\"index.php?downloaded_file={$path}&username_file={$row['Username']}&title_file={$row['Title']}\" onclick=\"addDownloadCount({$row['pk_files_id']})\">Download</a> 
        <span id='downloads{$row['pk_files_id']}'>{$downloadsCount}</span> Downloads
        <hr>
    </div>";
    echo "<br>";
}
