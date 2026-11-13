<?php
    ######### Fetch data #########
    $ListIso = $Website->SelectBanner($Connection,'','6','1','Priority','','8');
    ######### Fetch data #########
    ?>

    <section   id="contact"  class="section-contact">
    <div class="section-contact_video">
            <video loop autoplay muted playsinline>
                <source src="images/sample/tabriz.mp4" type="video/mp4">
            </video>
        </div>
        <div class="section-contact_information">
            <div class="section-contact_top">
                <h5 class="section-contact_title title-section title-section_dark"><?php if($_SESSION['lang'] == 'en'){ echo  "Contact Us";  }else{ echo "تماس با ما"; } ?></h5>
            </div>
            <div class="section-contact_center">
                <ul class="section-contact_list list-contact">
                    
                  
                    <li class="list-contact_item">
                        <div class="list-contact_icon">
                            <img src="./images/icons/location.svg" alt="">
                        </div>
                        <a href="" class="list-contact_info">
                        <?php if($_SESSION['lang'] == 'en'){ echo  "15th Km of Tehran Road, Tabriz, Iran";  }else{ echo  $DataSetting['bas_Address']; } ?>
                         
                        </a>
                    </li>
                   
                    <li class="list-contact_item">
                        <div class="list-contact_icon">
                            <img src="./images/icons/phone.svg" alt="">
                        </div>
                        <a href="" class="list-contact_info">
                           <?php echo $DataSetting['bas_Tel']; ?>
                        </a>
                    </li>
                    <li class="list-contact_item">
                        <div class="list-contact_icon">
                            <img src="./images/icons/mail.svg" alt="">
                        </div>
                        <a href="" class="list-contact_info">
                           <?php echo $DataSetting['email_Username']; ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="section-contact_bottom">
                <ul class="section-contact_logos list-logo">
                         <?php
                                $RowNo = 0;
                                for($i = 1, $iMax = count($ListIso); $i <= $iMax; $i++) {              //Level 1
                                $RowNo++;
                                ?>
                    <li class="list-logo_item">
                        <a href="<?php echo $ListIso[$i]['Link']; ?>" class="list-logo_link">
                            <img src="AdminPanel/<?php echo $ListIso[$i]['File']; ?>" alt="<?php echo $ListIso[$i]['Title']; ?>" class="list-logo_img">
                        </a>
                    </li>
                      <?php
                            }
                            ?>
                  
                   
                </ul>
            </div>
        </div>
    </section>