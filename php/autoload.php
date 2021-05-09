<?php
require_once 'feedEntry.php';
require_once 'permissions.php';
$pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');
$userPerm = new Permissions;

if (!isset($_SESSION['userID'])) {
    $_SESSION['userID'] = 1;
}
// echo "yes1";
if (isset($_GET['downloaded_file'])) {
    // echo "yes2";
    require "download.php";
}

if (isset($_GET['tset-submit'])) {
    require 'editTracks.php';
    //unset($_SESSION['trackEdit-error']);
}
if (isset($_SESSION['trackEdit-error'])) {
    require 'editError.php';
    //unset($_SESSION['trackEdit-error']);
}
if (isset($_GET['tset-del'])) {
    require 'deleteTracks.php';
}
