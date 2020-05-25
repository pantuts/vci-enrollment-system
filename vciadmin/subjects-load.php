<?php

require_once '../config.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course'])) {
    $course = htmlentities($_POST['course']);
    $sql = 'select * from ' . $course . ' order by studyear';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo $msg['error'] = $e->getMessage();
        header('HTTP/ 400 Problem on sql');
    }
}

?>

                <div class="filter">
                    <p class="byyear">Filter by year:</p>
                    <p><input type="radio" value="all" name="filterby" class="filterby" />All</p>
                    <p><input type="radio" value="1" name="filterby" class="filterby" />1</p>
                    <p><input type="radio" value="2" name="filterby" class="filterby" />2</p>
                    <p><input type="radio" value="3" name="filterby" class="filterby" />3</p>
                    <p><input type="radio" value="4" name="filterby" class="filterby" />4</p>
                </div>

                <div class="addsubj">
                    <span>Add Subject</span>
                </div>

                <div class="subjects">
                    <ul class="rowtitle">
                        <li class="rcode">Code</li>
                        <li class="rdesc">Description</li>
                        <li class="runits">Units</li>
                        <li class="rtime">Time</li>
                        <li class="rroom">Room</li>
                        <li class="rsem">Sem</li>
                        <li class="ryear">Year</li>
                    </ul>

                    <?php

                    while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                        echo '<ul class="' . $row->studyear . '">';
                        echo '<li class="code"><input type="text" name="code" value="'. $row->code . '" disabled="disabled" ></li>';
                        echo '<li class="desc"><input type="text" name="desc" value="'. $row->description . '" disabled="disabled" ></li>';
                        echo '<li class="units"><input type="text" name="units" value="' . $row->units . '" disabled="disabled" ></li>';
                        echo '<li class="time"><input type="text" name="time" value="' . $row->time . '" disabled="disabled" ></li>';
                        echo '<li class="room"><input type="text" name="time" value="'. strtoupper($row->room) . '" disabled="disabled" ></li>';
                        echo '<li class="sem"><input type="text" name="time" value="'. $row->semester . '" disabled="disabled" ></li>';
                        echo '<li class="year"><input type="text" name="time" value="'. $row->studyear . '" disabled="disabled" ></li>';
                        echo '<li class="edit">Edit</li>';
                        echo '<li class="delete">Delete</li>';
                        echo '</ul>';
                    }

                    ?>

                    </div>