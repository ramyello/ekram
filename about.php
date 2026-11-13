<?php
######### Fetch data #########
$List = $Website->SelectPost($Connection,'28','1','','','1','ID','DESC','1');
######### Fetch data #########
?>
<section id="about" class="spacer-double-lg">
            <!--Container-->
            <div class="container">
                <!--row-->
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-5 mb-6 mb-lg-0">
                        <span class="label-title mb-3"><?php echo $List[1]['Title']; ?> </span>
                        <span class="clc33"></span>
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h4 class="h6  mb-0">کانون تبلیغاتی ایفاچی </h4>
                                <p class="mb-0"><?php echo $List[1]['Context']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <div class="row card-gutters">
                                <div class="col-sm-10 offset-sm-1 mb-2">
                                    
                                        <img class="img-fluid w-100" src="AdminPanel/<?php echo $List[1]['Thumb']; ?>" alt="">
                                        <span class="hover-effect-container">
                                          <span class="hover-effect-icon">
                                          <span class="fa fa-plus hover-effect-icon-inner ffaa20"></span> </span>                                        
                                        </span>                                    
                                                   
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End row-->
            </div>
            <!--End container-->
        </section>