<?php
//require the classes we need in many files
require_once 'feedEntry.php';
require_once 'permissions.php';

//setup connection to database
$pdo = new PDO('mysql:host=localhost;dbname=rap', 'root', '');

//if visitor is guest, set userID to 1 (important for permissions)
if (!isset($_SESSION['userID'])) {
    $_SESSION['userID'] = 1;
}

//if visitor downloaded a file, include downloadphp
if (isset($_GET['downloaded_file'])) {
    require "download.php";
}

//if user edited tracks, include editTracks.php 
//  this needs to be in autoload because admin can do it on 'every' page
if (isset($_GET['tset-submit'])) {
    require 'editTracks.php';
}

//if user edited tracks, and error is thrown, include editError.php 
if (isset($_SESSION['trackEdit-error'])) {
    require 'editError.php';
}

//if user deleted a track, include deleteTracks.php 
if (isset($_GET['tset-del'])) {
    require 'deleteTracks.php';
}
//function to htmlspecialchar arrays (in combination with array_walk_recursive)
// function filter(&$value)
// {
//     $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
// }
/*
// WAS DAS, wegen dem konnte man nt zu den einzelnen bereichen wie settings, ... habens mal 
auskommentiert*/