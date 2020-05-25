<?php

ini_set('session.cookie_httponly', true);
session_start();
ob_start();

// if (!isset($_SESSION['profile'])) {
//     //ob_end_flush();
//     header('Location: ./dashboard-course.php');
//     ob_end_flush();
//     exit();
// }

// check if not pre-registered
require_once '../config.php';
$studnum = htmlentities($_SESSION['id']);
// $course = htmlentities($_SESSION['course_title']);
// $year = htmlentities($_SESSION['course_year']);
// $sem = htmlentities($_SESSION['course_year_sem']);

$sql = 'select studnum, evaluated, course, year, sem, evaltime from registers where studnum=:studnum';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':studnum', $studnum);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
// if course still not chosen
if ($row === FALSE) {
    header('Location: ./dashboard-course.php');
    ob_end_flush();
} else {
    $evalnum = $row['evaluated'];
    $regtime = $row['evaltime'];
    $course = $row['course'];
    $year = $row['year'];
    $sem = $row['sem'];
}
$stmt->closeCursor();

// header
require_once '../header.php';

// $tnow = new DateTime('@' . time());
// // echo '<pre>';
// // var_dump($tnow);
// // echo '</pre>';
// echo $tnow->date;

?>

<article class="body stuprof">

    <!-- logout -->
    <div class="logout">
        <form action="" method="post">
            <p>
                <input type="submit" name="logout" value="Logout?" />
            </p>
        </form>
    </div>

    <div class="vform">
        
        <!-- <ul class="rowtitle cour">
            <li class="code fcode">Eng+</li>
            <li class="desc">English</li>
            <li class="units">3</li>
            <li class="time">rwerwr</li>
            <li class="room">56</li>
        </ul>
        <ul class="rowtitle cour">
            <li class="code fcode">Eng+</li>
            <li class="desc">English</li>
            <li class="units">3</li>
            <li class="time">rwerwr</li>
            <li class="room">56</li>
        </ul> -->

        <!-- <span class="sign">Signature: ________________________________________________________</span> -->

        <?php

        // check if enrolled
        if ($evalnum == 0) {
            $evalnum = $evalnum;

            echo '<div class="vleft">';
            echo '<p>';
            echo 'VERITAS COLLEGE OF IROSIN (FORM 1)';
            echo '</p>';
            echo '<p>';
            echo 'PRE-REGISTRATION COPY';
            echo '</p>';
            echo '</div>';
            echo '<div class="vright vvr">';
            echo '<p>Date: <span class="val">2013-03-15</span></p>';
            echo '<p>S.Y.: <span class="val">2013-2014</span></p>';
            echo '</div>';
            echo '<hr>';
            echo '<div class="vleft vl">';
            echo '<p>';
            echo 'Student VCI-ID: <span class="val">' . $studnum . '</span>';
            echo '</p>';
            echo '<p>';

            switch ($course) {

                case 'bsit':
                    $course_title = 'BS Information Technology';
                    break;

                case 'bscs':
                    $course_title = 'BS Computer Science';
                    break;

                case 'bscrim';
                    $course_title = 'BS Criminology';
                    break;

                case 'bsba';
                    $course_title = 'BS Business Administration';
                    break;
                
                default:
                    break;
            }

            echo 'Course and Major: <span class="val">' . $course_title . '</span>';
            echo '</p>';
            echo '</div>';
            echo '<div class="vright vr">';
               
            $sql = 'select given_name, family_name, middle_name from profiles where studnum=:sn';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':sn' => $studnum));
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            echo '<p>Name: <span class="val">';
            echo ucwords($row->given_name) . ' ' .ucwords($row->middle_name) . ' ' .ucwords($row->family_name);

            $stmt->closeCursor();
                    
            echo '</span>';
            echo '</p>';
            echo '<p>Year and Sem: <span class="val">';
               
            switch ($year) {
                case 1:
                    $yearc = '1st Year';
                    break;
                case 2:
                    $yearc = '2nd Year';
                    break;
                case 3:
                    $yearc = '3rd Year';
                    break;
                case 4:
                    $yearc = '4th Year';
                    break;
                default:
                    echo 'Wrong year!';
                    exit();
                    break;
            }
            switch ($sem) {
                case 1:
                    $semc = '1st Sem';
                    break;
                case 2:
                    $semc = '2nd Sem';
                default:
                    # code...
                    break;
            }

            echo $yearc . ' / ' . $semc;
                
            echo '</span>';
            echo '</p>';
            echo '</div>';

            echo '<ul class="rowtitle rtitle">';
            echo '<li class="code">Code</li>';
            echo '<li class="desc">Description</li>';
            echo '<li class="units">Units</li>';
            echo '<li class="time">Time</li>';
            echo '<li class="room">Room</li>';
            echo '</ul>';
            
            $sql = 'select code, description, units, time, room from ' . $course . ' where studyear=:y and semester=:s';
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute(array(':y' => $year, ':s' => $sem));
                // $row = $stmt->fetch(PDO::FETCH_OBJ);
                // var_dump($row);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                echo '<ul class="rowtitle cour">';
                echo '<li class="code fcode">' . $row->code . '</li>';
                echo '<li class="desc">' . ucwords($row->description) . '</li>';
                echo '<li class="units">' . $row->units . '</li>';
                echo '<li class="time">' . strtoupper($row->time) . '</li>';
                echo '<li class="room">' . strtoupper($row->room) . '</li>';
                echo '</ul>';
            }
            $stmt->closeCursor();
            $pdo = null;
            echo '<span class="sign">Signature: ________________________________________________________</span>';
            // echo '<p class="reminder">You must go to registrar\'s office. ';
            // $now = new DateTime('@' . time());
            // $ago = new DateTime('@' . $regtime);
            // $remtime = $now->diff($ago);
            // $remd = 10-$remtime->days;
            // echo 'Remaining days for evaluation: ' . $remd . '</p>';
            // echo '<span class="topdf">View and Download Form</span>';

            // form from VCI enrollment
        } else {
            // for enrolled registrants
            //echo '<div class="topdf">';

            $sql = 'select profiles.given_name, profiles.family_name, registers.year, registers.sem from profiles, registers where profiles.studnum=registers.studnum and profiles.studnum=:sn';
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute(array(':sn' => $studnum));
                $row = $stmt->fetch(PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            switch ($row->year) {
                case 1:
                    $yr = '1st Year';
                    break;
                case 2:
                    $yr = '2nd Year';
                    break;
                case 3:
                    $yr = '3rd Year';
                    break;
                case 4:
                    $yr = '4th Year';
                    break;
                default:
                    break;
            }

            echo '<p class="name">Welcome <b>' . ucwords($row->given_name) . ' ' . ucwords($row->family_name) . '</b> ' . '( ' . strtoupper($course) . ':' . $yr . ' ). Your current enrolled subjects are listed below. Thank you.</p>';
            echo '<ul class="rowtitle rtitle">';
            echo '<li class="code">Code</li>';
            echo '<li class="desc">Description</li>';
            echo '<li class="units">Units</li>';
            echo '<li class="time">Time</li>';
            echo '<li class="room">Room</li>';
            echo '</ul>';
            $stmt->closeCursor();

            $sql = 'select code, description, units, time, room from ' . $course . ' where studyear=:y and semester=:s';
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute(array(':y' => $year, ':s' => $sem));
                // $row = $stmt->fetch(PDO::FETCH_OBJ);
                // var_dump($row);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            // get registered subjects
            $sql1 = 'select studnum, subjects from evaluated where studnum=:sn';
            $stmt1 = $pdo->prepare($sql1);
            try {
                $stmt1->execute(array(':sn' => $studnum));
                $row1 = $stmt1->fetch(PDO::FETCH_OBJ);
                // var_dump($row);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $regsubjects = explode('$', $row1->subjects);
            // var_dump( $regsubjects);

            while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                // subject is in registered subjects
                if (in_array($row->code, $regsubjects)) {
                    echo '<ul class="rowtitle cour">';
                    echo '<li class="code fcode">' . $row->code . '</li>';
                    echo '<li class="desc">' . ucwords($row->description) . '</li>';
                    echo '<li class="units">' . $row->units . '</li>';
                    echo '<li class="time">' . strtoupper($row->time) . '</li>';
                    echo '<li class="room">' . strtoupper($row->room) . '</li>';
                    echo '</ul>';
                }
            }
            $stmt->closeCursor();
            $stmt1->closeCursor();
            $pdo = null;

        }

        ?>

    </div>

    <?php
        if ($evalnum == 0) {
            echo '<p class="reminder">You must go to registrar\'s office. ';
            $now = new DateTime('@' . time());
            $ago = new DateTime('@' . $regtime);
            $remtime = $now->diff($ago);
            $remd = 10-$remtime->days;
            echo 'Remaining days for evaluation: ' . $remd . '</p>';
            echo '<span class="topdf">View and Download Form</span>';
        }
    ?>

</article>

<?php
// footer
require_once '../footer.php';
?>

<?php

// logout
if (isset($_POST['logout'])) {
    $_SESSION['id'] = null;
    $_SESSION['finalid'] = null;
    $_SESSION['profile'] = null;
    session_destroy();
    header('Location: ./register-login.php');
    ob_end_flush();
    exit();
}

?>