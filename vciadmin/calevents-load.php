
<p>Note: to save, just press enter. <span class="addev">Add Event</span></p>

<?php

require_once '../config.php';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['month'])) {
    $month = htmlentities($_POST['month']);
    $year = htmlentities($_POST['year']);
    $sql = 'select * from calevents where year=:y and month=:m order by day';
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute(array(':m' => $month, ':y' => $year));
        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
            echo '<ul>';
            echo '<li class="d"><input type="text" name="day" maxlength="2" placeholder="Day" value="' . $row->day . '" disabled="disabled"></li>';
            echo '<li class="e"><input type="text" name="desc" maxlength="180" placeholder="Event description" value="' . $row->event . '" disabled="disabled"></li>';
            echo '<li class="edit"><span>Edit</span></li>';
            echo '<li class="del"><span>Delete</span></li>';
            echo '<li class="eid" style="display:none;">' . $row->id . '</li>';
            echo '</ul>';
        }
    } catch (PDOException $e) {
        $msg['message'] = $e->getMessage();
        print json_encode($msg);
        header('HTTP/ 400 Problem on sql');
    }

    $stmt->closeCursor();
    $pdo = null;
}

?>