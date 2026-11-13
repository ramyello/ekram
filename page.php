<?php 
include ('function.php');

if(isset($_GET['slug']) && $_GET['slug'] != "" && !is_numeric($_GET['slug'])){

    $Slug = $_GET['slug'];

######### Fetch data #########
$ListBlog = $Website->SelectPost($Connection,'','',$Slug,'','1','','','');
######### Fetch data #########

}elseif(isset($_GET['slug']) && $_GET['slug'] != "" && is_numeric($_GET['slug'])){

    $ID = $_GET['slug'];

######### Fetch data #########
$ListBlog = $Website->SelectPost($Connection,$ID,'','','','1','','','');
######### Fetch data #########
}else{
    header('location: ./');
}


//print_r($List);
$PageName = $ListBlog['1']['SEO_Title'] . " | " . $DataSetting['bas_SiteName'];
$PageText = $ListBlog['1']['SEO_Keywords'];
$PageDesc = $ListBlog['1']['SEO_Description'];
//$PageGallery = $ListBlog['1']['Gallery'];

######### Actions #########
if(isset($_POST['FormID'])){
    $FormSubmit = $Website->AddFormAnswer($Connection,$_POST['FormID']);
}
######### Actions #########

$BreadArray = array($DataSetting['bas_SiteName'] => './', $ListBlog['1']['Title']=> '');
######### Page init #########

if($ListBlog['1']['Gallery']['ID']){
    $ProductIcon = "";
    $GID = $ListBlog['1']['Gallery']['ID'];
    $ListGallery = $Website->SelectGalleryImage($Connection,'', $GID, '1', '', '', '');

    for($i = 1, $iMax = count($ListGallery); $i <= $iMax; $i++) {  
        if($ListGallery[$i]['Title'] == $ListBlog['1']['ID']){
            $ProductIcon = $ListGallery[$i]['File'];
        }
    }
}
?>


<?php include ('head.php');?>

<body>
<!---------------------- HEADER START ----------------------->
<?php include ('header.php'); ?>
<!---------------------- HEADER END ----------------------->

<!---------------------- CONTENT START ----------------------->
<div class="body-content">
    <?php if($ListBlog['1']['TypeFlag'] == 1){
        
    $file = str_replace(' ', '', preg_replace('/\s+/', '',strip_tags($ListBlog['1']['Context'])));

    $type = explode(".",$file);
        if($ListBlog['1']['CategoryID'] == 3){
        ?>
    
    <section class="">
            <div class="container-product">
                <div class="left-section">
                    <div class="slideshow-container" style="direction: rtl;"> 
                        <span class="prev" onclick="prevSlide()">&#10095;</span>
                        <img class="slide" src="<?php echo $file; ?>"  />
                        <span class="next" onclick="nextSlide()"> &#10094;</span>
                    </div>
                </div>
                <div class="right-section">
                    <div class="container-right">
                        
                        <div class="product-icon"><img src="AdminPanel/<?php echo $ProductIcon; ?>" alt="<?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Title_Lang2'];  }else{ echo $ListBlog['1']['Title']; } ?>   " width="60px" /></div>
                        <div class="product-title"><?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Title_Lang2'];  }else{ echo $ListBlog['1']['Title']; } ?>   </div>
                    </div>
                    <div class="content-right">
                        <p> <?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Content_Lang2'];  }else{ echo $ListBlog['1']['Content']; } ?></p>
                    </div>
                </div>
            </div>
        </section>

        
    <?php 

        }else {
    ?>    
    
    <?php if(end($type) == "mp4"){ ?>
       <section class="section-blue-title" >
     
        <video loop autoplay muted playsinline>
            <source src="<?php echo $file; ?>" type="video/mp4">
        </video>
        <div class="container">
            <div class="section-blue-title_container">
                <h2 class="section-blue-title_title">
                    <img src="AdminPanel/<?php echo $ProductIcon; ?>" alt="<?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Title_Lang2'];  }else{ echo $ListBlog['1']['Title']; } ?>   ">
                    <span><?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Title_Lang2'];  }else{ echo $ListBlog['1']['Title']; } ?>   </span>
                </h2>
            </div>
        </div>
    </section>
    
      <?php }else{ ?>
        <?php if(count($type) == 1){$file = $ListBlog['1']['Thumb']; } ?>
    <section class="section-blue-title" style="background-image: url('<?php echo $file; ?>');background-size: 100% ;background-repeat: no-repeat;">
     
        <video loop autoplay muted playsinline>
            <source poster="<?php echo $file; ?>" type="video/mp4">
        </video>
        <div class="container">
            <div class="section-blue-title_container">
                <h2 class="section-blue-title_title">
                <img src="AdminPanel/<?php echo $ProductIcon; ?>" alt="<?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Title_Lang2'];  }else{ echo $ListBlog['1']['Title']; } ?>   ">
                    <span><?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Title_Lang2'];  }else{ echo $ListBlog['1']['Title']; } ?>   </span>
                </h2>
            </div>
        </div>
    </section>
        <?php } ?>
        
    <section class="section-product" >
        <div class="container">
            <div class="section-product_image" >
                <img src="AdminPanel/<?php echo $ListBlog['1']['Thumb']; ?>" alt="<?php echo $ListBlog['1']['Title']; ?>">
             
            </div>
            <div class="section-product_image" >

             <h3 class="section-service_title" ><?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Title_Lang2'];  }else{ echo $ListBlog['1']['Title']; } ?>   </h3>
            </div>
            <div class="section-product_table">
                    <?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Content_Lang2'];  }else{ echo $ListBlog['1']['Content']; } ?>
            </div>
        </div>
    </section>
    
    <?php } }else{ 
        
        if($ListBlog['1']['Thumb'] != "") {?>
     <section class="section-image">
        <img width="100%" src="AdminPanel/<?php echo $ListBlog['1']['Thumb']; ?>" alt="<?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Title_Lang2'];  }else{ echo $ListBlog['1']['Title']; } ?>   " class="section-image_img">
    </section>
    <?php } ?>
    <section class="section-aboutt" >

        <div class="section-aboutt_container">
              <?php if($_SESSION['lang'] == 'en'){ echo $ListBlog['1']['Content_Lang2'];  }else{ echo $ListBlog['1']['Content']; } ?>
        </div>
    </section>
       <?php } ?>
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
</html