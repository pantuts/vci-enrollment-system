<?php

ini_set('session.cookie_httponly', true);
session_start();
ob_start();

// header
require_once '../header.php';

// if already logged in redirect to dashboard
if (isset($_SESSION['id'])) {
    header('Location: ./dashboard.php');
    ob_end_flush();
}

?>

<!-- confirmation process -->
<?php

$hash = htmlentities($_GET['id']);
// check if hash format is correct
if (strlen($hash) > 32 || strlen($hash) < 32) {
    // echo '<script>alert("Where did you get that link? Wrong!");</script>';
    echo 'Incorrect confirmation link!';
    require_once '../footer.php';
    exit();
} else {
    // config
    require_once '../config.php';

    $sql = 'select id, studnum, email, confirmed from student where hash=:hash';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':hash', $hash);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $row['id'];
    $studnum = $row['studnum'];
    $email = $row['email'];

    if ($id != null) {

        // if already confirmed
        if ($row['confirmed'] == 1) {
            echo 'Account already confirmed.';
            echo '<br/><a href="./register-login.php">Login here.</a>';
            $stmt->closeCursor();
            $pdo = null;
        } else {

            $sql = 'update student set confirmed=1 where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // send email for their student number
            // $headers  = 'MIME-Version: 1.0' . "\r\n";
            // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // $headers .= 'To: ' . $email . "\r\n";
            // $headers .= 'X-Mailer: PHP v' . phpversion();
            // $headers .= 'X-Originating-IP: ' . $_SERVER['SERVER_ADDR'];

            // $message = 'Here is a copy of your serial/student-number login. Thank you.\n';

            // if (mail($email, 'Login details', $message, $headers)) {
            //     echo 'Account confirmed, you can now login with your student number <b>' . $studnum . '</b> and your chosen password. Please save your login details.';
            // } else {
            //     echo 'Mailing error, retry.';
            //     exit;
            // }
            echo 'Account confirmed, you can now login with your student number <b>' . $studnum . '</b> and your chosen password. Please save your login details.';
            $stmt->closeCursor();
            $pdo = null;
        }
    } else {
        echo 'No record found. Try harder!';
        $stmt->closeCursor();
        $pdo = null;
    }
}

?>

<?php

// footer
require_once '../footer.php';

?>