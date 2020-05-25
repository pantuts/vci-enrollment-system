<?php

require_once './header.php';

// set pre-enrollees to session
$_SESSION['type'] = 'enrollees';

?>

        <article>
            
            <div class="processes enrol">

                <div class="search en-search">
                    <input name="search" id="search" maxlength="40" placeholder="Search enrollees..." />
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
                            if ($row['evaluated'] == 1) {

                                $evaltime = $row['evaltime'];
                                // if still valid. not more than 10 days
                                //if (timeDuration($evaltime) <= 10) {
                                    // change background of result per 2
                                    if ($i % 2 == 0) {
                                        echo '<ul class="display res enrols resb">';
                                        echo '<li class="dnc fname">' . ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                    . ', ' . ucwords(substr($row['middle_name'], 0, 1)) . '</li>';
                                        echo '<li class="dnc cour">' . $course . '</li>';
                                        echo '<li class="studnum" style="display:none;">' . $row['studnum'] . '</li>';
                                        echo '<li class="year" style="display:none;">' . $row['year'] . '</li>';
                                        echo '<li class="sem" style="display:none;">' . $row['sem'] . '</li>';
                                        echo '<li><span class="view">View</span>  <span class="del">Delete</span></li>';
                                        echo '</ul>';
                                    } else {
                                        echo '<ul class="display res enrols">';
                                        echo '<li class="dnc fname">' . ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                    . ', ' . ucwords(substr($row['middle_name'], 0, 1)) . '</li>';
                                        echo '<li class="dnc cour">' . $course . '</li>';
                                        echo '<li class="studnum" style="display:none;">' . $row['studnum'] . '</li>';
                                        echo '<li class="year" style="display:none;">' . $row['year'] . '</li>';
                                        echo '<li class="sem" style="display:none;">' . $row['sem'] . '</li>';
                                        echo '<li><span class="view">View</span>  <span class="del">Delete</span></li>';
                                        echo '</ul>';
                                    }
                                // } else {
                                //     // delete expired pre-registration from 3 tables
                                //     $sql1 = 'delete from registers, profiles, student using registers';
                                //     $sql1 .= ' inner join profiles inner join student';
                                //     $sql1 .= ' where registers.studnum=:sn';
                                //     $sql1 .= ' and profiles.studnum=registers.studnum and student.studnum=registers.studnum';
                                //     $stmt1 = $pdo->prepare($sql1);
                                //     try {
                                //         $stmt1->execute(array(':sn' => $row['studnum']));
                                //     } catch (PDOException $e) {
                                //         echo $e->getMessage();
                                //     }
                                // }
                            }
                            $i++;
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
                            if ($row['evaluated'] == 1) {
                                if ($i % 2 == 0) {
                                    echo '<ul class="display res enrols resb">';
                                    echo '<li class="dnc fname">' . ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                . ', ' . ucwords(substr($row['middle_name'], 0, 1)) . '</li>';
                                    echo '<li class="dnc cour">' . $course . '</li>';
                                    echo '<li class="studnum" style="display:none;">' . $row['studnum'] . '</li>';
                                    echo '<li class="year" style="display:none;">' . $row['year'] . '</li>';
                                    echo '<li class="sem" style="display:none;">' . $row['sem'] . '</li>';
                                    echo '<li><span class="view">View</span>  <span class="del">Delete</span></li>';
                                    echo '</ul>';
                                } else {
                                    echo '<ul class="display res enrols">';
                                    echo '<li class="dnc fname">' . ucwords($row['family_name']) .', ' . ucwords($row['given_name'])
                                                . ', ' . ucwords(substr($row['middle_name'], 0, 1)) . '</li>';
                                    echo '<li class="dnc cour">' . $course . '</li>';
                                    echo '<li class="studnum" style="display:none;">' . $row['studnum'] . '</li>';
                                    echo '<li class="year" style="display:none;">' . $row['year'] . '</li>';
                                    echo '<li class="sem" style="display:none;">' . $row['sem'] . '</li>';
                                    echo '<li><span class="view">View</span>  <span class="del">Delete</span></li>';
                                    echo '</ul>';
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

            </div>


        </article>

<?php 

require_once './footer.php';

?>