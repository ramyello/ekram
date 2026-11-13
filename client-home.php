<?php
    ######### Fetch data #########
    $ListGallery = $Website->SelectBanner($Connection,'','1','1','Priority','','8');
    ######### Fetch data #########
    ?>


    
    <section class="section-line">
        <h5 class="section-line_title title-section title-section_dark">
            <span><?php if($_SESSION['lang'] == 'en'){ echo  "Our Costumers";  }else{ echo "مشتریان ما"; } ?></span>
        </h5>
        <div class="container container-small">
            <ul class="list-client">
                  <?php
                                $RowNo = 0;
                                for($i = 1, $iMax = count($ListGallery); $i <= $iMax; $i++) {              //Level 1
                                $RowNo++;
                                ?>
                <li class="list-client_item">
                    <a href="<?php echo $ListGallery[$i]['Link']; ?>" class="list-client_link">
                        <img src="AdminPanel/<?php echo $ListGallery[$i]['File']; ?>" alt="<?php echo $ListGallery[$i]['Title']; ?>" class="list-client_img">
                    </a>
                </li>
                   <?php
                            }
                            ?>
           
            </ul>
        </div>

        <h7 class="section-line_title title-section_dark" style="text-align: center;  padding: 0 20% 0 20%;">
            <span><?php if($_SESSION['lang'] == 'en'){ echo  "“we have come to realize that customers love companies that make them feel good about themselves—companies that reflect what they, the customers, believe about themselves. Customers fall in love with the company that says to them, ‘You are unique. You are great. We are the only ones who can make you feel that way. Fall in love with us and we will continue to make you feel great.’”
– J.N. Halm";  }else{ echo "
ما متوجه شده‌ایم که مشتریان عاشق شرکت‌هایی هستند که به آنها احساس خوبی نسبت به خودشان می‌دهند - شرکت‌هایی که منعکس‌کننده آن چیزی هستند که آنها، مشتریان، در مورد خودشان باور دارند. مشتریان عاشق شرکتی می شوند که به آنها می گوید: «شما منحصر به فرد هستید. تو عالی هستی. ما تنها کسانی هستیم که می توانیم این احساس را در شما ایجاد کنیم. عاشق ما شوید و ما همچنان به شما احساس عالی می کنیم.»
– J.N. Halm
"; } ?></span>
        </h7>
    </section>