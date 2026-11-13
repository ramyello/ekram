
<?php
    ######### Fetch data #########
    $ListSocialMedia = $Website->SelectBanner($Connection,'','5','1','Priority','','8');
    
    $OurCompany = $Website->SelectMenu('','','4','1','','','1','Priority','ASC','');
    
    $Footer = $Website->SelectMenu('','','3','1','','','1','Priority','ASC','');
    ######### Fetch data #########
    
    
?>
<footer class="body-footer">
    <div class="body-footer_container">
        <div class="body-footer_col body-footer_col-contact">
            <div>
                <div class="footer-contact">
                    <span class="footer-contact_title title-footer">
                    <?php if($_SESSION['lang'] == 'en'){ echo  "Social media";  }else{ echo "شبکه های مجازی"; } ?>
                    </span>
                    <div class="footer-contact_body">
                        <ul class="list-social">
                             <?php
                                $RowNo = 0;
                                for($i = 1, $iMax = count($ListSocialMedia); $i <= $iMax; $i++) {              //Level 1
                                $RowNo++;
                                ?>
                            <li class="list-social_item">
                                <a href="<?php if($_SESSION['lang'] == 'en'){ echo $ListSocialMedia[$i]['Link_Lang2']; }else{ echo $ListSocialMedia[$i]['Link']; } ?>" class="list-social_link">
                                    <img src="AdminPanel/<?php echo $ListSocialMedia[$i]['File']; ?>" alt="<?php if($_SESSION['lang'] == 'en'){ echo $ListSocialMedia[$i]['Title_Lang2']; }else{ echo $ListSocialMedia[$i]['Title']; } ?>">
                                </a>
                            </li>
                              <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="footer-contact">
                    <span class="footer-contact_title title-footer">
                    <?php if($_SESSION['lang'] == 'en'){ echo  "NewsLetter";  }else{ echo "خبرنامه"; } ?>  
                    </span>
                    <div class="footer-contact_body">
                        <form action="" class="footer-subscribe">
                            <input type="email" required
                                   placeholder="Email Address"
                                   class="footer-subscribe_input input">
                            <button type="submit"
                                    class="footer-subscribe_button button"><?php if($_SESSION['lang'] == 'en'){ echo  "Submit";  }else{ echo "ثبت نام"; } ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="body-footer_col body-footer_col-others">
            <div class="footer-others">
                <span class="footer-others_title title-footer"> <?php if($_SESSION['lang'] == 'en'){ echo  "Other Companies";  }else{ echo "سایر شرکت ها"; } ?> </span>
                <ul class="footer-others_list list-company">
                    <li class="list-company_item">
                        <?php
                            $RowNo = 0;
                            for($i = 1, $iMax = count($OurCompany); $i <= $iMax; $i++) {   //Level 1
                            $RowNo++;
                        ?>
                        <a href="<?php echo $OurCompany[$i]['Link']; ?>" class="list-company_link">
                            <img src="AdminPanel/<?php echo $OurCompany[$i]['Icon']; ?>" alt="<?php echo $OurCompany[$i]['Title']; ?>" class="list-company_link-img">
                            <span class="list-company_link-title"><?php if($_SESSION['lang'] == 'en'){ echo $OurCompany[$i]['Title_Lang2']; }else{ echo $OurCompany[$i]['Title']; } ?></span>
                        </a>
                        <br>
                         <?php  } ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="body-footer_col body-footer_col-menu">
            <div class="footer-menu-container">
                <span class="footer-menu-container_title title-footer"><?php if($_SESSION['lang'] == 'en'){ echo  "Information";  }else{ echo "دسترسی سریع"; } ?></span>
                <ul class="footer-menu-container_list list-footer">
                     <?php
                            $RowNo = 0;
                            for($i = 1, $iMax = count($Footer); $i <= $iMax; $i++) {   //Level 1
                            $RowNo++;
                        ?>
                    <li class="list-footer_item">
                        <a href="<?php echo $Footer[$i]['Link']; ?>" class="list-footer_link"><?php if($_SESSION['lang'] == 'en'){ echo $Footer[$i]['Title_Lang2']; }else{ echo $Footer[$i]['Title']; } ?></a>
                    </li>
                        <?php  } ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
