<?php

ini_set('session.cookie_httponly', true);
session_start();
ob_start();

// header
require_once '../header.php';

// if already logged in redirect to dashboard
if (isset($_SESSION['id'])) {
    header('Location: ./dashboard.php');
    //ob_end_flush();
}

?>

    <article class="body reglog">

    
        <div class="left">

            <div class="ofcourses">
                <span class="rl">Offered Courses</span>
                <ul>
                    <li><a href="../courses.php#bscsit">BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY</a></li>
                    <li><a href="../courses.php#beed">BACHELOR OF SECONDARY EDUCATION (Major in Filipino)</a></li>
                    <li><a href="../courses.php#beed">BACHELOR OF SECONDARY EDUCATION (Major in Mathematics)</a></li>
                    <li><a href="../courses.php#beed">BACHELOR OF SECONDARY EDUCATION (Major in English)</a></li>
                    <li><a href="../courses.php#beed">BACHELOR OF ELEMENTARY EDUCATION (BEED)</a></li>
                    <li><a href="../courses.php#bsba">BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION</a></li>
                    <li><a href="../courses.php#bsagt">BACHELOR OF AGRICULTURAL</a></li>
                    <li><a href="../courses.php#bscrim">BACHELOR OF SCIENCE IN CRIMINOLOGY</a></li>
                </ul>
            </div>

            <div class="access">
                <span class="rl">Your Access! To Success!</span>
                <p>
                    VCI warmly welcomes high school graduates, college transferees, second courses, and postgraduate degree applicants in its campuses. All campuses take pride in their staff who are able to provide personalized assistance, fast, and efficient admission procedures on-campus and even online.<br/><br/>
                    The Veritas College of Irosin uses a Online Registration System. Which allows students to reserve and check if the courses they plan to take for the semester are available. To visit the ORS links, please login. 
                </p>
                <div class="guides">
                    <span class="rl">Guidelines to access online registration.</span>

                    <ul>
                        <li class="num">1. Log In or Create New Account</li>
                        <li class="cont">You must fill out the form with your basic information like email-address and password. </li>
                    </ul>
                    <ul>
                        <li class="num">2. Student Profile</li>
                        <li class="cont">This form requires his own personal information and he must follow the instructions indicated inside the page.</li>
                    </ul>
                    <ul>
                        <li class="num">3. Course Selection</li>
                        <li class="cont">Check if the courses they plan to take for the semester are available. Choose the subject they want to take up.</li>
                    </ul>
                    <ul>
                        <li class="num">4. Downloded Form</li>
                        <li class="cont">He must download and print the student's Proof of Registration. The Proof of Registration is not just evidence that he registered, but it will serve as a Student's white Form as well.</li>
                    </ul>

                </div>
            </div>

        </div>

        <div class="side">

            <!-- register -->
            <form action="" method="post">
                <p>
                    <label>Email: *</label>
                    <input type="text" id="email" name="email" />
                </p>
                <p>
                    <label>Password: *</label>
                    <input type="password" id="password1" name="password1" maxlength="30" />
                </p>
                <p>
                    <label>Retype Password: *</label>
                    <input type="password" id="password2" name="password2" maxlength="30" />
                </p>
                <p>
                    <input type="submit" name="submitreg" value="Register" />
                </p>
            </form>
            <br/>
            <!-- login -->
            <form action="" method="post">
                <p>
                    <label>Student #: *</label>
                    <input type="text" id="studentnumber" name="studentnumber" />
                </p>
                <p>
                    <label>Password: *</label>
                    <input type="password" id="loginpassword" name="loginpassword" maxlength="30" />
                </p>
                <p>
                    <input type="submit" name="submitlogin" value="Login" />
                </p>
                <p class="forgot">
                    <a href="./forgotpass.php">Forgot password?</a>
                </p>
            </form>

        </div>    

    </article>

<?php

// footer
require_once '../footer.php';

?>

<!-- registration and login process -->
<?php

// config
require_once '../config.php';
// functions
require_once '../functions.php';

