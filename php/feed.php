<?php
$stmntGetSongs = $pdo->prepare('SELECT * FROM files INNER JOIN user ON user.pk_user_id = files.fk_user_id'); // TODO Inner join mit feed, das nur Files auusm Feed gezeigt werden
$stmntGetSongs->execute();

foreach ($stmntGetSongs->fetchAll(PDO::FETCH_ASSOC) as $row){
    echo "<div>
        {$row['Title']} - by {$row['Username']}<br>
        <audio controls>
            <source src=\"uploads/{$row['Path']}\" type=\"audio/mpeg\">
            Your browser does not support the audio element.
        </audio> 
        <hr>
    </div>";
    echo "<br>";
}