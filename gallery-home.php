<?php
    ######### Fetch data #########
    $ListGallery = $Website->SelectBanner($Connection,'','3','1','Priority','','8');
    ######### Fetch data #########
    ?>

<section class="section-lineq">
        <h5 class="section-line_title title-section">
        </h5>
        <div class="slider-gallery">
            <div class="owl-carousel" id="slider_gallery">
                <?php
                                $RowNo = 0;
                                for($i = 1, $iMax = count($ListGallery); $i <= $iMax; $i++) {              //Level 1
                                $RowNo++;
                                ?>
                <div class="item">
                    <a href="<?php echo $ListGallery[$i]['Link']; ?>" class="item-gallery-slider">
                        <img src="AdminPanel/<?php echo $ListGallery[$i]['File']; ?>" alt="<?php echo $ListGallery[$i]['Title']; ?>" class="item-gallery_img">
                    </a>
                </div>
                      <?php
                            }
                            ?>
            </div>
        </div>
    </section>