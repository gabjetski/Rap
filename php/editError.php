<?php
//-------select which error if login --------------------------------


$stmntGetTrackDetails = $pdo->prepare("SELECT * FROM files WHERE pk_files_id = ?");
$stmntGetTrackDetails->bindParam(1, $_SESSION['trackEdit-error']['get']['tset-track-id'], PDO::PARAM_INT);
$stmntGetTrackDetails->execute();

foreach ($stmntGetTrackDetails->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $monet = $row['fk_monet_id'];
}
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

$id = $_SESSION['trackEdit-error']['get']['tset-track-id'];
$title = $_SESSION['trackEdit-error']['get']['tset-title'];

$tagsSplitted = explode(",", $_SESSION['trackEdit-error']['get']['tset-tags']);

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


//    function openSettings(id, title, tag1, tag2, tag3, tag4, tag5, desc, bpm, key_short, typeID, monetID, error) {

?>
<script type="text/javascript">
    //funtion triggered onload
    window.onload = function() {
        //store values from php array into js array
        //openSettings(id, title, tag1, tag2, tag3, tag4, tag5, desc, bpm, key_short, typeID, monetID, error)
        openSettings("<?php echo $id . '", "' . $title . '", "' . $tag1 . '", "' . $tag2 . '", "' . $tag3 . '", "' . $tag4 . '", "' . $tag5 . '", "' . $desc . '", "' . $bpm . '", "' . $key . '", "' . $type . '", "' . $monet . '", "' . $_SESSION['trackEdit-error']['id']; ?>");

    };
</script>