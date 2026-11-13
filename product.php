<?php
include('function.php');

if (isset($_GET['slug']) && $_GET['slug'] != "") {

    $Slug = $_GET['slug'];
} else {
   // header('location: ./');
}


######### Fetch data #########
$ListBlog = $Website->SelectPost($Connection, '', '', $Slug, '', '1', '', '', '');
######### Fetch data #########
//print_r($List);
$PageName = $ListBlog['1']['SEO_Title'] . " بلاک " . $DataSetting['bas_SiteName'];
$PageText = $ListBlog['1']['SEO_Keywords'];
$PageDesc = $ListBlog['1']['SEO_Description'];
//$PageGallery = $ListBlog['1']['Gallery'];

######### Actions #########
if (isset($_POST['FormID'])) {
    $FormSubmit = $Website->AddFormAnswer($Connection, $_POST['FormID']);
}
######### Actions #########

$BreadArray = array($DataSetting['bas_SiteName'] => './', $ListBlog['1']['Title'] => '');
######### Page init #########
?>


<?php include('head.php'); ?>

<link rel="stylesheet" href="dist/css/product.css">

<body>
    <!---------------------- HEADER START ----------------------->
    <?php include('header.php'); ?>
    <!---------------------- HEADER END ----------------------->

    <!---------------------- CONTENT START ----------------------->
    <div class="body-content">


        <section class="">
            <div class="container-product">
                <div class="left-section">
                    <div class="slideshow-container">
                        <span class="prev" onclick="prevSlide()">&#10095;</span>
                        <img class="slide" src="cube.jpg" alt="تصویر 1" />
                        <img class="slide" src="oval.jpg" alt="تصویر 2" />
                        <img class="slide" src="cube.jpg" alt="تصویر 3" />
                        <span class="next" onclick="nextSlide()"> &#10094;</span>
                    </div>
                </div>
                <div class="right-section">
                    <div class="container-right">
                        <div class="product-icon"><img src="icon.svg" width="60px" /></div>
                        <div class="product-title">عنوان محصول</div>
                    </div>
                    <div class="content-right">
                        <p><img  src="1.png" /></p>
                    </div>
                </div>
            </div>
        </section>


    </div>
    <!---------------------- CONTENT END ----------------------->



    <!---------------------- FOOTER START ----------------------->
    <?php include('footer.php'); ?>
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
    <script>

var slides = document.getElementsByClassName("slide");
var slideIndex = 0;

showSlide(slideIndex);

function showSlide(index) {
    if (index < 0) {
        slideIndex = slides.length - 1;
    } else if (index >= slides.length) {
        slideIndex = 0;
    } else {
        slideIndex = index;
    }

    for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slides[slideIndex].style.display = "block";
}

function prevSlide() {
    showSlide(slideIndex - 1);
}

function nextSlide() {
    showSlide(slideIndex + 1);
}
    </script>
</body>

</html>