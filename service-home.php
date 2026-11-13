<?php
######### Fetch data #########
$List = $Website->SelectBanner($Connection, '', '4', '1', 'Priority', '', '5');
######### Fetch data #########
?>

<section class="section-white">
    <div class="container">
        <h5 class="section-white_title title-section"><?php if ($_SESSION['lang'] == 'en') {
                                                            echo  "Services";
                                                        } else {
                                                            echo "خدمات ما";
                                                        } ?></h5>
    </div>
    <div class="container">
        <div class="slider-service">
            <?php
            $s = "";
            $RowNo = 0;
            for ($i = 1, $iMax = count($List); $i <= $iMax; $i++) {              //Level 1
                $RowNo++;
            ?>
                <div class="item">
                    <a class="item-service modal-service<?php echo $s ?>_toggle">
                        <img src="AdminPanel/<?php echo $List[$i]['File']; ?>" alt="" class="item-service_img">
                        <h6 class="item-service_title">
                            <?php if ($_SESSION['lang'] == 'en') {
                                echo $List[$i]['Name_Lang2'];
                            } else {
                                echo $List[$i]['Name'];
                            } ?>
                        </h6>

                        <p style="text-align: center;color: #a7a7a7;">
                            <?php if ($_SESSION['lang'] == 'en') {
                              //  echo $List[$i]['Title_Lang2'];
                            } else {
                              //  echo $List[$i]['Title'];
                            } ?>
                        </p>
                    </a>
                </div>
            <?php $s++;
            }
            ?>
        </div>
    </div>
</section>