////// for register //////
if (isset($_POST['submitreg'])) {

    $email = strtolower(htmlentities($_POST['email']));
    $password1 = htmlentities($_POST['password1']);
    $password2 = htmlentities($_POST['password2']);

    // if empty fields or passwords do not match
    if ($email == '' || $password1 == '' || $password2 = '' || $password1 != $password2
        || $email == null || $password1 == null || $password2 == null ||
        !isset($email) || !isset($password1) || !isset($password2)) {
        echo '<script>alert("Fill all the required fields.");</script>';
        //header('Location: ./register-login.php');
        ob_end_flush();
        exit();
    }
    // if email is incorrect
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Your email is in wrong format.");</script>';
        //header('Location: ./register-login.php"]');
        ob_end_flush();
        exit();
    }

    // hash password
    $password = hashPassword($password1);

    // check if already registered
    $sql = 'select id, confirmed from student where email=:email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // note if error querying, do try and catch or
    // if ($stmt === FALSE) before $row

    // if id exists
    if ($row['id'] != null || $row['id'] != '' || $row['id'] != FALSE) {
        // if confirmed
        if ($row['confirmed'] == 1) {
            echo '<script>alert("You are already registered, please login instead.");</script>';
            exit();
            // header('Location: ./register-login.php');
            //ob_end_flush();
        } else {
            echo '<script>alert("You already applied for registration please confirm by following the link sent to your email.");</script>';
            exit();
            //header('Location: ./register-login.php');
            //ob_end_flush();
        }
    } else {

        // register to database
        // hash is combination of email and secret in md5 form

        $studnum = studentNumber();
        $secret = 'ThisIsA$ecret';

        $sql = 'insert ignore into student (email, password, confirmed, studnum, hash) values (:email, :pass, 0, :studnum, :emailhash)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $password);
        $stmt->bindParam(':studnum', $studnum);
        $stmt->bindParam(':emailhash', md5($email . $secret));
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            // echo $e->getMessage();
            echo '<br/>Refresh your page and make another register.';
        }

        // send email
        // revalidate email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'To: ' . $email . "\r\n";
            $headers .= 'X-Mailer: PHP v' . phpversion();
            $headers .= 'X-Originating-IP: ' . $_SERVER['SERVER_ADDR'];

            $link = activationLink($email);
            $message = 'Please follow the link below to activate your registration. Thank you.\n' . $link;

            // for mailing
            // if (mail($email, 'Confirmation link', $message, $headers)) {
            //     echo '<script>alert("An activation link has been sent to your email.");</script>';
            //     header('Location: ./register-login.php');
            //     ob_end_flush();
            // } else {
            //     echo 'Mailing error, retry.';
            //     exit;
            // }
            echo '<script>alert("Temporary function:\nLink: ' . $link . '")</script>';
        }

        // close connection
        $stmt->closeCursor();
        $pdo = null;

    }


} 
////// for login //////
if (isset($_POST['submitlogin'])) {

    $studnum = htmlentities($_POST['studentnumber']);
    $password = htmlentities($_POST['loginpassword']);

    if ($studnum == '' || $password == '') {
        echo '<script>alert("Fill all the required fields.");</script>';
        exit;
    }

    $sql = 'select password, confirmed, studnum from student where password=:pass and studnum=:studnum';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':pass', hashPassword($password));
    $stmt->bindParam(':studnum', $studnum);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // if no record found
    if ($row === FALSE) {
        echo '<script>alert("Incorrect information.");</script>';
        $stmt->closeCursor();
        $pdo = null;
        //header('Location: ./register-login.php');
        //ob_end_flush();
        exit;
    } else {
        // if account is confirmed
        if ($row['confirmed'] == 1) {
            $_SESSION['id'] = $row['studnum'];
            $stmt->closeCursor();
            $pdo = null;
            header('Location: ./dashboard.php');
            ob_end_flush();
        } else {
            echo '<script>alert("You need to activate first your account. Follow the link sent to your email.");</script>';
            $stmt->closeCursor();
            $pdo = null;
            header('Location: ./register-login.php"]');
            ob_end_flush();
            //exit;
        }
    }
}

?>