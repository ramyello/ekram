<?php
######### Fetch data #########
$List = $Website->SelectSlideshowImage($Connection,'','1','1','Priority','','');
######### Fetch data #########
?>
    <section class="section-home">
        <?php
        $RowNo = 0;
        for ($i = 1, $iMax = count($List);
             $i <= $iMax;
             $i++) {              //Level 1
            $RowNo++;
        ?>
        <video loop autoplay muted playsinline>
            <source src="images/sample/pariyan.mp4" type="video/mp4">
        </video>
        
        <div class="section-home_container">
             <?php /* <div class="section-home_content">
                <div class="section-home_top">
                    <div>
                        <img src="./images/logo-gray.png" alt="Tabriz can" class="section-home_top-logo">
                    </div>
                    <div class="section-home_top-content">
                        <span class="section-home_top-title">
                            You CAN <strong>Trust</strong> Us
                        </span>
                        <h3 class="section-home_top-description">
                            we are a family company, which means that the change
                            of generation has caused the continuation of the work
                            process at this place, and we are never closed.
                        </h3>
                    </div>
                </div>
                <div class="section-home_bottom">
                    <h2 class="section-home_bottom-title">Tabriz can</h2>
                    <div class="section-home_text">
                        <h6 class="section-home_text-item active" data-time="1000">Litography</h6>
                        <h6 class="section-home_text-item" data-time="2000">Printing</h6>
                        <h6 class="section-home_text-item" data-time="1000">body Making</h6>
                    </div>
                </div>
            </div> */ ?>
        </div>
            <?php
        }
        ?>

    </section>