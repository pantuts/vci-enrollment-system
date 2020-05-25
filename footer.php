<?php

// check whether the script is in root directory
if (dirname($_SERVER['PHP_SELF']) == '/vci') {
    $rootfolder = './';
} else {
    $rootfolder = '../';
}

?>

        <footer class="rounded">
            
            <div class="footmenu">
                <ul>
                    <li><a href="<?php echo $rootfolder . 'index.php';  ?>" title="">Home</a></li>
                    <li><a href="<?php echo $rootfolder . 'about/history.php';  ?>" title="">About Us</a></li>
                    <li><a href="<?php echo $rootfolder . 'admission.php';  ?>" title="">Admission</a></li>
                    <li><a href="<?php echo $rootfolder . 'courses.php';  ?>" title="">Courses</a></li>
                    <li><a href="<?php echo $rootfolder . 'gallery.php';  ?>" title="">Veritans</a></li>
                    <li><a href="<?php echo $rootfolder . 'student/register-login.php';  ?>" title="">Online Registration</a></li>
                </ul>
            </div>

            <div class="copyr">
                <p>Veritas College of Irosin @ 2014</p>
            </div>

            <div class="feeds">
                <ul>
                    <li><a href=""><img src="<?php echo $rootfolder; ?>images/feeds/fb.png"></a></li>
                    <li><a href=""><img src="<?php echo $rootfolder; ?>images/feeds/gmail.png"></a></li>
                    <li><a href=""><img src="<?php echo $rootfolder; ?>images/feeds/twitter.png"></a></li>
                </ul>
            </div>

        </footer>

    </div>
    <!-- END CONTAINER  -->
    
    <script src="<?php echo $rootfolder; ?>scriptsjquery-ui-1.10.3.min.js"></script>
    <script src="<?php echo $rootfolder; ?>scriptsjquery/jquery.easing.1.3.js"></script>
    <script src="<?php echo $rootfolder; ?>scripts/amazingslider/initslider-1.js"></script>
    <script src="<?php echo $rootfolder; ?>scripts/amazingslider/amazingslider.js"></script>
    <script src="<?php echo $rootfolder; ?>scripts/modernizr-2.6.2.min.js"></script>
    <script src="<?php echo $rootfolder; ?>scripts/jquery.custom-scrollbar.js"></script>
    <script src="<?php echo $rootfolder; ?>scripts/html2canvas.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.hist .para').customScrollbar();
            var ec = $('.homebody .month-events p.events-count').text();
            if (ec > 9) {
                $('.homebody .month-events').customScrollbar();
            }
            $('span.topdf').click(function(event) {
                html2canvas($('.vform'), {
                    onrendered: function(canvas) {
                        // canvas is the final rendered <canvas> element
                        var ctx=canvas.getContext("2d");
                        ctx.webkitImageSmoothingEnabled = true;
                        ctx.mozImageSmoothingEnabled = true;
                        ctx.imageSmoothingEnabled = true;
                        var myImage = canvas.toDataURL("image/jpg");
                        window.open(myImage);
                    }
                });
            });
        });
    </script>

</body>
</html>