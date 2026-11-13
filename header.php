<?php

######### Fetch data #########
$List = $Website->SelectMenu('','','1','1','','','1','Priority','ASC','');
######### Fetch data #########
######### Fetch data #########
$Download = $Website->SelectMenu('','','2','1','','','1','Priority','ASC','');
######### Fetch data #########
?>

<header class="body-header">
    <div class="body-header_container container-full">
        <!---------------------- HEADER LOGO START ----------------------->
        <div class="body-header_content-start">
            <a href="" class="body-header_title">
                <img src="AdminPanel/<?php echo $DataSetting['web_Logo']; ?>" alt="<?php echo $DataSetting['bas_SiteTitle']; ?>" width="44px" class="body-header_title-logo">
                <h1 class="body-header_title-text"><?php if($_SESSION['lang'] == 'en'){ echo  "Paryan Plast";  }else{ echo $DataSetting['bas_SiteTitle']; } ?></h1>
            </a>
        </div>
        <!---------------------- HEADER LOGO END ----------------------->
        <!---------------------- HEADER NAV START ----------------------->
        <div class="body-header_content-center mobile-screen-hide">
            <nav role="navigation" class="list-nav">
                <ul class="list-nav_list">
                      <?php
                            $RowNo = 0;
                            for($i = 1, $iMax = count($List); $i <= $iMax; $i++) {   //Level 1
                            $RowNo++;
                        ?>
                    <li class="list-nav_item  <?php if (isset($List[$i]['Child'])) { ?> list-nav_drop-content<?php  } ?>">
                        <a href="<?php echo $List[$i]['Link']; ?>" class="list-nav_link">
                            <?php if($_SESSION['lang'] == 'en'){ echo $List[$i]['Title_Lang2']; }else{ echo $List[$i]['Title']; } ?>
                       
                        </a>
                        <?php if (isset($List[$i]['Child'])) { //Level 2 ?>
                        <ul class="list-nav_drop-list">
                            <?php /* <li class="list-nav_drop-item">
                                <h5 class="list-nav_drop-title">All Products</h5>
                            </li>
                            */ ?>
                            <?php for ($x = 1, $xMax = count($List[$i]['Child']); $x <= $xMax; $x++) {
                                  $RowNo++;
                                 ?>
                            <li class="list-nav_drop-item">
                                <a href="<?php echo $List[$i]['Child'][$x]['Link']; ?>" class="list-nav_drop-link">
                                <?php if($_SESSION['lang'] == 'en'){ echo  $List[$i]['Child'][$x]['Title_Lang2']; }else{ echo  $List[$i]['Child'][$x]['Title']; } ?>
                                </a>
                            </li>
                            <?php  }  ?> 
                        </ul>
                         <?php  }  ?>
                    </li>
                    <?php  } ?>
                    
                    <li class="list-nav_item-download">
                        <a href="<?php echo $Download[1]['Link']; ?>" class="list-nav_link-download">
                        <?php if($_SESSION['lang'] == 'en'){ echo $Download[1]['Title_Lang2']; }else{ echo $Download[1]['Title']; } ?>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!---------------------- HEADER NAV END ----------------------->
        <!---------------------- HEADER HELPER START ----------------------->
        <div class="body-header_content-end">
            <ul class="list-language">
                <li class="list-language_item mobile-screen-visible">
                    <a href="javascript:;" class="list-language_link-icon nav-mobile_toggle">
                        <img src="./images/icons/menu.svg" alt="">
                    </a>
                </li>
                <li class="list-language_item">
                    <a href="" class="list-language_link-icon header-search_toggle">
                        <img src="./images/icons/search.svg" alt="">
                    </a>
                </li>

                <!--- Language list for mobile screen Start --->
                <li class="list-language_item dropdown big-screen_hide">

                    <!--- Selected language --->
                    <a href="javascript:;" class="list-language_link active">
                        AR
                    </a>

                    <!--- Others --->
                    <ul class="drop-list">
                        <li>
                            <a href="./?en" class="list-language_link">
                                EN
                            </a>
                        </li>
                        <li>
                            <a href="./?ir" class="list-language_link">
                                FA
                            </a>
                        </li>
                        <li>
                            <a href="" class="list-language_link">
                                RU
                            </a>
                        </li>
                        <li>
                            <a href="" class="list-language_link">
                                TR
                            </a>
                        </li>
                    </ul>
                </li>
                <!--- Language list for mobile screen End --->


                <!--- Language list for big screen Start --->
                <!--- You must add active class to active language like en here --->
                <li class="list-language_item big-screen_visible">
                    <a href="" class="list-language_link">
                        AR
                    </a>
                </li>
                <li class="list-language_item big-screen_visible">
                    <a href="./?en" class="list-language_link active">
                        EN
                    </a>
                </li>
                <li class="list-language_item big-screen_visible">
                    <a href="./?ir" class="list-language_link">
                        FA
                    </a>
                </li>
                <li class="list-language_item big-screen_visible">
                    <a href="" class="list-language_link">
                        RU
                    </a>
                </li>
                <li class="list-language_item big-screen_visible">
                    <a href="" class="list-language_link">
                        TR
                    </a>
                </li>
                <!--- Language list for big screen End --->
            </ul>
        </div>
        <!---------------------- HEADER HELPER END ----------------------->
    </div>
    <form action="" class="header-search">
        <div class="container-full">
            <input type="text" id="search" name="search" placeholder="Search...">
            <button type="submit">
                <img src="./images/icons/search.svg" alt="">
            </button>
            <button type="button" class="header-search_toggle">
                <img src="./images/icons/close.svg" alt="">
            </button>
        </div>
    </form>
</header>