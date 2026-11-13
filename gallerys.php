<?php 
include ('function.php');




 
//print_r($List);
$PageName = " بیلبورد های تبلیغاتی  " . $DataSetting['bas_SiteName'];
$PageText = "";
$PageDesc = "";


?>

<!DOCTYPE html>
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
        <section class="hero ">
            <div class="background-img  gradient-overlay gradient-overlay-dark">
                <img class="" src="assets/img/11.jpg" alt="">
            </div>
            <!--Container-->
            <div class="container">
                <!--Row-->
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                    <ol class="breadcrumb mb-0  justify-content-center">
                                    <li class="breadcrumb-item"><a href="./">صفحه نخست</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"></li>
                                </ol>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <nav aria-label="breadcrumb">
                                
                            </nav>
                        </div>
                        <h1 class="font-alt text-white mb-3"></h1>
                     
                    </div>
                </div>
                <!--End row-->
            </div>
            <!--End container-->
            <svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none" width="100%" height="100">
               <path d="M0 100 C40 0 60 0 100 100 Z"></path>
            </svg>
        </section>
        <!--SIngle article section-->
        <section class=" spacer-one-bottom-lg spacer-one-top-md">
            <!--Container-->
            <div class="container">
                <!--Row-->
                <div class="row card-gutters">

                 <?php
                  ######### Fetch data #########
                    $List = $Website->SelectBanner($Connection,'','1','1','Priority','','');
                    ######### Fetch data #########
                                $RowNo = 0;
                                for($i = 1, $iMax = count($List); $i <= $iMax; $i++) {              //Level 1
                                $RowNo++;
                                ?>
            <div class="col-sm-6 col-lg-3 mb-2  ">
                <div class="grid-item card border-0">
                    <a href="AdminPanel/<?php echo $List[$i]['File']; ?>" class="hover-effect mb-0 popup-image ">
                        <img class="card-img" src="AdminPanel/<?php echo $List[$i]['File']; ?>" alt="<?php echo $List[$i]['Name']; ?>">
                        <span class="hover-effect-container">
                        <span class="hover-effect-icon">
                        <span class="fa fa-plus hover-effect-icon-inner ffaa20"></span>                                
                        </span>                                
                        </span>                            
                    </a>   
                    <span class="label-title mb-3"><?php echo $List[$i]['Name']; ?></span>
                </div>
            </div>
                    <?php
                            }
                            ?>
                </div>
                <!--End row-->
            </div>
            <!--End container-->
            <!--Container-->

      
            </div>
        </section>

        <!--Footer-->
       <?php include ('footer.php');?>
    <!--End footer-->
    <!--To the top-->
    <a class="scroll-to-top scroll" href="#wrapper"><span class=" fa fa-arrow-up top-icon "></span></a>
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