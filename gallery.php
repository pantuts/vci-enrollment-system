<?php

require_once 'header.php';

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

<div class="gallery">
    <?php

    shuffle($images);
    foreach ($images as $img) {
        $bname = explode('.', basename($img));
        echo '<a href="' . $img . '" rel="gallery" class="fancybox" title="' . $bname[0] . '">';
        echo '<img src="'. $img . '">';
        echo '</a>';
    }

    ?>
    <!-- <a href="./images/homeslide/SAM_0442.JPG" rel="gallery" class="fancybox" title="test">
        <img src="./images/homeslide/SAM_0442.JPG">
    </a>-->
</div>

<script>
    $(function(){
        $('.fancybox').fancybox({
            padding : 0,
            openEffect  : 'elastic'
        });
    });
</script>

<?php require_once 'footer.php'; ?>
