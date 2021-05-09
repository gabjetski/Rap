<?php

// set filename of downloaded file
// echo 'LOL<br>' . $_SERVER['PHP_SELF'] . '<br>';
$currRealLocation = $_SERVER['PHP_SELF'];
$currDephts = explode('/', $currRealLocation);
// echo sizeof($currDephts);
// echo "<br>";
$filename = $_GET['downloaded_file'];
// echo $_GET['downloaded_file'];
// $filepath = 'uploads/' . $filename;
$filepath = "";
for ($i = 0; $i < sizeof($currDephts) - 2; $i++) {
    $filepath .= "../";
}
$filepath .= 'uploads/' . $filename;

//check if file exists
// echo "<hr>";
// var_dump($filepath);
// echo "<br>";
// var_dump(file_exists($filepath));
// echo "<hr>";
if (file_exists($filepath)) {

    //sets the header to download file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    //sets the name as which the file will be downloaded
    header('Content-Disposition: attachment; filename="' . $_GET['username_file'] . '-' . $_GET['title_file'] . '.mp3"');
    //header('Content-Disposition: attachment; filename=' . basename($filepath));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    //download file
    readfile($filepath);

    //get id of file out of filename (2#abcde)
    $arr = explode("#", $_GET['downloaded_file'], 2);
    $fileID = $arr[0];

    //check if this file waS already downloaded in this session
    if (!isset($_SESSION['download'][$fileID])) {
        // FIXME Abbruch zählt auch
        //call download procedure
        $stmtAddDownload = $pdo->prepare("CALL download(?, ?, @id)");
        //define the in-parameters
        $stmtAddDownload->bindParam(1, $fileID, PDO::PARAM_STR, 5000);
        //if guest downloads, set user id to 1 (which is guest id)
        if (!isset($_SESSION['userID'])) {
            $userID = 1;
        } else {
            $userID = $_SESSION['userID'];
        }
        $stmtAddDownload->bindParam(2, $userID, PDO::PARAM_STR, 4000);
        //execute stmnt
        $stmtAddDownload->execute();

        //select id of download
        $sql = "SELECT @id AS id";
        $stmtGetId = $pdo->prepare($sql);
        $stmtGetId->execute();
        foreach ($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $id = $row['id'];
        }

        //if download throws error, store it in Session and reload page
        if ($id < 0) {
            $_SESSION['downloadError'] = $id;
            $_SESSION['downloadError_GET'] = $_GET;
            header('Location:index.php');
        }
        //else store download in session and reload page
        else {
            $_SESSION['download'][$fileID] = true;
            $_SESSION['downloadSuccess'] = $fileID;
            unset($_SESSION['downloadError']);
            header('Location:index.php');
        }
    } else {
    }
} else {
}
