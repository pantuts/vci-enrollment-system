<?php

date_default_timezone_set( 'Asia/Singapore');
ini_set('session.cookie_httponly', true);
session_start();
ob_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ./index.php');
    ob_end_flush();
    exit();
}

require_once '../config.php';

?>

<!DOCTYPE html>   
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--[if IE]><![endif]-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <meta name="description" content="">
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content=""/>
    <title>
        Admin Panel - 
        <?php

            $sname = $_SERVER['SCRIPT_NAME'];
            if (strpos($sname, 'panel-pre-enrollees.php') || strpos($sname, 'pre-en')) {
                echo 'Pre-Enrollees';
            } else if (strpos($sname, 'enrollees.php')) {
                echo 'Enrollees';
            } else if (strpos($sname, 'calevents.php')) {
                echo 'Calendar Events';
            } else {

            }

        ?>
    </title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
    <!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"> -->
</head>
<body>

    <div class="container admin">
        
        <header style="margin:0 auto;">
           <!--  <h1><img src="./logo.png" alt="logo" ?></h1> -->
            <nav>
                <ul>
                    <li><a href="./panel-pre-enrollees.php">Pre-Enrollees</a></li>
                    <li><a href="./panel-enrollees.php">Enrollees</a></li>
                    <li><a href="./subjects.php">Subjects</a></li>
                    <li><a href="./calevents.php">Calendar Events</a></li>
                </ul>
            </nav>
        </header>