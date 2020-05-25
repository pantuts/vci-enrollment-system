<?php
    require_once 'header.php';
?>

            <article class="homebody">

            <!-- amazing slider -->
            <?php

            function getAllImages($dir, &$arr){
                $files = scandir($dir);
                if(count($files) == 0){ return; }
                foreach($files as $file){
                    $fpath = $dir . '/' . $file;
                    if(is_dir($fpath)){
                        if($file == '.' || $file == '..') { continue; }
                        getAllImages($fpath, $arr);
                    }
                    else{
                        if(preg_match('/&acirc/', $file)){
                            continue;
                        }
                        array_push($arr, html_entity_decode($fpath));
                    }
                }
            }
            $images = array();
            getAllImages('./images/homeslide', $images);
            getAllImages('./images/gallery', $images);
            // var_dump($images)

            ?>
            <div id="amazingslider-1" style="display:block;position:relative;margin:16px auto 98px;">

                <ul class="amazingslider-slides" style="display:none;">
                <?php

                shuffle($images);
                foreach ($images as $img) {
                    $bname = explode('.', basename($img));
                    echo '<li><img src="' . $img .'" alt="' . $bname[0] . '" /></li>';
                }

                ?>
                </ul>
                <ul class="amazingslider-thumbnails" style="display:none;">
                <?php

                // shuffle($images);
                foreach ($images as $img) {
                    $bname = explode('.', basename($img));
                    echo '<li><img src="' . $img .'" alt="' . $bname[0] . '" /></li>';
                }

                ?>
                </ul>

                <!-- <ul class="amazingslider-slides" style="display:none;">
                    <li><img src="images/homeslide/SAM_0431.JPG" alt="logo" /></li>
                    <li><img src="images/homeslide/SAM_0432.JPG" alt="The New Building of Veritas College of Irosin" /></li>
                    <li><img src="images/homeslide/SAM_0433.JPG" alt="Gate1 of VCI" /></li>
                    <li><img src="images/homeslide/SAM_0435.JPG" alt="New windows" /></li>
                    <li><img src="images/homeslide/SAM_0436.JPG" alt="Computer Laboratory 1" /></li>
                </ul>
                <ul class="amazingslider-thumbnails" style="display:none;">
                    <li><img src="images/homeslide/SAM_0431.JPG" alt="logo" /></li>
                    <li><img src="images/homeslide/SAM_0432.JPG" alt="The New Building of Veritas College of Irosin" /></li>
                    <li><img src="images/homeslide/SAM_0433.JPG" alt="Gate1 of VCI" /></li>
                    <li><img src="images/homeslide/SAM_0435.JPG" alt="New windows" /></li>
                    <li><img src="images/homeslide/SAM_0436.JPG" alt="Computer Laboratory 1" /></li>
                </ul> -->

            </div>
            <!-- end amazing slider -->

            <!-- month events -->
            <?php

            $t = new DateTime('@' . time());
            $year = $t->format('Y');
            $month = $t->format('F');
            $day = $t->format('d');

            require_once './config.php';

            $sql = 'select * from calevents where month=:m and year=:y order by day';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':m' => $month, ':y' => $year));

            ?>
            <div class="month-events rounded default-skin">

                <p class="rounded">Events for the Month of <?php echo $month ?></p>
                
                <?php

                $i = 0;
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                    if ($row->day >= $day) {
                        echo '<ul class="me-ul">';
                        echo '<li class="date"><span>' . $row->day . '</span></li>';
                        echo '<li class="event">' . $row->event .'</li>';
                        echo '</ul>';
                        $i++;
                    }
                }
                $stmt->closeCursor();
                $pdo = null;
                echo '<p class="events-count" style="display:none;">' . $i . '</p>';

                ?>

                <!-- <ul class="me-ul">
                    <li class="date"><span>1</span></li>
                    <li class="event">New year daw sabe ni Rexy Judin, baw</li>
                </ul> -->

            </div>
            <!-- end month events -->

        </article>

        <article class="message">
            
            <!-- message, history -->

            <div class="container-beforefooter rounded">
                
                <div class="beforefooter rounded">
                    <ul>
                        <li class="title">Message</li>
                        <li class="picture"><img src="images/homeboxes/priest.png"></li>
                        <li class="content">
                        <p> Certainly the promise made to Veritans and that they would inherit the world not depend on the law; it was made in view of the justice that come from faith.
                        </li> 
                        <!-- <li class="more"><a href="">more</a></li> -->
                    </ul>
                </div>
                <div class="beforefooter rounded">
                    <ul>
                        <li class="title">History</li>
                        <li class="picture"><img src="./images/historybg-small.gif" /></li>
                        <li class="sub"></li>
                        <li class="content">
                            Veritas College of Irosin
                            has its own histories which
                            identifies who were involved
                            in the efforts undertaken in order to
                            reach the goals it aimed to achieve<br/><br/>
                            In1983, Mayor Roque G.
                            Dorotan of Irosin approached
                        </li>
                        <li class="more"><a href="<?php echo $rootfolder . 'about/history.php';  ?>">more</a></li>
                    </ul>
                </div>

                <div class="beforefooter rounded">
                    <ul>
                        <li class="title">Addmission</li>
                        <li class="picture"><img src="images/homeboxes/common.png"></li>
                        <li class="sub">Requirements</li>
                        <li class="content">
                        2 pcs (1x1 ID Picture)<br/>
                            Photocopied B-Certificate from NSO<br/>
                            Form 138 or School Card<br/>
                            NCAE Result<br/>
                            Cert. Of Good Moral Character<br/>
                            Brgy. Clearance<br/>
                            Police Clearance<br/>
                            1 pc. Short Brown Envelop<br/>
                        </li>
                        <li class="more"><a href="<?php echo $rootfolder . 'admission.php';  ?>">more</a></li>
                    </ul>
                </div>

            </div>

            <div class="container-beforefooter rounded">
                
                <div class="beforefooter rounded">
                    <ul>
                        <li class="title">Courses</li>
                        <li class="picture"><img src="images/homeboxes/common.png"></li>
                        <li class="sub">Courses Offered:</li>
                        <li class="content">
                            BS in Information Technology <br/>
                            BS in Computer Science <br/>
                            BS in Criminology <br/>
                            BS in Business Administration <br/>
                            Bachelor of Elementary Education <br/>
                            Bachelor of Secondary Education<br/><br/>
                        
                        <li class="sub">Vocational Course:</li>
                        <li class="content">
                            Building Wiring Intallation<br/>
                            Automotive<br/>
                        </li>
                        <li class="more"><a href="<?php echo $rootfolder . 'courses.php';  ?>">more</a></li>
                    </ul>
                </div>

                <div class="beforefooter rounded">
                    <ul>
                        <li class="title">Gallery</li>
                        <li class="picture"><img src="images/homeboxes/common.png"></li>
                        <li class="sub"></li>
                        <li class="content">
                            Veritas College of Irosin
                            has its own histories which
                            identifies who were involved
                            in the efforts undertaken in order to
                            reach the goals it aimed to achieve<br/><br/>
                            In1983, Mayor Roque G.
                            Dorotan of Irosin approached
                        </li>
                        <li class="more"><a href="<?php echo $rootfolder . 'gallery.php';  ?>">more</a></li>
                    </ul>
                </div>

                <div class="beforefooter rounded">
                    <ul>
                        <li class="title">Online Registration</li>
                        <li class="picture"><img src="images/homeboxes/common.png"></li>
                        <li class="sub">Pre-Registration</li>
                        <li class="content">
                        SIGN UP NOW!!!!!!!!<br/>
                        New And Old Students..
                        </li>
                        <li class="more"><a href="<?php echo $rootfolder . 'student/register-login.php';  ?>">more</a></li>
                    </ul>
                </div>

            </div>

            <!-- end message, history -->

        </article>

<?php
    require_once 'footer.php';
?>