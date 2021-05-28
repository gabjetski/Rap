<?php
//select monetid of track
$stmntGetTrackMonet = $pdo->prepare("SELECT * FROM files WHERE pk_files_id = ?");
$stmntGetTrackMonet->bindParam(1, $_SESSION['trackEdit-error']['get']['tset-track-id'], PDO::PARAM_INT);
$stmntGetTrackMonet->execute();
//set monet id
foreach ($stmntGetTrackMonet->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $monet = $row['fk_monet_id'];
}
//set number of typeid
switch ($_SESSION['trackEdit-error']['get']['tset-type']) {
    case 'beat':
        $type = 1;
        break;
    case 'sample':
        $type = 2;
        break;
    case 'snippet':
        $type = 3;
        break;
}
//store important values in short vars
$id = $_SESSION['trackEdit-error']['get']['tset-track-id'];
$title = $_SESSION['trackEdit-error']['get']['tset-title'];

$tagsSplitted = explode(",", $_SESSION['trackEdit-error']['get']['tset-tags']);
//split tags and store them seperately
for ($i = 0; $i < 5; $i++) {
    if (!isset($tagsSplitted[$i])) {
        $tagsSplitted[$i] = '';
    }
}
$tag1 = $tagsSplitted[0];
$tag2 = $tagsSplitted[1];
$tag3 = $tagsSplitted[2];
$tag4 = $tagsSplitted[3];
$tag5 = $tagsSplitted[4];

$desc = $_SESSION['trackEdit-error']['get']['tset-desc'];
$bpm = $_SESSION['trackEdit-error']['get']['tset-bpm'];
$key = $_SESSION['trackEdit-error']['get']['tset-key'];


?>
<script type="text/javascript">
    //funtion triggered onload
    window.onload = function() {
        //call function to open edit forms, with given data
        openSettings("<?php echo $id . '", "' . $title . '", "' . $tag1 . '", "' . $tag2 . '", "' . $tag3 . '", "' . $tag4 . '", "' . $tag5 . '", "' . $desc . '", "' . $bpm . '", "' . $key . '", "' . $type . '", "' . $monet . '", "' . $_SESSION['trackEdit-error']['id']; ?>");

    };
</script>