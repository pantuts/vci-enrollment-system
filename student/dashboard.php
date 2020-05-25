<?php

ini_set('session.cookie_httponly', true);
session_start();
ob_start();

// check if logged in
if (!isset($_SESSION['id'])) {
    //ob_end_flush();
    header('Location: ./register-login.php');
    ob_end_flush();
    exit();
}

// set from dashboard.php
if (isset($_SESSION['finalid'])) {
    header('Location: ./dashboard-course.php');
    ob_end_flush();
}

require_once '../header.php';

?>

<article class="body studash">

    <!-- logout -->
    <div class="logout">
        <form action="" method="post">
            <p>
                <input type="submit" name="logout" value="Logout?" />
            </p>
        </form>
    </div>

    <p class="req">
        Please fill all the required fields for your personal information.
    </p>

    <?php

    require_once '../config.php';
    $studnum = htmlentities($_SESSION['id']);

    // query current logged user then check if fully profiled
    $sql = 'select id from profiles where studnum=:studnum';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':studnum', $studnum);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // check if exists
    if ($row !== FALSE) {
        $_SESSION['finalid'] = $studnum;
        header('Location: ./dashboard-course.php');
        ob_end_flush();
    }

    // $stmt->closeCursor();
    // $pdo = null;

    ?>

    <form action="" method="post">
        <div class="left">
            <p>
                <label>Given name: *</label>
                <input type="text" name="given_name" id="given_name" maxlength="50" />
            </p>
            <p>
                <label>Family name: *</label>
                <input type="text" name="fam_name" id="fam_name" maxlength="50" />
            </p>
            <p>
                <label>Middle name: *</label>
                <input type="text" name="mid_name" id="mid_name" maxlength="20" />
            </p>
            <p>
                <label>Sex: *</label>
                <select name="sex" id="sex">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <!-- <input type="text" name="sex" id="sex" /> -->
            </p>
            <p>
                <label>Address: *</label>
                <input type="text" name="address" id="address" maxlength="200" />
            </p>
            <p>
                <label>Birthdate: *</label>
                <!-- <input type="text" name="bdate" id="bdate" /> -->
                <?php

                    $month = array(
                        'Jan','Feb','Mar','Apr','May',
                        'Jun','Jul','Aug','Sept','Oct',
                        'Nov','Dec'
                    );

                    $day = array();
                    for ($i = 1; $i <= 31; $i++) {
                        array_push($day, $i);
                    }

                    $year = array();
                    $cy = new DateTime('@' . time());
                    for ($i = 1980; $i <= $cy->format('Y'); $i++) {
                        array_push($year, $i);
                    }

                    // month
                    echo '<select name="month" id="month">';
                    foreach($month as $mon) {
                        echo '<option value="' . $mon . '">' . $mon . '</option>';
                    }
                    echo '</select>';

                    // day
                    echo '<select name="day" id="day">';
                    foreach($day as $d) {
                        echo '<option value="' . $d . '">' . $d . '</option>';            }
                    echo '</select>';

                    // day
                    echo '<select name="year" id="year">';
                    foreach($year as $y) {
                        echo '<option value="' . $y . '">' . $y . '</option>';
                    }
                    echo '</select>';

                ?>
            </p>
            <p>
                <label>Birthplace: *</label>
                <input type="text" name="bplace" id="bplace" maxlength="200" />
            </p>
            <p>
                <label>Religion: *</label>
                <input type="text" name="religion" id="religion" value="Christian" maxlength="50" />
            </p>
        </div>
        <div class="right">
            <p>
                <label>Guardian Name: *</label>
                <input type="text" name="guardian" id="guardian" maxlength="50" />
            </p>
            <p>
                <label>Permanent Address: *</label>
                <input type="text" name="permaddress" id="permaddress" maxlength="200" />
            </p>
            <p>
                <label>Grd. Occupation: *</label>
                <input type="text" name="occupation" id="occupation" maxlength="150" />
            </p>
            <p>
                <label>Grd. Contact Number: * (Ex: 0919888555 09091238123) </label>
                <input type="text" name="contact_num" id="contact_num" maxlength="50" />
            </p>
            <p>
                <input type="submit" name="submitprof" id="submitprof" value="Submit" />
            </p>
        </div>
    </form>

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

// register profile
if (isset($_POST['submitprof'])) {

    require_once '../functions.php';


    $givname = cleanVar($_POST['given_name']);
    $famname = cleanVar($_POST['fam_name']);
    $midname = cleanVar($_POST['mid_name']);
    $sex = cleanVar($_POST['sex']);
    $address = cleanVar($_POST['address']);
    $bdate = cleanVar($_POST['month']) . '/' . cleanVar($_POST['day']) . '/' . cleanVar($_POST['year']);
    $bplace = cleanVar($_POST['bplace']);
    $religion = cleanVar($_POST['religion']);
    $guardian = cleanVar($_POST['guardian']);
    $permaddress = cleanVar($_POST['permaddress']);
    $occup = cleanVar($_POST['occupation']);
    $contact = cleanVar($_POST['contact_num']);
    $studnum = htmlentities($_SESSION['id']);
    $fullyreg = 1;

    // if empth=y field
    if ($givname == '' || $famname == '' || $midname == '' || $sex == '' || $address == '' || $bdate == '' || $bplace == '' || $religion == '' || $guardian == '' || $permaddress == '' || $occup == '' || $contact == '') {
        echo '<script>alert("Please fill up all the required fields.");</script>';
    } else {

        // why we do not check if there is already a record in the database with exacly the same full name?
        // there really are people with exactly the same name, an example is a hit in an NBI Clearance registration

        if (!is_numeric(str_replace(' ', '', $contact))) {
            echo '<script>alert("Contact number should only contain numbers.");</script>';
            exit;
        }

        $sql = 'insert into profiles (given_name, family_name, middle_name, sex, address, birthdate, birthplace, religion, guardian_name, permanent_address, occupation, contact_no, studnum, fullreg) values (:givname, :famname, :midname, :sex, :address, :bdate, :bplace, :religion, :guardian, :permaddress, :occup, :contact, :studnum, :fullreg)';
        $stmt = $pdo->prepare($sql);
            
        try {
            $stmt->execute(array(
                ':givname' => strtolower($givname),
                ':famname' => strtolower($famname),
                ':midname' => strtolower($midname), 
                ':sex' => strtolower($sex),
                ':address' => strtolower($address),
                ':bdate' => $bdate,
                ':bplace' => strtolower($bplace),
                ':religion' => strtolower($religion),
                ':guardian' => strtolower($guardian),
                ':permaddress' => strtolower($permaddress),
                ':occup' => strtolower($occup),
                ':contact' => strtolower($contact),
                ':studnum' => $studnum,
                ':fullreg' => $fullyreg,
            ));
            $stmt->closeCursor();
            $pdo = null;
            $_SESSION['finalid'] = md5($studnum);
            header('Location: ./dashboard-course.php');
            ob_end_flush();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>