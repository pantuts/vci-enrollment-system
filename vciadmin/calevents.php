<?php

require_once './header.php';

/////// note if addevent the same day and year and desc, alert

?>

    <article>
        
        <div class="processes events">
            
            
                <div class="month">
                    <p>Select Month and Year: </p>
                    <select name="year" id="" class="year">
                        <?php
                            $y = new DateTime('@' . time());
                            $nowy = $y->format('Y');
                            $nexty = $nowy + 1;
                            echo '<option value="' . $nowy . '">' . $nowy . '</option>';
                            echo '<option value="' . $nexty . '">' . $nexty . '</option>';
                        ?>
                    </select>
                    <ul class="smonth">
                        <li><input type="radio" name="month" value="January">January</li>
                        <li><input type="radio" name="month" value="February">February</li>
                        <li><input type="radio" name="month" value="March">March</li>
                        <li><input type="radio" name="month" value="April">April</li>
                        <li><input type="radio" name="month" value="May">May</li>
                        <li><input type="radio" name="month" value="June">June</li>
                        <li><input type="radio" name="month" value="July">July</li>
                        <li><input type="radio" name="month" value="August">August</li>
                        <li><input type="radio" name="month" value="September">September</li>
                        <li><input type="radio" name="month" value="October">October</li>
                        <li><input type="radio" name="month" value="November">November</li>
                        <li><input type="radio" name="month" value="December">December</li>
                    </ul>
                </div>

                <div class="eventinp">
                    <!-- <p>To save, just press enter. <span class="addev">Add Event</span></p>
                    <ul>
                        <li class="d"><input type="text" name="day" maxlength="2" placeholder="Day" value="1" disabled="disabled"></li>
                        <li class="e"><input type="text" name="desc" maxlength="180" placeholder="Event description" value="Test tst" disabled="disabled"></li>
                        <li class="edit"><span>Edit</span></li>
                        <li class="del"><span>Delete</span></li>
                        <li class="eid" style="display:none;">0001</li>
                    </ul>
                    <ul>
                        <li class="d"><input type="text" name="day" maxlength="2" placeholder="Day" value="1" disabled="disabled"></li>
                        <li class="e"><input type="text" name="desc" maxlength="180" placeholder="Event description" value="Test tst" disabled="disabled"></li>
                        <li class="edit"><span>Edit</span></li>
                        <li class="del"><span>Delete</span></li>
                        <li class="eid" style="display:none;">0002</li>
                    </ul> -->
                </div>
           

        </div>

    </article>

<?php

require_once './footer.php';

?>

    