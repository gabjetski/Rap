<?php
// TODO Comment code
$filename = $_GET['downloaded_file'];
$filepath = 'uploads/' . $filename;
//var_dump($filepath);

if (file_exists($filepath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$_GET['username_file'].'-'.$_GET['title_file'].'.mp3"');
    //header('Content-Disposition: attachment; filename=' . basename($filepath));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('uploads/' . $filename));
    readfile('uploads/' . $filename);

    // Now update downloads count
    /*$newCount = $file['downloads'] + 1;
    $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
    mysqli_query($conn, $updateQuery);
    exit;
    */
    $arr = explode("%23", $_GET['downloaded_file'], 2);
    $fileID = $arr[0];
    //echo $fileID;

    if (!isset($_SESSION['download'][$fileID])) {
        // FIXME Abbruch zählt auch
        $stmtAddDownload = $pdo->prepare("CALL download(?, ?, @id)");
        //define the in-parameters
        $stmtAddDownload->bindParam(1, $fileID, PDO::PARAM_STR, 5000);
        if (!isset($_SESSION['userID'])) {
            $userID = 1;
        }else {
            $userID = $_SESSION['userID'];
        }
        $stmtAddDownload->bindParam(2, $userID, PDO::PARAM_STR, 4000);
        $stmtAddDownload->execute();

        $sql = "SELECT @id AS id";
        $stmtGetId = $pdo->prepare($sql);
        $stmtGetId->execute();
        foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
            $id = $row['id'];
        }

        if ($id < 0) {
            $_SESSION['downloadError'] = $id;
            $_SESSION['downloadError_GET'] = $_GET;
            header('Location:index.php');
        }
        //else log in
        else{
            $_SESSION['download'][$fileID] = true;
            unset($_SESSION['downloadError']);
            header('Location:index.php');
        }
        echo "Download";
    }else {
        
    }
}else{
    echo "Nope";
}
