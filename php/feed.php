<?php
$stmntGetSongs = $pdo->prepare('SELECT * FROM files INNER JOIN user ON user.pk_user_id = files.fk_user_id'); // TODO Inner join mit feed, das nur Files auusm Feed gezeigt werden
$stmntGetSongs->execute();

foreach ($stmntGetSongs->fetchAll(PDO::FETCH_ASSOC) as $row){
    $path = str_replace('#','%23',$row['Path']);
    $stmntGetDownloads = $pdo->prepare('SELECT * FROM user_downloaded_file WHERE fk_files_id = ?;');
    $stmntGetDownloads->bindParam(1, $row['pk_files_id'], PDO::PARAM_STR, 5000);
    $stmntGetDownloads->execute();
    $downloadsCount = $stmntGetDownloads->rowCount();
    var_dump($downloadsCount);
    echo $row['pk_files_id'];
    /*echo "<div>
        {$path}<br>
        {$row['Title']} - by {$row['Username']}<br>
        <audio controls>
            <source src=\"/uploads/{$path}\" type=\"audio/mpeg\">
            Your browser does not support the audio element.
        </audio>
        <a href=\"index.php?downloaded_file={$path}&username_file={$row['Username']}&title_file={$row['Title']}\">Download</a> 
        <form action=".htmlspecialchars($_SERVER["PHP_SELF"])." method='get' class='form-container'>
        <input type='hidden' name='downloaded_file' value='{$path}' />
        <input type='hidden' name='username_file' value='{$row['Username']}' />
        <input type='hidden' name='title_file' value='{$row['Title']}' />
      <input type='submit' value='Download' name='download_file'>
        </form>
        {$downloadsCount} Downloads
        <hr>
    </div>";*/
    echo "<div>
        {$path}<br>
        {$row['Title']} - by {$row['Username']}<br>
        <audio controls>
            <source src=\"/uploads/{$path}\" type=\"audio/mpeg\">
            Your browser does not support the audio element.
        </audio>
        <a href=\"index.php?downloaded_file={$path}&username_file={$row['Username']}&title_file={$row['Title']}\">Download</a> 
        {$downloadsCount} Downloads
        <hr>
    </div>";
    echo "<br>";
}
