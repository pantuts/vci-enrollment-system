<?php 

ini_set('session.cookie_httponly', true);
session_start();
ob_start();

require_once '../header.php';

?>

<div class="forg">
    <form method="post">
        <p>
            <label>Please enter your email address: </label>
            <input type="text" name="email" maxlength="100" >
        </p>
        <p>
            <input type="submit" name="submit" value="Submit">
        </p>
    </form>
</div>

<?php

require_once '../footer.php';
require_once '../config.php';

if (isset($_POST['submit'])) {
    if (!isset($_POST['email']) || $_POST['email'] == '') {
        echo '<script>alert("Where\'s your email address dumbhead?")</script>';
        exit();
    } else {
        $email = htmlentities($_POST['email']);
        $secret = md5('$ecret');
        $sql = 'select * from student where email=:em';
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute(array(':em' => $email));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        if ($row !== FALSE) {
            header('Location: ./reset-password.php?id=' . $secret . '&email=' . rawurlencode($email));
            ob_end_flush();
        } else {
            echo '<script>alert("You are not one of our registrants. Backoff!")</script>';
            exit();
        }
        $stmt->closeCursor();
        $pdo = null;
    }
}

?>