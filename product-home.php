<?php
######### Fetch data #########
$ListProduct = $Website->SelectPost($Connection,'','1','','3','1','ID','DESC','');
######### Fetch data #########
?>
    
    <section class="section-white">
        <div class="container">
            <h5 class="section-white_title title-section">Products</h5>
        </div>
        <div class="slider-product">
            <div class="owl-carousel" id="slider_product">
                 <?php
                $RowNo = 0;
                for($i = 1, $iMax = count($ListProduct); $i <= $iMax; $i++) {              //Level 1
                $RowNo++;
                ?>
                <a href="product-<?php echo $ListProduct[$i]['Slug']; ?>" class="item-product">
                    <div class="item-product_img">
                        <img src="AdminPanel/<?php echo $ListProduct[$i]['Thumb']; ?>" width="250px" alt="<?php echo $ListProduct[$i]['Title']; ?>">
                    </div>
                    <h4 class="item-product_title">
                          <?php echo $ListProduct[$i]['Title']; ?>
                    </h4>
                </a>
                 <?php
                }
                ?>
            </div>
        </div>
    </section>