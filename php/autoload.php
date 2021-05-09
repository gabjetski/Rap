<?php
require_once 'feedEntry.php';
require_once 'permissions.php';
$pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');

if (!isset($_SESSION['userID'])) {
    $_SESSION['userID'] = 1;
}
// echo "yes1";
if (isset($_GET['downloaded_file'])) {
    // echo "yes2";
    require "download.php";
}
