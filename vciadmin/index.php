<?php

date_default_timezone_set( 'Asia/Singapore');
ini_set('session.cookie_httponly', true);
session_start();
ob_start();

if (isset($_SESSION['admin'])) {
    header('Location: ./panel-pre-enrollees.php');
    ob_end_flush();
}

?><!DOCTYPE html>   
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/styles.css">
    <!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"> -->
    <!-- <link rel="shortcut icon" type="icon" href="images/favicon.png"> -->
</head>
<body>

    <div class="container">
        
        <!-- <header>
            <h1><img src="./logo.png" alt="logo"></h1>
        </header> -->

        <article  style="margin:50px auto;width:300px;">

            <p style=>Admin Login</p>
            <br/>

            <form class="login" method="post">
                <p>
                    Username: <br/><input class="text" type="text" name="username" maxlength="15" />
                </p>
                <p>
                    Password: <br/><input class="text" type="password" name="password" maxlength="32" />
                </p>
                <p>
                    <input type="submit" name="submit" id="submit" value="Login" />
                </p>
            </form>

        </article>


        <footer>
            
        </footer>

    </div>

</body>
</html>

<?php

if (isset($_POST['submit'])) {

    $uname = htmlentities($_POST['username']);
    $pass = htmlentities($_POST['password']);

    if (isset($uname) && isset($pass)) {

        require_once '../config.php';
        require_once '../functions.php';

        $password = hashPassword($pass);

        $sql = 'select id from admin where username=:u and password=:p';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
                ':u' => $uname,
                ':p' => $password
            ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $_SESSION['admin'] = md5('PANTUTS');
            header('Location: ./panel-pre-enrollees.php');
            ob_end_flush();
        } else {
            echo '<script>alert("HAHA!");</script>';
            exit();
        }

    } else {
        echo '<script>alert("Please review your input.");</script>';
        exit();
    }

}

?>