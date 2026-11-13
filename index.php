<?php

include ('function.php');

$PageName =  $DataSetting['bas_SiteName'];
$PageText = $DataSetting['bas_SiteTitle'];
$PageDesc = '';


include ('head.php'); ?>

<body>
<!---------------------- HEADER START ----------------------->
<?php include ('header.php'); ?>
<!---------------------- HEADER END ----------------------->

<!---------------------- CONTENT START ----------------------->
<div class="body-content">

    <!---------------------- SLIDER START ----------------------->
    <?php include ('slider.php'); ?>
    <!---------------------- SLIDER END ----------------------->

    <!---------------------- PRODUCTS START ----------------------->
     <?php /* include ('product-home.php'); */ ?>
    <!---------------------- PRODUCTS END ----------------------->

    <!---------------------- ABOUT START ----------------------->
     <?php include ('about-home.php'); ?>
    <!---------------------- PRODUCTS END ----------------------->

    <!---------------------- SERVICES START ----------------------->
    <?php include ('service-home.php'); ?>
    <!---------------------- SERVICES END ----------------------->

    <!---------------------- GALLERY START ----------------------->
    <?php include ('gallery-home.php'); ?>
    <!---------------------- GALLERY END ----------------------->
   
    <!---------------------- SCROLL START ----------------------->
    <?php include ('scroll-home.php'); ?>
    <!---------------------- SCROLL END ----------------------->

    <!---------------------- MARKETING START ----------------------->
     <?php include ('marketing-home.php'); ?>
    <!---------------------- MARKETING END ----------------------->


    <!---------------------- GREEN START ----------------------->
    <?php include ('green-home.php'); ?>
    <!---------------------- GREEN END ----------------------->


    <!---------------------- NEWS START ----------------------->
     <?php include ('news-home.php'); ?>
    <!---------------------- NEWS END ----------------------->

   
    <!---------------------- CLIENTS START ----------------------->
    <?php include ('client-home.php'); ?>
    <!---------------------- CLIENTS END ----------------------->

    <!---------------------- CONTACT START ----------------------->
    <?php include ('contact-home.php'); ?>
    <!---------------------- CONTACT END ----------------------->

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
</div>

<!-- S1 -->
<div class="modal-service">
    <div class="modal-service_content">
        <button class="modal-service_close">
            <img src="./images/icons/close.svg" alt="">
        </button>

        <video style="width: 100%;" loop autoplay muted playsinline>
            <source src="images/0-0.mp4" type="video/mp4">
        </video>
    </div>
</div> 
<!-- S2 -->
<div class="modal-service1">
    <div class="modal-service1_content">
        <button class="modal-service1_close">
            <img src="./images/icons/close.svg" alt="">
        </button>

        <video style="width: 100%;" loop autoplay muted playsinline>
            <source src="images/1-1.mp4" type="video/mp4">
        </video>
    </div>
</div> 
<!-- S3 -->
<div class="modal-service2">
    <div class="modal-service2_content">
        <button class="modal-service2_close">
            <img src="./images/icons/close.svg" alt="">
        </button>

        <video style="width: 100%;" loop autoplay muted playsinline>
            <source src="images/2-2.mp4" type="video/mp4">
        </video>
    </div>
</div> 
<!---------------------- MODAL END ----------------------->

<script type="text/javascript" src="./dist/js/page.js"></script>
<script type="text/javascript" src="./dist/js/home.js"></script>
</body>
</html>
