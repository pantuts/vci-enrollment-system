<?php

// note
// echo expired pre-registrants

require_once './header.php';

// $time is in unix timestamp: ex: 1393778444
function timeDuration($time) {
    $ago = new DateTime('@' . $time);
    $now = new DateTime('@' . time());
    $dif = $now->diff($ago);
    // echo '<pre>';
    // var_dump($dif);
    // echo '</pre>';
    return $dif->days;
}
$deleted = array();
// set pre-enrollees to session
$_SESSION['type'] = 'pre-enrollees';

?>

        <article>
            
            <div class="processes .pre-en">

                <div class="search pre-en-search">
                    <input name="search" id="search" maxlength="40" placeholder="Search pre-enrollees..." />
                </div>
                <br/>

                <ul class="display">
                    <li class="dnc">Name</li>
                    <li class="dnc">Course</li>
                    <li>Action</li>
                </ul>
                <br/>

                <?php

                    // check if search parameter exists in url
                    if (isset($_GET['search'])) {

                        $searchq = htmlentities($_GET['search']);
                        // manipulate search query for regexp usage
                        if (strpos($searchq, ' ') !== false) {
                            $searchf = $searchq . '|' . str_replace(' ', '', $searchq) .'|' . substr($searchq, 0, strpos($searchq, ' '));
                        } else {
                            $searchf = $searchq;
                        }
                        $sql = 'select DISTINCT registers.studnum, registers.evaluated, registers.course, registers.evaltime, registers.sem, registers.year,';
                        $sql .= ' profiles.given_name, profiles.family_name, profiles.middle_name, profiles.studnum';
                        $sql .= ' from registers, profiles';
                        $sql .= ' where registers.studnum=profiles.studnum';
                        $sql .= ' and (profiles.family_name regexp "' . $searchf . '"';
                        $sql .= ' or profiles.given_name regexp "' . $searchf. '"';
                        $sql .= ' or profiles.middle_name regexp "' . $searchf. '") order by profiles.family_name limit 0,100';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $i = 1;
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            // var_dump($row);
                            $course = $row['course'];
                            switch ($course) {
                                case 'bsit':
                                    $course = 'BS Information Technology';
                                    break;
                                case 'bscs':
                                    $course = 'BS Computer Science';
                                    break;
                                case 'bsba':
                                    $course = 'BS Business Administration';
                                    break;
                                case 'bscrim':
                                    $course = 'BS Criminology';
                                    break;
                                default:
                                    break;
                            }

                            // if evaluated is 0 == not orientated yet
                            if ($row['evaluated'] == 0) {
                                $i++;
                                $evaltime = $row['evaltime'];
                                // if still valid. not more than 10 days
                                if (timeDuration($evaltime) <= 10) {
                                    // change background of result per 2
                                    if ($i % 2 == 0) {
                                        echo '<ul class="display res pre-ens resb">';
                                        echo '<li class="dnc fname">' . ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                    . ', ' . ucwords(substr($row['middle_name'], 0, 1)) . '</li>';
                                        echo '<li class="dnc cour">' . $course . '</li>';
                                        echo '<li class="studnum" style="display:none;">' . $row['studnum'] . '</li>';
                                        echo '<li class="year" style="display:none;">' . $row['year'] . '</li>';
                                        echo '<li class="sem" style="display:none;">' . $row['sem'] . '</li>';
                                        echo '<li><span class="view">View</span>  <span class="del">Delete</span></li>';
                                        echo '</ul>';
                                    } else {
                                        echo '<ul class="display res pre-ens">';
                                        echo '<li class="dnc fname">' . ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                    . ', ' . ucwords(substr($row['middle_name'], 0, 1)) . '</li>';
                                        echo '<li class="dnc cour">' . $course . '</li>';
                                        echo '<li class="studnum" style="display:none;">' . $row['studnum'] . '</li>';
                                        echo '<li class="year" style="display:none;">' . $row['year'] . '</li>';
                                        echo '<li class="sem" style="display:none;">' . $row['sem'] . '</li>';
                                        echo '<li><span class="view">View</span>  <span class="del">Delete</span></li>';
                                        echo '</ul>';
                                    }
                                } else {
                                    // delete expired pre-registration from 3 tables
                                    $sql1 = 'delete from registers, profiles, student using registers';
                                    $sql1 .= ' inner join profiles inner join student';
                                    $sql1 .= ' where registers.studnum=:sn';
                                    $sql1 .= ' and profiles.studnum=registers.studnum and student.studnum=registers.studnum';
                                    $stmt1 = $pdo->prepare($sql1);
                                    try {
                                        $stmt1->execute(array(':sn' => $row['studnum']));
                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
                                }
                            }
                        }
                        $stmt->closeCursor();
                        $pdo = null;

                    } else {

                        // a relational query for pre-enrollees
                        $sql = 'select registers.studnum, registers.evaluated, registers.course, registers.evaltime, registers.sem, registers.year,';
                        $sql .= ' profiles.given_name, profiles.family_name, profiles.middle_name, profiles.studnum';
                        $sql .= ' from registers, profiles';
                        $sql .= ' where registers.studnum=profiles.studnum order by profiles.family_name limit 0,100';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $i = 1;
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            // var_dump($row);
                            $course = $row['course'];
                            switch ($course) {
                                case 'bsit':
                                    $course = 'BS Information Technology';
                                    break;
                                case 'bscs':
                                    $course = 'BS Computer Science';
                                    break;
                                case 'bsba':
                                    $course = 'BS Business Administration';
                                    break;
                                case 'bscrim':
                                    $course = 'BS Criminology';
                                    break;
                                default:
                                    break;
                            }

                            // if evaluated is 0 == not orientated yet
                            if ($row['evaluated'] == 0) {

                                $evaltime = $row['evaltime'];
                                // if still valid. not more than 10 days
                                if (timeDuration($evaltime) <= 10) {
                                    // change background of result per 2
                                    if ($i % 2 == 0) {
                                        echo '<ul class="display res pre-ens resb">';
                                        echo '<li class="dnc fname">' . ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                    . ', ' . ucwords(substr($row['middle_name'], 0, 1)) . '</li>';
                                        echo '<li class="dnc cour">' . $course . '</li>';
                                        echo '<li class="studnum" style="display:none;">' . $row['studnum'] . '</li>';
                                        echo '<li class="year" style="display:none;">' . $row['year'] . '</li>';
                                        echo '<li class="sem" style="display:none;">' . $row['sem'] . '</li>';
                                        echo '<li><span class="view">View</span>  <span class="del">Delete</span></li>';
                                        echo '</ul>';
                                    } else {
                                        echo '<ul class="display res pre-ens">';
                                        echo '<li class="dnc fname">' . ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                    . ', ' . ucwords(substr($row['middle_name'], 0, 1)) . '</li>';
                                        echo '<li class="dnc cour">' . $course . '</li>';
                                        echo '<li class="studnum" style="display:none;">' . $row['studnum'] . '</li>';
                                        echo '<li class="year" style="display:none;">' . $row['year'] . '</li>';
                                        echo '<li class="sem" style="display:none;">' . $row['sem'] . '</li>';
                                        echo '<li><span class="view">View</span>  <span class="del">Delete</span></li>';
                                        echo '</ul>';
                                    }
                                } else {
                                    // delete expired pre-registration from 3 tables
                                    $sql1 = 'delete from registers, profiles, student using registers';
                                    $sql1 .= ' inner join profiles inner join student';
                                    $sql1 .= ' where registers.studnum=:sn';
                                    $sql1 .= ' and profiles.studnum=registers.studnum and student.studnum=registers.studnum';
                                    $stmt1 = $pdo->prepare($sql1);
                                    try {
                                        $stmt1->execute(array(':sn' => $row['studnum']));
                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
                                    array_push($deleted, ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                    . ', ' . ucwords(substr($row['middle_name'], 0, 1)));
                                }
                                $i++;
                            }
                        }
                        $stmt->closeCursor();
                        $pdo = null;
                    }

                ?>
                <!-- <ul class="display res">
                    <li class="dnc">Romnick Bien Pantua</li>
                    <li class="dnc">BS Business Management and Accountancy</li>
                    <li><span class="view">View</span>  <span class="del">Delete</span></li>
                </ul> -->

                <!-- <div class="deleted">
                    <span>Expired Pre-Registrants: (deleted)</span>
                    <ul>
                        <li>tTest</li>
                        <li>Test</li>
                    </ul>
                </div> -->
                <?php

                    if (!empty($deleted)) {
                        echo '<div class="deleted">';
                        echo '<span>Expired Pre-Registrants: (deleted)</span>';
                        echo '<ul>';
                        foreach ($deleted as $del) {
                            echo '<li>' . $del . '</li';
                        }
                        echo '</ul>';
                        echo '</div>';
                    }

                ?>

            </div>


        </article>

<?php 

require_once './footer.php';

?>