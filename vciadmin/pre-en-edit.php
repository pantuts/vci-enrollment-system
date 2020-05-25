<?php

// note
// add subject
// update
// pag my nadelete n subject: retrieve ang mga subj, save s var, nan inutang s dropdown select
// sa pag update, kuwaon lng ang subject code
// NOTTO sa pag add subj count kung pirang subjects n pra aram kun ubos n an subj
// NOTTO sa pag retrieve, ibutang s var ang count san subjects
// pag delete, clone ang ul nan ibutang s p.class ang subj code = clear var first
// pag nagpindot p. nan iclone n .html() = clear var

require_once 'header.php';

// $studnum = htmlentities($_GET['studnum']);

// if (!isset($_GET['studnum'])) {
//     header('Location: ./panel.php');
//     ob_end_flush();
//     exit();
// }

if (!isset($_GET['studnum']) && !isset($_GET['year']) && !isset($_GET['sem']) && !isset($_GET['course'])) {
    header('Location: ./panel-pre-enrollees.php');
    ob_end_flush();
}

$studnum = htmlentities($_GET['studnum']);
$year = htmlentities($_GET['year']);
$sem = htmlentities($_GET['sem']);
$course = htmlentities($_GET['course']);
// echo $studnum.' '.$year.' '.$sem;

?>

        <article>
            
            <div class="processes pre-en-edit">
                <!-- display dd intiro n subjects room blah blah -->
                <br/>

                <?php

                // select columns from 2 tables
                $sql = 'select * from profiles, student where profiles.studnum=:sn and student.studnum=:sn';
                $stmt = $pdo->prepare($sql);
                try {
                    $stmt->execute(array(':sn' => $studnum));
                    $row = $stmt->fetch(PDO::FETCH_OBJ);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                $fullname = ucwords($row->given_name) . ' ' . ucwords($row->middle_name) . ' ' . ucwords($row->family_name);
                $email = $row->email;
                $sex = ucwords($row->sex);
                $addr = ucwords($row->address);
                $bdate = $row->birthdate;
                $bplace =ucwords( $row->birthplace);
                $relig = ucwords($row->religion);
                $gname = ucwords($row->guardian_name);
                $occup = ucwords($row->occupation);
                $permaddr = ucwords($row->permanent_address);
                $contact = ucwords($row->contact_no);

                $stmt->closeCursor();

                ?>

                <div class="profile">
                    <span class="fullname fec"><?php echo $fullname ?></span>
                    <span class="email fec"><?php echo $email ?></span>
                
                    <div class="left">
                        <p>
                            <span class="cat">Sex: </span><span class="catval"><?php echo $sex ?></span>
                        </p>
                        <p>
                            <span class="cat">Birthdate: </span><span class="catval"><?php echo $bdate ?></span>
                        </p>
                        <p>
                            <span class="cat">Birthplace: </span><span class="catval"><?php echo $bplace ?></span>
                        </p>
                        <p>
                            <span class="cat">Address: </span><span class="catval"><?php echo $addr ?></span>
                        </p>
                        <p>
                            <span class="cat">Permanent Address: </span><span class="catval"><?php echo $permaddr ?></span>
                        </p>
                    </div>
                    <div class="right">
                        <p>
                            <span class="cat">Religion: </span><span class="catval"><?php echo $relig ?></span>
                        </p>
                        <p>
                            <span class="cat">Guardian Name: </span><span class="catval"><?php echo $gname ?></span>
                        </p>
                        <p>
                            <span class="cat">Grd. Occupation: </span><span class="catval"><?php echo $occup ?></span>
                        </p>
                        <p>
                            <span class="cat">Grd. Contact #: </span><span class="catval"><?php echo $contact ?></span>
                        </p>
                        <p>
                            <span class="cat">Generated VCI-ID: </span><span class="catval studnum"><?php echo $studnum ?></span>
                        </p>
                    </div>
                </div>
                

                <div class="cosubs">

                    <?php

                        // switch course code
                        switch ($course) {
                            case 'bsit':
                                $course = 'BS in Information Technology';
                                $datacourse = 'bsit';
                                break;
                            case 'bscs':
                                $course = 'BS in Computer Science';
                                $datacourse = 'bscs';
                                break;
                            case 'bsba':
                                $course = 'BS in Business Administration';
                                $datacourse = 'bsba';
                                break;
                            case 'bscrim':
                                $course = 'BS in Criminology';
                                $datacourse = 'bscrim';
                                break;
                            default:
                                echo 'Wrong course code!';
                                exit();
                                break;
                        }
                        // switch year
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

                        $sql = 'select code, description, units, time, room from ' . $datacourse . ' where studyear=:y and semester=:s';
                        $stmt = $pdo->prepare($sql);
                        try {
                            $stmt->execute(array(':y' => $year, ':s' => $sem));
                            // $row = $stmt->fetch(PDO::FETCH_OBJ);
                            // var_dump($row);
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }

                    ?>
                    
                    <span class="fec co"><?php echo $course ?></span>
                    <span class="fec yr"><?php echo $yearc . ' - Sem: ' . $sem ?></span>

                    <ul class="rowtitle title">
                        <li class="code rt">Code</li>
                        <li class="desc rt">Description</li>
                        <li class="units rt">Units</li>
                        <li class="time rt">Time</li>
                        <li class="room rt">Rm.</li>
                        <li class="action rt">Action</li>
                    </ul>

                    <?php

                        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo '<ul class="rowtitle subjects">';
                            echo '<li class="code fcode">' . $row->code . '</li>';
                            echo '<li class="desc">' . ucwords($row->description) . '</li>';
                            echo '<li class="units">' . $row->units . '</li>';
                            echo '<li class="time">' . strtoupper($row->time) . '</li>';
                            echo '<li class="room">' . strtoupper($row->room) . '</li>';
                            echo '<li class="action">Delete</li>';
                            echo '</ul>';
                        }
                        $stmt->closeCursor();
                        $pdo = null;

                    ?>

                    <!-- subjects -->
                    <!-- <ul class="rowtitle subjects">
                        <li class="code">IT 101</li>
                        <li class="desc">Basic Programming and Data Structures in Java, C++, C#, and Python</li>
                        <li class="units">3</li>
                        <li class="time">10am-11am M-W, 9am-10am F</li>
                        <li class="room">CR404</li>
                        <li class="action">Delete</li>
                    </ul> -->

                </div>

                <div class="addsubj">
                    <span>Subjects to add:</span>
                    <!-- <p class="0">
                        Basic Programming and Data Structures in Java, C++, C#, and Python
                    </p>
                    -->
                </div>

                <div class="save">
                    <span class="saveR">Save</span>
                    <span class="delR">Remove Pre-Registrant</span>
                </div>

            </div>

        </article>


<?php

require_once 'footer.php';

?>