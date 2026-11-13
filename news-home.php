<?php
######### Fetch data #########
$ListNews = $Website->SelectPost($Connection,'','1','','4','1','ID','DESC','5');
######### Fetch data #########
?>

    <section class="section-gray">
        <div class="container">
            <h5 class="section-gray_title title-section"><?php if($_SESSION['lang'] == 'en'){ echo  "News";  }else{ echo "اخبار"; } ?></h5>
        </div>
        <div class="slider-news">
            <div class="owl-carousel" id="slider_news">
               <?php
                $RowNo = 0;
                for($i = 1, $iMax = count($ListNews); $i <= $iMax; $i++) {              //Level 1
                $RowNo++;
                ?>
                <div class="item">
                    <a href="page-<?php echo $ListNews[$i]['Slug']; ?>" class="item-news">
                        <img src="AdminPanel/<?php echo $ListNews[$i]['Thumb']; ?>" height="233px" alt=" <?php if($_SESSION['lang'] == 'en'){ echo $ListNews[$i]['Title_Lang2'];  }else{ echo $ListNews[$i]['Title']; } ?> " class="item-news_img">
                        <div class="item-news_text">
                            <h6 class="item-news_title">
                            <?php if($_SESSION['lang'] == 'en'){ echo $ListNews[$i]['Title_Lang2'];  }else{ echo $ListNews[$i]['Title']; } ?>   
                 
                            </h6>
                            <p class="item-news_description">
                            <?php if($_SESSION['lang'] == 'en'){ echo strip_tags($ListNews[$i]['Context_Lang2']);  }else{ echo strip_tags($ListNews[$i]['Context']); } ?>   
                 
                            </p>
                        </div>
                    </a>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>