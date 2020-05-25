<?php 

ini_set('session.cookie_httponly', true);
session_start();
ob_start();

require_once '../header.php';

// check if secret and email not set
if (!isset($_GET['email']) || !isset($_GET['id'])) {
    header('Location: ./register-login.php');
    ob_end_flush();
}
// check if id = our secret
if ($_GET['id'] != md5('$ecret')) {
    header('Location: ./register-login.php');
    ob_end_flush();
}

$email = htmlentities(rawurldecode($_GET['email']));

?>

<div class="forg resetpass">
    <form method="post">
        <p>
            <label>Password: </label>
            <input type="password" maxlength="200" name="password1" />
        </p>
        <p>
            <label>Retype Password: </label>
            <input type="password" maxlength="200" name="password2" />
        </p>
        <p>
            <input type="submit" name="submit" value="Submit" />
        </p>
    </form>
</div>

<?php

require_once '../config.php';
require_once '../functions.php';

if (isset($_POST['submit'])) {
    if ($_POST['password1'] == '' || $_POST['password2'] == '') {
        echo '<script>alert("Come on, your password?")</script>';
        exit();
    } else {
        $pass1 = htmlentities($_POST['password1']);
        $pass2 = htmlentities($_POST['password2']);
        if ($pass1 != $pass2) {
            echo '<script>alert("Passwords do not match!")</script>';
            exit();
        } else {
            $password = hashPassword($pass1);
            $sql = 'update student set password=:p where email=:em';
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute(array(':em' => $email, ':p' => $password));
                echo 'Password updated. You may now go to login page. Thank you.';
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $stmt->closeCursor();
            $pdo = null;
        }
    }
}

require_once '../footer.php';

?>