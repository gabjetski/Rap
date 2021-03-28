<?php
var_dump($_GET);
$filename = $_GET['downloaded_file'];
//$filename = str_replace('%23','#',$filename);
$filepath = '/uploads/' . $filename;
echo $filepath;

if (file_exists($filepath)) {
    /*header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$_GET['username_file'].'-'.$_GET['title_file'].'.mp3"');
    //header('Content-Disposition: attachment; filename=' . basename($filepath));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('uploads/' . $filename));
    readfile('uploads/' . $filename);*/

    // Now update downloads count
    /*$newCount = $file['downloads'] + 1;
    $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
    mysqli_query($conn, $updateQuery);
    exit;
    */

    $arr = explode("%23", $_GET['downloaded_file'], 2);
    $fileID = $arr[0];
    echo $fileID;
    echo "<br>s<br>";

    $stmtAddDownload = $pdo->prepare("CALL download(?, ?, @id)");
    echo "<br>d<br>";
    //define the in-parameters
    $stmtAddDownload->bindParam(1, $fileID, PDO::PARAM_STR, 5000);
    echo "<br>f<br>";
    $stmtAddDownload->bindParam(2, $_SESSION['userID'], PDO::PARAM_STR, 4000);
    echo "<br>x<br>";
    $stmtAddDownload->execute();
    echo "<br>a<br>";

    $sql = "SELECT @id AS id";
    $stmtGetId = $pdo->prepare($sql);
    $stmtGetId->execute();
    echo "<br>b<br>";
    foreach($stmtGetId->fetchAll(PDO::FETCH_ASSOC) as $row){
        $id = $row['id'];
        echo "<br>x<br>";
    }
    echo "<br>a<br>".$id;

if ($id < 0) {
    $_SESSION['downloadError'] = $id;
    //header('Location:index.php');
}
//else log in
else{
    $_SESSION['userID'] = $id;
    unset($_SESSION['downloadError']);
    //header('Location:index.php');
}
}
else {
    echo "<br><br>Gibts jo ned!<br><br>";
}
