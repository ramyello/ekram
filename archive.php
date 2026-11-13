<?php 
include ('function.php');


 ######### Fetch data #########
$ListBlogs = $Website->SelectPost($Connection,'','','','1','1','ID','DESC','');
######### Fetch data #########

//print_r($List);
$PageName = " آرشیو وبلاگ  " . $DataSetting['bas_SiteName'];
$PageText = "";
$PageDesc = "";


?><!DOCTYPE html>

<html lang="en">

<?php include ('head.php');?>

<body>
    <!-- Preloader -->
    <div class="loader">
        <!-- Preloader inner -->
        <div class="loader-inner">
            <svg width="120" height="220" viewbox="0 0 100 100" class="loading-spinner" version="1.1" xmlns="http://www.w3.org/2000/svg">
               <circle class="spinner" cx="50" cy="50" r="21" fill="#ffffff" stroke-width="3"/>
            </svg>
        </div>
        <!-- End preloader inner -->
    </div>
    <!-- End preloader-->
    <!--Wrapper-->
    <div class="wrapper">
        <!--Header-->
        <?php include ('header.php') ;?>
        <!--End header-->
        <!--Hero section-->
        <section class="hero jarallax gradient-overlay gradient-overlay-dark" data-jarallax="">
            <img class="jarallax-img" src="assets/img/10.jpg" alt="">
            <!--Container-->
            <div class="container">
                <!--Row-->
                <div class="row justify-content-center">
                    <div class="col">
                        <div class=" text-center">
                            <h1 class=" font-alt text-white">بلاگ ها</h1>
                        </div>
                    </div>
                </div>
                <!--End row-->
            </div>
            <!--End container-->
            <svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" width="100%" height="100">
               <path d="M0 100 C40 0 60 0 100 100 Z"></path>
            </svg>
        </section>
        <!--End hero section-->
        <!--Blog full section-->
        <section class=" spacer-one-bottom-lg spacer-one-top-md">
            <!--Container-->
            <div class="container">
                <!--Row-->
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <?php
                        $RowNo = 0;
                        for($i = 1, $iMax = count($ListBlogs); $i <= $iMax; $i++) {              //Level 1
                        $RowNo++;
                        ?>
                        <article class="pr-lg-4 mb-4">
                            <div class="card card-article-large flex-md-row no-gutters">
                                <a href="مطلب-<?php echo $ListBlogs[$i]['Slug']; ?>" class="col-md-4">
                                    <img src="AdminPanel/<?php echo $ListBlogs[$i]['Thumb']; ?>" alt="<?php echo $ListBlogs[$i]['Title']; ?>" class="card-img-top card-img-display">
                                </a>
                                <div class="card-body d-flex flex-column col-auto p-4">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="small d-flex">
                                            <div class="mr-2">
                                                <a href="#"><?php echo $ListBlogs[$i]['Category']; ?>   ~    </a>
                                            </div>
                                            <span class="text-muted">  <?php echo $ListBlogs[$i]['CTJalali']; ?>   </span>
                                        </div>
                                      
                                    </div>
                                    <h2 class="h4  font-alt  flex-grow">
                                        <a href="مطلب-<?php echo $ListBlogs[$i]['Slug']; ?>"><?php echo $ListBlogs[$i]['Title']; ?> </a>
                                    </h2>
                                    <?php echo $ListBlogs[$i]['Context']; ?>   
                                    <div class="media align-items-center">
                                        <img class="avatar-xs rounded-circle mr-2" src="assets/img/avatar/1.jpg" alt="">
                                        <div class="media-body">
                                            <span class="small text-muted">توسط</span>
                                            <a class="small text-dark" href="#">ایفاچی  </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php  } ?>
                    </div>
                </div>
                <!--End row-->
            </div>
            <!--End container-->
            <!--Container-->
            <div class="container">
                <!--row
                <div class="row justify-content-center ">
                    <div class="col-md-auto">
                        <nav aria-label="Page navigation" class=" pt-5 mt-5">
                            <ul class="pagination mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">۱</a></li>
                                <li class="page-item"><a class="page-link" href="#">۲</a></li>
                                <li class="page-item"><a class="page-link" href="#">۳</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--End row-->
            </div>
            <!--End container-->
        </section>
        <hr class="my-0">
        <!--Newsletter section-->
        <!--End newsletter section-->
        <!--Footer-->
        <?php include('footer.php') ;?>
    <!--End footer-->
    <!--To the top-->
    <a class="scroll-to-top scroll" href="blog-full.html#wrapper"><span class=" fa fa-arrow-up top-icon "></span></a>
    <!-- End to the top -->
    </div>
    <!-- End wrapper-->
    <!--Javascript-->
    <script src="js/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-dropdownhover.min.js"></script>
    <script src="js/jquery.flexslider-min.js"></script>
    <script src="js/smooth-scroll.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/instafeed.min.js"></script>
    <script src="js/placeholders.min.js"></script>
    <script src="js/jarallax.min.js"></script>
    <script src="js/script.js"></script>
    <!-- Google analytics -->
    <!-- End google analytics -->
</body>

</html>