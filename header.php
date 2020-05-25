<?php

date_default_timezone_set( 'Asia/Singapore');

// check whether the script is in root directory
if (dirname($_SERVER['PHP_SELF']) == '/vci') {
    $rootfolder = './';
} else {
    $rootfolder = '../';
}

$root = $_SERVER['HTTP_HOST'] . '/vci/';

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
    <title>Veritas College of Irosin</title>
    <link rel="stylesheet" href="<?php echo $rootfolder; ?>styles/normalize.css">
    <link rel="stylesheet" href="<?php echo $rootfolder; ?>styles/styles.css">
    <link rel="stylesheet" href="<?php echo $rootfolder; ?>styles/jquery-ui-1.10.3.css">
    <link rel="stylesheet" href="<?php echo $rootfolder; ?>styles/jquery.custom-scrollbar.css">
    <link rel="shortcut icon" type="icon" href="<?php echo $rootfolder; ?>images/favicon.png">
    <script src="<?php echo $rootfolder; ?>scripts/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" href="<?php echo $rootfolder; ?>scripts/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?php echo $rootfolder; ?>scripts/fancybox/jquery.fancybox.pack.js"></script>

    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

    <!-- CONTAINER  -->
    <div class="container">

        <header>
            <!-- banners, menu -->
            <h1><img src="<?php echo $rootfolder; ?>images/banner.png"></h1>

            <!-- menu -->
            <div class="menu rounded">
                <ul>
                    <li><a href="<?php echo $rootfolder . 'index.php';  ?>" title="">Home</a></li>
                    <li class="about">
                        <a href="<?php echo $rootfolder . 'about/history.php';  ?>" title="">About Us</a>
                        <!-- <ul class="dropdown">
                            <li><a href="" title="">Message</a></li>
                            <li><a href="" title="">Faculty and Staff</a></li>
                            <li><a href="" title="">History</a></li>
                            <li><a href="" title="">Facilities</a></li>
                        </ul> -->
                    </li>
                    <li><a href="<?php echo $rootfolder . 'admission.php';  ?>" title="">Admission</a></li>
                    <li><a href="<?php echo $rootfolder . 'courses.php';  ?>" title="">Courses</a></li>
                    <li><a href="<?php echo $rootfolder . 'gallery.php';  ?>" title="">Veritans</a></li>
                    <li><a href="<?php echo $rootfolder . 'student/register-login.php';  ?>" title="">Online Registration</a></li>
                </ul>
            </div>
            <!-- end menu -->

        </header>