<?php 
include ('function.php');

if(isset($_GET['GID']) && $_GET['GID'] != ""){

    $GID = $_GET['GID'];

}else{
    header('location: ./');
}


######### Fetch data #########
$ListG = $Website->SelectGallery($Connection,$GID,'','','','');
//$ListGallary = $Website->SelectGalleryImage($Connection,'',$GID,'','GalleryID','','');
######### Fetch data #########

$PageName = "گالری |  " . $DataSetting['bas_SiteName'];



?>

<?php include ('head.php');?>
<link rel="stylesheet" href="dist/css/gallery.css">
<body>
<!---------------------- HEADER START ----------------------->
<?php include ('header.php'); ?>
<!---------------------- HEADER END ----------------------->

<!---------------------- CONTENT START ----------------------->
<div class="body-content">
   
<section class="section-top">
        <div class="container">

        <h3><?php  echo  $ListG['1']['Name']; ?></h3>

            <div class="list-gallery">
                 
            <?php
            
                                     $GID = $ListG['1']['ID'];
                                        $ListGallary = $Website->SelectGalleryImage($Connection,'',$GID,'','GalleryID','','');
                        
                        
                                        for($j = 1, $iiMax = count($ListGallary); $j <= $iiMax; $j++) {              //Level 1
                                        ?>
                <div class="list-gallery_item">
                    <a href="AdminPanel/<?php echo $ListGallary[$j]['File']; ?>" target="_blank" class="item-gallery" style="padding:10px;">
                        <img class="item-gallery_img" src="AdminPanel/<?php echo $ListGallary[$j]['File']; ?>" alt="">
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
   
</div>
<!---------------------- CONTENT END ----------------------->
    


<!---------------------- FOOTER START ----------------------->
<?php include ('footer.php'); ?>
<!---------------------- FOOTER END ----------------------->


<!---------------------- MOBILE MENU START ----------------------->
<div class="nav-mobile">
    <button type="button" class="nav-mobile_close"></button>
    <aside class="nav-mobile_content">

    </aside>
</div>
<!---------------------- MOBILE MENU END ----------------------->


<script type="text/javascript" src="./dist/js/page.js"></script>
<script type="text/javascript" src="./dist/js/home.js"></script>
</body>
</html