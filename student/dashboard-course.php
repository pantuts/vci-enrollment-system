<?php

// sa update: evaluated uli sa 0 kun maupdate ang user

ini_set('session.cookie_httponly', true);
session_start();
ob_start();

// check if logged in
if (!isset($_SESSION['finalid'])) {
    header('Location: ./dashboard.php');
    ob_end_flush();
    exit();
}

// check if waiting to evaluate
require_once '../config.php';
$studnum = htmlentities($_SESSION['id']);

$sql = 'select studnum from registers where studnum=:studnum';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':studnum', $studnum);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row !== FALSE) {
    $_SESSION['profile'] = $studnum;
    header('Location: ./dashboard-profile.php');
    ob_end_flush();
}

// header
require_once '../header.php';

?>

<article class="body stucour">
    <!-- logout -->
    <div class="logout">
        <form action="" method="post">
            <p>
                <input type="submit" name="logout" value="Logout?" />
            </p>
        </form>
    </div>
    <br/>

    <!-- course year -->
    <div class="course-year">

        <form method="post" class="cy">
            <select name="course-year">
                <option value="Choose Year">Choose Year</option>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
            </select>

            <select name="course-year-sem">
                <option value="Choose Semester">Choose Semester</option>
                <option value="1st Sem">1st Sem</option>
                <option value="2nd Sem">2nd Sem</option>
            </select>

            <select name="course-title">
                <option value="Choose Course">Choose Course</option>
                <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                <option value="Bachelor of Science in Computer Science">Bachelor of Science in Computer Science</option>
                <option value="Bachelor of Science in Criminology">Bachelor of Science in Criminology</option>
                <option value="Bachelor of Science in Business Administration">Bachelor of Science in Business Administration</option>
            </select>

            <input type="submit" name="course-select" value="VIEW" />
        </form>

    </div>

    <!-- course -->
    <div class="course">

        <!-- <p class="course-title">Bachelor of Arts in Information Technology</p> -->
        <!-- <ul class="rowtitle">
            <li class="code">Code</li>
            <li class="desc">Description</li>
            <li class="units">Units</li>
            <li class="time">Time</li>
            <li class="room">Room</li>
        </ul> -->

        <!-- <ul class="rowtitle cour">
            <li class="code">Eng ++</li>
            <li class="desc">English Plus 1 test test test</li>
            <li class="units">3</li>
            <li class="time">1-5 M-W-F, 5-10 T-TH</li>
            <li class="room">409</li>
        </ul> -->
        
        <?php

            // course selection
            if (isset($_POST['course-select'])) {

                $course_year = htmlentities($_POST['course-year']);
                $course_year_sem = htmlentities($_POST['course-year-sem']);
                $course_title = htmlentities($_POST['course-title']);


                // if not empty
                if ($course_year != 'Choose Year' && $course_year_sem != 'Choose Semester' && $course_title !=  'Choose Course') {

                    require_once '../config.php';

                    // course title
                    $course_selected = '';
                    switch ($course_title) {

                        case 'Bachelor of Science in Information Technology':
                            $course_selected = 'bsit';
                            break;

                        case 'Bachelor of Science in Computer Science':
                            $course_selected = 'bscs';
                            break;

                        case 'Bachelor of Science in Criminology';
                            $course_selected = 'bscrim';
                            break;

                        case 'Bachelor of Science in Business Administration';
                            $course_selected = 'bsba';
                            break;
                        
                        default:
                            break;
                    }
                    $_SESSION['course_selected'] = $course_selected;

                    // student year
                    switch ($course_year) {
                        case '1st Year':
                            $course_year = 1;
                            break;
                        
                        case '2nd Year':
                            $course_year = 2;
                            break;

                        case '3rd Year':
                            $course_year = 3;
                            break;

                        case '4th Year':
                            $course_year = 4;
                            break;

                        default:
                            break;
                    }
                    $_SESSION['course_year'] = $course_year;

                    // semester
                    switch ($course_year_sem) {
                        case '1st Sem':
                            $course_year_sem = 1;
                            break;
                        
                        case '2nd Sem':
                            $course_year_sem = 2;
                            break;

                        default:
                            break;
                    }
                    
                    $_SESSION['course_title'] = '';
                    $_SESSION['course_title'] = $course_selected;
                    $_SESSION['course_year'] = '';
                    $_SESSION['course_year'] = $course_year;
                    $_SESSION['course_year_sem'] = '';
                    $_SESSION['course_year_sem'] = $course_year_sem;

                    $sql = 'select * from ' . $course_selected . ' where semester=:sem and studyear=:stuy';
                    $stmt = $pdo->prepare($sql);
                    try {
                        $stmt->execute(array(
                            ':sem' => $course_year_sem,
                            ':stuy' => $course_year
                        ));
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }

                    echo '<ul class="rowtitle">';
                    echo '<li class="code">Code</li>';
                    echo '<li class="desc">Description</li>';
                    echo '<li class="units">Units</li>';
                    echo '<li class="time">Time</li>';
                    echo '<li class="room">Room</li>';
                    echo '</ul>';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<ul class="rowtitle cour">';
                        echo '<li class="code">'. $row['code'] . '</li>';
                        echo '<li class="desc">' . $row['description'] . '</li>';
                        echo '<li class="units">' . $row['units']  . '</li>';
                        echo '<li class="time">' . $row['time'] . '</li>';
                        echo '<li class="room">' . $row['room'] .'</li>';
                        echo '</ul>';
                    }
                    // $stmt->closeCursor();
                    // $pdo = null;

                    echo '
                        <form method="post">
                            <input type="submit" value="Register" name="register" />
                        </form>
                    ';

                    // $stmt->closeCursor();
                    // $pdo = null;
                    // check if pre-registered: sa taas dapat ini from start
                    // pagpinindot register, sulod database studnumber s pre-regs
                    // then print pdf intiro
                    ///// then set session profileall /////
                    // then redirect
                    // echo $_SESSION['id'];

                } else {
                    echo 'empty fields';
                }
            }

            // REGISTER
            if (isset($_POST['register'])) {

                $studnum = htmlentities($_SESSION['id']);
                $sql = 'insert into registers (studnum, evaluated, course, year, sem, evaltime) values (:studnum, :evals, :course, :yr, :sem, :etime)';
                $stmt = $pdo->prepare($sql);
                try {
                    $time = time();
                    $stmt->execute(array(
                        ':studnum' => $studnum,
                        ':evals' => 0,
                        ':course' => htmlentities($_SESSION['course_selected']),
                        ':yr' => htmlentities($_SESSION['course_year']),
                        ':sem' => htmlentities($_SESSION['course_year_sem']),
                        ':etime' => $time
                    ));
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                // time insert
                $_SESSION['profile'] = $studnum;
                echo 'Your registration is complete. Please go to registrar\'s office for final evaluation.';
                echo 'You can now proceed to <a href="./dashboard-profile.php">your profile.</a>';
                $stmt->closeCursor();
                $pdo = null;
            }
        ?>
        
    </div>
    <!-- end course -->

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
    session_destroy();
    header('Location: ./register-login.php');
    ob_end_flush();
    exit();
}

?>