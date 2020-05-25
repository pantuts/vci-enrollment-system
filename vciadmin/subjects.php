<?php

require_once './header.php';

?>

    <article>
        
        <div class="processes sched">
            
            <div class="selcourse-d">
                
                <p>Note: After editing a subject just press enter, it will be automatically saved to database.<br/><br/>Please select course to display:</p>
                <select name="selcourse" id="">
                    <option value=""></option>
                    <option value="bsit">BSIT</option>
                    <option value="bscs">BSCS</option>
                    <option value="bscrim">BSCRIM</option>
                    <option value="bsba">BSBA</option>
                </select>

                <!-- <div class="filter">
                    <p class="byyear">Filter by year:</p>
                    <p><input type="radio" value="all" name="filterby" class="filterby" />All</p>
                    <p><input type="radio" value="1" name="filterby" class="filterby" />1</p>
                    <p><input type="radio" value="2" name="filterby" class="filterby" />2</p>
                    <p><input type="radio" value="3" name="filterby" class="filterby" />3</p>
                    <p><input type="radio" value="4" name="filterby" class="filterby" />4</p>
                </div> -->

                <div class="subjects">
                    <!-- <ul class="rowtitle">
                        <li class="rcode">Code</li>
                        <li class="rdesc">Description</li>
                        <li class="runits">Units</li>
                        <li class="rtime">Time</li>
                        <li class="rroom">Room</li>
                        <li class="rsem">Sem</li>
                        <li class="ryear">Year</li>
                    </ul>
                    <ul class="1">
                        <li class="code"><input type="text" name="code" value="ENG +" disabled="disabled" ></li>
                        <li class="desc"><input type="text" name="desc" value="English Plus 101" disabled="disabled" ></li>
                        <li class="units"><input type="text" name="units" value="3" disabled="disabled" ></li>
                        <li class="time"><input type="text" name="time" value="1-5 M-W-F" disabled="disabled" ></li>
                        <li class="room"><input type="text" name="time" value="CR1" disabled="disabled" ></li>
                        <li class="sem"><input type="text" name="time" value="1" disabled="disabled" ></li>
                        <li class="year"><input type="text" name="time" value="1" disabled="disabled" ></li>
                        <li class="edit">Edit</li>
                        <li class="delete">Delete</li>
                    </ul>
                    <ul class="2">
                        <li class="code"><input type="text" name="code" value="ENG ++" disabled="disabled" ></li>
                        <li class="desc"><input type="text" name="desc" value="English Plus 102" disabled="disabled" ></li>
                        <li class="units"><input type="text" name="units" value="4" disabled="disabled" ></li>
                        <li class="time"><input type="text" name="time" value="1-6 M-W-F" disabled="disabled" ></li>
                        <li class="room"><input type="text" name="time" value="CR2" disabled="disabled" ></li>
                        <li class="sem"><input type="text" name="time" value="2" disabled="disabled" ></li>
                        <li class="year"><input type="text" name="time" value="1" disabled="disabled" ></li>
                        <li class="edit">Edit</li>
                        <li class="delete">Delete</li>
                    </ul> -->
                </div>

            </div>

        </div>

    </article>

<?php

require_once './footer.php';

?>