<?php
include ('function.php');

$PageName =  $DataSetting['bas_SiteName'];
$PageText = $DataSetting['bas_SiteTitle'];
$PageDesc = '';


include ('head.php'); ?>
<?php
######### Fetch data #########
$ListGalleryPage = $Website->SelectPost($Connection,'','2','','5','1','ID','DESC','');


######### Fetch data #########
?>
<link rel="stylesheet" href="dist/css/gallery.css">
<body>
<!---------------------- HEADER START ----------------------->
<?php include ('header.php'); ?>
<!---------------------- HEADER END ----------------------->

<!---------------------- CONTENT START ----------------------->
<div class="body-content">
    <?php
    ######### Fetch data #########
    $ListGallery = $Website->SelectBanner($Connection,'','3','1','Priority','','');
    ######### Fetch data #########
    ?>
   

    <section class="section-top">
        <div class="container">
            <div class="list-gallery">
            <?php
                $RowNo = 0;
                for($i = 1, $iMax = count($ListGalleryPage); $i <= $iMax; $i++) {              //Level 1
                $RowNo++;
                ?>
                <div class="list-gallery_item">
                    <a href="gallery-single.php?GID=<?php echo $ListGalleryPage[$i]['Gallery']['ID']; ?>" class="item-gallery">
                        <img class="item-gallery_img" src="AdminPanel/<?php echo $ListGalleryPage[$i]['Thumb']; ?>" alt="<?php echo $ListGalleryPage[$i]['Title']; ?>">
                        <h3 class="item-gallery_title" ><?php if($_SESSION['lang'] == 'en'){ echo $ListGalleryPage[$i]['Title_Lang2'];  }else{ echo $ListGalleryPage[$i]['Title']; } ?></h3>
                    </a>
                </div><?php
                            }
                            ?>
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

<!---------------------- MODAL START ----------------------->
<?php /*
<button type="button" class="modal-contact_toggle">
    Send Email
</button>

<div class="modal-contact">
    <div class="modal-contact_content">
        <button class="modal-contact_close">
            <img src="./images/icons/close.svg" alt="">
        </button>

        <h6 class="modal-contact_title">Send and email to us</h6>

        <form action="" class="modal-contact_form">
            <div class="input-row">
                <label for="subject" class="input-row_label">Subject</label>
                <div class="input-row_content">
                    <input type="text" id="subject" name="subject" required
                           class="input">
                </div>
            </div>
            <div class="input-row">
                <label for="email" class="input-row_label">Email Address</label>
                <div class="input-row_content">
                    <input type="email" required id="email"
                           class="input">
                </div>
            </div>
            <div class="input-row">
                <div class="input-row_content">
                    <textarea name="message" id="message" rows="5" required class="input-textarea"></textarea>
                </div>
            </div>
            <button class="button button-orange">Send</button>
        </form>
    </div>
</div> */ ?>
<!---------------------- MODAL END ----------------------->

<script type="text/javascript" src="./dist/js/page.js"></script>
<script type="text/javascript" src="./dist/js/home.js"></script>
</body>
</html>
