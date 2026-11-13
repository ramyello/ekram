<?php
/**
 * Created by Mohammad reza Moshaver - Kaveh Zarifi.
 * zarifikaveh@gmail.com
 * Date: 7/30/2020 AD
 * Time: 17:51
 */

######### Page init #########
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../../class/General/General.class.php');
require_once('../../class/Database/Database.class.php');
require_once('../../class/Website/Website.class.php');
$General = new General();
$Connection = new Database();
$Website = new Website();

$General->CheckLoginToken($Connection,'1','1','../Error/login.php');

$General->CheckAdminPrivilege($Connection,$_SESSION['AdminID'],'Page_Edit','1','../Error/permission.php');

$General->CheckParameters(array(),array('ID'),array(),'1','../Error/parameters.php');

$PageName = 'ویرایش برگه';
$PageText = '';
$RandID = mt_rand();

$BreadArray = array('داشبورد' => '#pages/index_v2.php','لیست برگه ها' => '#pages/Website/Page_List.php', $PageName => '');
######### Page init #########

######### Fetch data #########
$Data = $Website->SelectPost($Connection,$Connection->CInput($_GET['ID']),'2','','','','','','1');
if(count($Data) != '1'){
    $General->Redirect('../Error/parameters.php');
}
$ListCategories = $Website->SelectPostCategory($Connection,'','1','','1','Name','ASC','');
$ListForm = $Website->SelectForm($Connection,'','1','','','');

$ListGallery = $Website->SelectGallery($Connection,'','1','','','');
######### Fetch data #########
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="../assets/plugins/jquery-smart-wizard/src/css/smart_wizard.css" rel="stylesheet" />
<link href="../assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<script src="../assets/plugins/ckeditor/ckeditor.js"></script>
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <?php
    foreach ($BreadArray as $Key => $KeyValue) { ?>
        <li class="breadcrumb-item <?php if($KeyValue != ''){ echo 'active'; } ?>"><?php if($KeyValue != ''){ ?><a href="<?php echo $KeyValue; ?>"><?php } ?><?php echo $Key; ?></a></li>
        <?php
    }
    ?>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header"><?php echo $PageName; ?> <small><?php echo $PageText; ?></small></h1>
<!-- end page-header -->

<h3 class="m-b-20"><?php //echo $PageName; ?></h3>
<!-- begin row -->
<!-- begin wizard-form -->
<form action="pages/Website/Action.php?Action=EditPage&ID=<?php echo $Data['1']['ID']; ?>" method="POST" enctype="multipart/form-data" name="form-wizard" class="do-ajax form-control-with-bg <?php echo $RandID; ?>"  data-OnSuc="#pages/Website/Page_List.php" data-OnFail="">
    <!-- begin wizard -->
    <div id="wizard">
        <!-- begin wizard-step -->
        <ul>
            <li class="col-md-4 col-sm-4 col-6">
                <a href="#step-1">
                    <span class="number">1</span>
                    <span class="info text-ellipsis">
						اطلاعات اصلی برگه
						<small class="text-ellipsis">اطلاعات اصلی برگه را وارد کنید</small>
					</span>
                </a>
            </li>
            <li class="col-md-4 col-sm-4 col-6">
                <a href="#step-2">
                    <span class="number">2</span>
                    <span class="info text-ellipsis">
						مطالب برگه
						<small class="text-ellipsis">مطالب برگه را ثبت کنید</small>
					</span>
                </a>
            </li>
            <li class="col-md-4 col-sm-4 col-6">
                <a href="#step-3">
                    <span class="number">3</span>
                    <span class="info text-ellipsis">
						اطلاعات SEO برگه
						<small class="text-ellipsis">این اطلاعات توسط گوگل شناسایی خواهند شد</small>
					</span>
                </a>
            </li>
        </ul>
        <!-- end wizard-step -->
        <!-- begin wizard-content -->
        <div>
            <!-- begin step-1 -->
            <div id="step-1" style="overflow-x: scroll">
                <!-- begin fieldset -->
                <fieldset>
                    <!-- begin row -->
                    <div class="row">
                        <!-- begin col-8 -->
                        <div class="col-md-12">
                            <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse text-left">اطلاعات زیر را تکمیل کنید</legend>
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="Title" class="col-md-3 col-form-label text-md-right">عنوان برگه <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" name="Title" value="<?php echo $Data['1']['Title']; ?>" placeholder="عنوان برگه" class="form-control" id="Title" data-parsley-group="step-1" data-parsley-required="true" autocomplete="false" />
                                </div>
                            </div>
                            <?php if($_SESSION['License']['Lang2'] == '1'){
                                ?>
                                <div class="form-group row m-b-10">
                                    <label for="Title_Lang2" class="col-md-3 col-form-label text-md-right">عنوان برگه <?php echo $_SESSION['License']['Lang2_Name'] ;?> <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="Title_Lang2" value="<?php echo $Data['1']['Title_Lang2']; ?>" placeholder="عنوان برگه <?php echo $_SESSION['License']['Lang2_Name'] ;?>" class="form-control" id="Title_Lang2" data-parsley-group="step-1" data-parsley-required="true" autocomplete="false" />
                                    </div>
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="Title_Lang2" value="Undefined">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang3'] == '1'){
                                ?>
                                <div class="form-group row m-b-10">
                                    <label for="Title_Lang3" class="col-md-3 col-form-label text-md-right">عنوان برگه <?php echo $_SESSION['License']['Lang3_Name'] ;?> <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="Title_Lang3" value="<?php echo $Data['1']['Title_Lang3']; ?>" placeholder="عنوان برگه <?php echo $_SESSION['License']['Lang3_Name'] ;?>" class="form-control" id="Title_Lang3" data-parsley-group="step-1" data-parsley-required="true" autocomplete="false" />
                                    </div>
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="Title_Lang3" value="Undefined">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang4'] == '1'){
                                ?>
                                <div class="form-group row m-b-10">
                                    <label for="Title_Lang4" class="col-md-3 col-form-label text-md-right">عنوان برگه <?php echo $_SESSION['License']['Lang4_Name'] ;?> <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="Title_Lang4" value="<?php echo $Data['1']['Title_Lang4']; ?>" placeholder="عنوان برگه <?php echo $_SESSION['License']['Lang4_Name'] ;?>" class="form-control" id="Title_Lang4" data-parsley-group="step-1" data-parsley-required="true" autocomplete="false" />
                                    </div>
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="Title_Lang4" value="Undefined">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang5'] == '1'){
                                ?>
                                <div class="form-group row m-b-10">
                                    <label for="Title_Lang5" class="col-md-3 col-form-label text-md-right">عنوان برگه <?php echo $_SESSION['License']['Lang5_Name'] ;?> <span class="text-danger">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" name="Title_Lang5" value="<?php echo $Data['1']['Title_Lang5']; ?>" placeholder="عنوان برگه <?php echo $_SESSION['License']['Lang5_Name'] ;?>" class="form-control" id="Title_Lang5" data-parsley-group="step-1" data-parsley-required="true" autocomplete="false" />
                                    </div>
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="Title_Lang5" value="Undefined">
                                <?php
                            }
                            ?>
                            <!-- end form-group -->
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="CategoryID" class="col-md-3 col-form-label text-md-right">دسته بندی <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select name="CategoryID" class="form-control" id="CategoryID" data-parsley-group="step-1" data-parsley-required="true">
                                        <option value="">دسته بندی را انتخاب کنید</option>
                                        <?php
                                        for($i = 1, $iMax = count($ListCategories); $i <= $iMax; $i++){
                                            ?>
                                            <option value="<?php echo $ListCategories[$i]['ID']; ?>" <?php if($Data['1']['CategoryID'] == $ListCategories[$i]['ID']){ echo 'selected'; } ?> ><?php echo $ListCategories[$i]['Name']; ?></option>
                                            <?php
                                            /****** Start Layer 2 ******/
                                            if(isset($ListCategories[$i]['Child'])){

                                                for($x = 1, $xMax = count($ListCategories[$i]['Child']); $x <= $xMax; $x++){
                                                    ?>
                                                    <option value="<?php echo $ListCategories[$i]['Child'][$x]['ID']; ?>" <?php if($Data['1']['CategoryID'] == $ListCategories[$i]['Child'][$x]['ID']){ echo 'selected'; } ?> >&boxUL;&boxH;&boxH;&nbsp;<?php echo $ListCategories[$i]['Child'][$x]['Name']; ?></option>
                                                    <?php
                                                    /****** Start Layer 3 ******/
                                                    if(isset($ListCategories[$i]['Child'][$x]['Child'])){

                                                        for($y = 1, $yMax = count($ListCategories[$i]['Child'][$x]['Child']); $y <= $yMax; $y++){
                                                            ?>
                                                            <option value="<?php echo $ListCategories[$i]['Child'][$x]['Child'][$y]['ID']; ?>" <?php if($Data['1']['CategoryID'] == $ListCategories[$i]['Child'][$x]['Child'][$y]['ID']){ echo 'selected'; } ?> >&boxV;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&boxUL;&boxH;&boxH;&nbsp;<?php echo $ListCategories[$i]['Child'][$x]['Child'][$y]['Name']; ?></option>
                                                            <?php
                                                            /****** Start Layer 4 ******/
                                                            if(isset($ListCategories[$i]['Child'][$x]['Child'][$y]['Child'])){

                                                                for($z = 1, $zMax = count($ListCategories[$i]['Child'][$x]['Child'][$y]['Child']); $z <= $zMax; $z++){
                                                                    ?>
                                                                    <option value="<?php echo $ListCategories[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ID']; ?>"<?php if($Data['1']['CategoryID'] == $ListCategories[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ID']){ echo 'selected'; } ?>>&boxV;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&boxV;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&boxUL;&boxH;&boxH;&nbsp;<?php echo $ListCategories[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Name']; ?></option>
                                                                    <?php
                                                                }

                                                            }
                                                            /****** End Layer 4 ******/
                                                        }

                                                    }
                                                    /****** End Layer 3 ******/
                                                }

                                            }
                                            /****** End Layer 2 ******/
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end form-group -->
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="Thumb" class="col-md-3 col-form-label text-md-right">تصویر بندانگشتی<br><span class="f-s-11 text-black-transparent-7">با انتخاب تصویر٬ تصویر بندانگشتی نوشته جایگزین خواهد شد</span></label>
                                <div class="col-md-4">
                                    <input type="file" id="Thumb" name="Thumb" accept=".jpg,.jpeg,.png,.gif" placeholder="تصویر بندانگشتی نوشته را انتخاب کنید" class="form-control" data-parsley-group="step-1"
                                           data-parsley-required="false" />
                                    <input type="hidden" name="Thumb" value="<?php echo $Data['1']['Thumb']; ?>">
                                </div>
                                <?php if($Data['1']['Thumb'] != '') { ?>
                                    <div class="col-md-2 text-left">
                                        <img src=".<?php echo $Data['1']['Thumb']; ?>" width="80px" height="80px"
                                             alt="<?php echo $Data['1']['Title']; ?>">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <!-- end form-group -->
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="FormID" class="col-md-3 col-form-label text-md-right">فرم</label>
                                <div class="col-md-6">
                                    <select name="FormID" class="form-control" id="FormID" data-parsley-group="step-1" data-parsley-required="false">
                                        <option value="">------</option>
                                        <?php for($i = 1, $iMax = count($ListForm); $i <= $iMax; $i++){
                                            ?>
                                            <option value="<?php echo $ListForm[$i]['ID']; ?>" <?php if(isset($Data['1']['Form']['ID']) AND $ListForm[$i]['ID'] == $Data['1']['Form']['ID'] ){ echo 'selected'; } ?> ><?php echo $ListForm[$i]['Name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php if($_SESSION['License']['Lang2'] == '1'){
                                ?>
                                <div class="form-group row m-b-10">
                                    <label for="FormID_Lang2" class="col-md-3 col-form-label text-md-right">فرم <?php echo $_SESSION['License']['Lang2_Name'] ;?></label>
                                    <div class="col-md-6">
                                        <select name="FormID_Lang2" class="form-control" id="FormID_Lang2" data-parsley-group="step-1" data-parsley-required="false">
                                            <option value="">------</option>
                                            <?php for($i = 1, $iMax = count($ListForm); $i <= $iMax; $i++){
                                                ?>
                                                <option value="<?php echo $ListForm[$i]['ID']; ?>" <?php if(isset($Data['1']['Form_Lang2']['ID']) AND $ListForm[$i]['ID'] == $Data['1']['Form_Lang2']['ID'] ){ echo 'selected'; } ?> ><?php echo $ListForm[$i]['Name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="FormID_Lang2" value="">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang3'] == '1'){
                                ?>
                                <div class="form-group row m-b-10">
                                    <label for="FormID_Lang3" class="col-md-3 col-form-label text-md-right">فرم <?php echo $_SESSION['License']['Lang3_Name'] ;?></label>
                                    <div class="col-md-6">
                                        <select name="FormID_Lang3" class="form-control" id="FormID_Lang3" data-parsley-group="step-1" data-parsley-required="false">
                                            <option value="">------</option>
                                            <?php for($i = 1, $iMax = count($ListForm); $i <= $iMax; $i++){
                                                ?>
                                                <option value="<?php echo $ListForm[$i]['ID']; ?>" <?php if(isset($Data['1']['Form_Lang3']['ID']) AND $ListForm[$i]['ID'] == $Data['1']['Form_Lang3']['ID'] ){ echo 'selected'; } ?> ><?php echo $ListForm[$i]['Name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="FormID_Lang3" value="">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang4'] == '1'){
                                ?>
                                <div class="form-group row m-b-10">
                                    <label for="FormID_Lang4" class="col-md-3 col-form-label text-md-right">فرم <?php echo $_SESSION['License']['Lang4_Name'] ;?></label>
                                    <div class="col-md-6">
                                        <select name="FormID_Lang4" class="form-control" id="FormID_Lang4" data-parsley-group="step-1" data-parsley-required="false">
                                            <option value="">------</option>
                                            <?php for($i = 1, $iMax = count($ListForm); $i <= $iMax; $i++){
                                                ?>
                                                <option value="<?php echo $ListForm[$i]['ID']; ?>" <?php if(isset($Data['1']['Form_Lang4']['ID']) AND $ListForm[$i]['ID'] == $Data['1']['Form_Lang4']['ID'] ){ echo 'selected'; } ?> ><?php echo $ListForm[$i]['Name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="FormID_Lang4" value="">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang5'] == '1'){
                                ?>
                                <div class="form-group row m-b-10">
                                    <label for="FormID_Lang5" class="col-md-3 col-form-label text-md-right">فرم <?php echo $_SESSION['License']['Lang5_Name'] ;?></label>
                                    <div class="col-md-6">
                                        <select name="FormID_Lang5" class="form-control" id="FormID_Lang5" data-parsley-group="step-1" data-parsley-required="false">
                                            <option value="">------</option>
                                            <?php for($i = 1, $iMax = count($ListForm); $i <= $iMax; $i++){
                                                ?>
                                                <option value="<?php echo $ListForm[$i]['ID']; ?>" <?php if(isset($Data['1']['Form_Lang5']['ID']) AND $ListForm[$i]['ID'] == $Data['1']['Form_Lang5']['ID'] ){ echo 'selected'; } ?> ><?php echo $ListForm[$i]['Name']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="FormID_Lang5" value="">
                                <?php
                            }
                            ?>
                            <!-- end form-group -->
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="GalleryID" class="col-md-3 col-form-label text-md-right">گالری</label>
                                <div class="col-md-6">
                                    <select name="GalleryID" class="form-control" id="GalleryID" data-parsley-group="step-1" data-parsley-required="false">
                                        <option value="">------</option>
                                        <?php for($i = 1, $iMax = count($ListGallery); $i <= $iMax; $i++){
                                            ?>
                                            <option value="<?php echo $ListGallery[$i]['ID']; ?>" <?php if(isset($Data['1']['Gallery']['ID']) AND $ListGallery[$i]['ID'] == $Data['1']['Gallery']['ID'] ){ echo 'selected'; } ?> ><?php echo $ListGallery[$i]['Name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end form-group -->
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="Status" class="col-md-3 col-form-label text-md-right">وضعیت <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <select name="Status" class="form-control" id="Status" data-parsley-group="step-1" data-parsley-required="true">
                                        <option value="1" <?php if($Data['1']['StatusFlag'] == '1'){ echo 'selected'; }?> >فعال</option>
                                        <option value="0" <?php if($Data['1']['StatusFlag'] == '0'){ echo 'selected'; }?>>غیرفعال</option>
                                    </select>
                                </div>
                            </div>
                            <!-- end form-group -->
                        </div>
                        <!-- end col-8 -->
                    </div>
                    <!-- end row -->
                </fieldset>
                <!-- end fieldset -->
            </div>
            <!-- end step-1 -->
            <!-- begin step-2 -->
            <div id="step-2">
                <!-- begin fieldset -->
                <fieldset>
                    <!-- begin row -->
                    <div class="row">
                        <!-- begin col-8 -->
                        <div class="col-md-12">
                            <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse text-left">اطلاعات زیر را تکمیل کنید</legend>
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="Content" class="col-md-3 col-form-label text-md-right">محتوا<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <textarea name="Content" class="cke" rows="20" id="Content" data-parsley-group="step-2" data-parsley-required="false" ><?php echo $Data['1']['Content']; ?></textarea>
                                </div>
                            </div>
                            <!-- end form-group -->
                            <?php if($_SESSION['License']['Lang2'] == '1'){
                                ?>
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="Content_Lang2" class="col-md-3 col-form-label text-md-right">محتوای <?php echo $_SESSION['License']['Lang2_Name'] ;?></label>
                                    <div class="col-md-6">
                                        <textarea name="Content_Lang2" class="cke" rows="20" id="Content_Lang2" data-parsley-group="step-2" data-parsley-required="false" ><?php echo $Data['1']['Content_Lang2']; ?></textarea>
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="Content_Lang2" value="#">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang3'] == '1'){
                                ?>
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="Content_Lang3" class="col-md-3 col-form-label text-md-right">محتوای <?php echo $_SESSION['License']['Lang3_Name'] ;?></label>
                                    <div class="col-md-6">
                                        <textarea name="Content_Lang3" class="cke" rows="20" id="Content_Lang3" data-parsley-group="step-2" data-parsley-required="false" ><?php echo $Data['1']['Content_Lang3']; ?></textarea>
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="Content_Lang3" value="#">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang4'] == '1'){
                                ?>
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="Content_Lang4" class="col-md-3 col-form-label text-md-right">محتوای <?php echo $_SESSION['License']['Lang4_Name'] ;?></label>
                                    <div class="col-md-6">
                                        <textarea name="Content_Lang4" class="cke" rows="20" id="Content_Lang4" data-parsley-group="step-2" data-parsley-required="false" ><?php echo $Data['1']['Content_Lang4']; ?></textarea>
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="Content_Lang4" value="#">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang5'] == '1'){
                                ?>
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="Content_Lang5" class="col-md-3 col-form-label text-md-right">محتوای <?php echo $_SESSION['License']['Lang5_Name'] ;?></label>
                                    <div class="col-md-6">
                                        <textarea name="Content_Lang5" class="cke" rows="20" id="Content_Lang5" data-parsley-group="step-2" data-parsley-required="false" ><?php echo $Data['1']['Content_Lang5']; ?></textarea>
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="Content_Lang5" value="#">
                                <?php
                            }
                            ?>
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label class="col-md-3 col-form-label text-md-right" ></label>
                                <div class="col-md-6">
                                    <button type="button" id="CkUpdate" class="btn btn-inverse btn-block">بررسی محتوا</button>
                                </div>
                            </div>
                            <!-- end form-group -->
                        </div>
                        <!-- end col-8 -->
                    </div>
                    <!-- end row -->
                </fieldset>
                <!-- end fieldset -->
            </div>
            <!-- end step-2 -->
            <!-- begin step-3 -->
            <div id="step-3">
                <!-- begin fieldset -->
                <fieldset>
                    <!-- begin row -->
                    <div class="row">
                        <!-- begin col-8 -->
                        <div class="col-md-12">
                            <legend class="no-border f-w-700 p-b-0 m-t-0 m-b-20 f-s-16 text-inverse text-left">این اطلاعات توسط گوگل شناسایی خواهند شد</legend>
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="SEO_Title" class="col-md-3 col-form-label text-md-right">عنوان برگه (Title)</label>
                                <div class="col-md-6">
                                    <input type="text" name="SEO_Title" value="<?php echo $Data['1']['SEO_Title']; ?>" placeholder="عنوان برگه (Title)" class="form-control" id="SEO_Title" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ عنوان برگه ثبت خواهد شد." />
                                </div>
                            </div>
                            <!-- end form-group -->
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="SEO_Description" class="col-md-3 col-form-label text-md-right">توضیحات برگه (Description)</label>
                                <div class="col-md-6">
                                    <input type="text" name="SEO_Description" value="<?php echo $Data['1']['SEO_Description']; ?>" placeholder="توضیحات نوشته (Description)" class="form-control" id="SEO_Description" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ توضیحات سایت/فروشگاه ثبت خواهد شد." />
                                </div>
                            </div>
                            <!-- end form-group -->
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label for="SEO_Keywords" class="col-md-3 col-form-label text-md-right">کلمات کلیدی برگه (Keywords)</label>
                                <div class="col-md-6">
                                    <input type="text" name="SEO_Keywords" value="<?php echo $Data['1']['SEO_Keywords']; ?>" placeholder="کلمات کلیدی نوشته (Keywords)" class="form-control" id="SEO_Keywords" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="کلمات کلیدی را با , (کاما) از یکدیگر جدا کنید." />
                                </div>
                            </div>
                            <!-- end form-group -->
                            <?php if($_SESSION['License']['Lang2'] == '1'){
                                ?>
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Title_Lang2" class="col-md-3 col-form-label text-md-right">عنوان برگه <?php echo $_SESSION['License']['Lang2_Name'] ;?> (Title)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Title_Lang2" value="<?php echo $Data['1']['SEO_Title_Lang2']; ?>" placeholder="عنوان برگه <?php echo $_SESSION['License']['Lang2_Name'] ;?> (Title)" class="form-control" id="SEO_Title_Lang2" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ عنوان <?php echo $_SESSION['License']['Lang2_Name'] ;?> نوشته ثبت خواهد شد." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Description_Lang2" class="col-md-3 col-form-label text-md-right">توضیحات برگه <?php echo $_SESSION['License']['Lang2_Name'] ;?> (Description)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Description_Lang2" value="<?php echo $Data['1']['SEO_Description_Lang2']; ?>" placeholder="توضیحات برگه <?php echo $_SESSION['License']['Lang2_Name'] ;?> (Description)" class="form-control" id="SEO_Description_Lang2" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ توضیحات سایت/فروشگاه ثبت خواهد شد." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Keywords_Lang2" class="col-md-3 col-form-label text-md-right">کلمات کلیدی برگه <?php echo $_SESSION['License']['Lang2_Name'] ;?> (Keywords)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Keywords_Lang2" value="<?php echo $Data['1']['SEO_Keywords_Lang2']; ?>" placeholder="کلمات کلیدی برگه <?php echo $_SESSION['License']['Lang2_Name'] ;?> (Keywords)" class="form-control" id="SEO_Keywords_Lang2" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="کلمات کلیدی را با , (کاما) از یکدیگر جدا کنید." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="SEO_Title_Lang2" value="">
                                <input type="hidden" name="SEO_Description_Lang2" value="">
                                <input type="hidden" name="SEO_Keywords_Lang2" value="">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang3'] == '1'){
                                ?>
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Title_Lang3" class="col-md-3 col-form-label text-md-right">عنوان برگه <?php echo $_SESSION['License']['Lang3_Name'] ;?> (Title)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Title_Lang3" value="<?php echo $Data['1']['SEO_Title_Lang3']; ?>" placeholder="عنوان برگه <?php echo $_SESSION['License']['Lang3_Name'] ;?> (Title)" class="form-control" id="SEO_Title_Lang3" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ عنوان <?php echo $_SESSION['License']['Lang3_Name'] ;?> نوشته ثبت خواهد شد." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Description_Lang3" class="col-md-3 col-form-label text-md-right">توضیحات برگه <?php echo $_SESSION['License']['Lang3_Name'] ;?> (Description)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Description_Lang3" value="<?php echo $Data['1']['SEO_Description_Lang3']; ?>" placeholder="توضیحات برگه <?php echo $_SESSION['License']['Lang3_Name'] ;?> (Description)" class="form-control" id="SEO_Description_Lang3" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ توضیحات سایت/فروشگاه ثبت خواهد شد." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Keywords_Lang3" class="col-md-3 col-form-label text-md-right">کلمات کلیدی برگه <?php echo $_SESSION['License']['Lang3_Name'] ;?> (Keywords)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Keywords_Lang3" value="<?php echo $Data['1']['SEO_Keywords_Lang3']; ?>" placeholder="کلمات کلیدی برگه <?php echo $_SESSION['License']['Lang3_Name'] ;?> (Keywords)" class="form-control" id="SEO_Keywords_Lang3" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="کلمات کلیدی را با , (کاما) از یکدیگر جدا کنید." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="SEO_Title_Lang3" value="">
                                <input type="hidden" name="SEO_Description_Lang3" value="">
                                <input type="hidden" name="SEO_Keywords_Lang3" value="">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang4'] == '1'){
                                ?>
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Title_Lang4" class="col-md-3 col-form-label text-md-right">عنوان برگه <?php echo $_SESSION['License']['Lang4_Name'] ;?> (Title)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Title_Lang4" value="<?php echo $Data['1']['SEO_Title_Lang4']; ?>" placeholder="عنوان برگه <?php echo $_SESSION['License']['Lang4_Name'] ;?> (Title)" class="form-control" id="SEO_Title_Lang4" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ عنوان <?php echo $_SESSION['License']['Lang4_Name'] ;?> نوشته ثبت خواهد شد." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Description_Lang4" class="col-md-3 col-form-label text-md-right">توضیحات برگه <?php echo $_SESSION['License']['Lang4_Name'] ;?> (Description)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Description_Lang4" value="<?php echo $Data['1']['SEO_Description_Lang4']; ?>" placeholder="توضیحات برگه <?php echo $_SESSION['License']['Lang4_Name'] ;?> (Description)" class="form-control" id="SEO_Description_Lang4" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ توضیحات سایت/فروشگاه ثبت خواهد شد." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Keywords_Lang4" class="col-md-3 col-form-label text-md-right">کلمات کلیدی برگه <?php echo $_SESSION['License']['Lang4_Name'] ;?> (Keywords)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Keywords_Lang4" value="<?php echo $Data['1']['SEO_Keywords_Lang4']; ?>" placeholder="کلمات کلیدی برگه <?php echo $_SESSION['License']['Lang4_Name'] ;?> (Keywords)" class="form-control" id="SEO_Keywords_Lang4" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="کلمات کلیدی را با , (کاما) از یکدیگر جدا کنید." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="SEO_Title_Lang4" value="">
                                <input type="hidden" name="SEO_Description_Lang4" value="">
                                <input type="hidden" name="SEO_Keywords_Lang4" value="">
                                <?php
                            }
                            ?>
                            <?php if($_SESSION['License']['Lang5'] == '1'){
                                ?>
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Title_Lang5" class="col-md-3 col-form-label text-md-right">عنوان برگه <?php echo $_SESSION['License']['Lang5_Name'] ;?> (Title)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Title_Lang5" value="<?php echo $Data['1']['SEO_Title_Lang5']; ?>" placeholder="عنوان برگه <?php echo $_SESSION['License']['Lang5_Name'] ;?> (Title)" class="form-control" id="SEO_Title_Lang5" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ عنوان <?php echo $_SESSION['License']['Lang5_Name'] ;?> نوشته ثبت خواهد شد." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Description_Lang5" class="col-md-3 col-form-label text-md-right">توضیحات برگه <?php echo $_SESSION['License']['Lang5_Name'] ;?> (Description)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Description_Lang5" value="<?php echo $Data['1']['SEO_Description_Lang5']; ?>" placeholder="توضیحات برگه <?php echo $_SESSION['License']['Lang5_Name'] ;?> (Description)" class="form-control" id="SEO_Description_Lang5" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="در صورت خالی بودن این قسمت٬ توضیحات سایت/فروشگاه ثبت خواهد شد." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <!-- begin form-group -->
                                <div class="form-group row m-b-10">
                                    <label for="SEO_Keywords_Lang5" class="col-md-3 col-form-label text-md-right">کلمات کلیدی برگه <?php echo $_SESSION['License']['Lang5_Name'] ;?> (Keywords)</label>
                                    <div class="col-md-6">
                                        <input type="text" name="SEO_Keywords_Lang5" value="<?php echo $Data['1']['SEO_Keywords_Lang5']; ?>" placeholder="کلمات کلیدی برگه <?php echo $_SESSION['License']['Lang5_Name'] ;?> (Keywords)" class="form-control" id="SEO_Keywords_Lang5" data-parsley-group="step-3" data-parsley-required="false" autocomplete="false" data-toggle="tooltip" data-placement="top" title="کلمات کلیدی را با , (کاما) از یکدیگر جدا کنید." />
                                    </div>
                                </div>
                                <!-- end form-group -->
                                <?php
                            }
                            else{
                                ?>
                                <input type="hidden" name="SEO_Title_Lang5" value="">
                                <input type="hidden" name="SEO_Description_Lang5" value="">
                                <input type="hidden" name="SEO_Keywords_Lang5" value="">
                                <?php
                            }
                            ?>
                            <!-- begin form-group -->
                            <div class="form-group row m-b-10">
                                <label class="col-md-3 col-form-label text-md-right" ></label>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block">ویرایش برگه</button>
                                </div>
                            </div>
                            <!-- end form-group -->
                        </div>
                        <!-- end col-8 -->
                    </div>
                    <!-- end row -->
                </fieldset>
                <!-- end fieldset -->
            </div>
            <!-- end step-6 -->
        </div>
        <!-- end wizard-content -->
    </div>
    <!-- end wizard -->
</form>
<!-- end wizard-form -->
<!-- end row -->


<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script>
    App.setPageTitle('<?php echo $_SESSION['Settings']['bas_SiteName']; ?> | <?php echo $PageName; ?>');
    App.restartGlobalFunction();

    $.when(
        $.getScript('../assets/plugins/parsley/dist/parsley.js'),
        $.getScript('../assets/plugins/bootstrap-sweetalert/sweetalert.min.js'),
        $.getScript('../assets/plugins/gritter/js/jquery.gritter.js'),
        $.getScript('../assets/plugins/jquery-smart-wizard/src/js/jquery.smartWizard.js'),
        $.getScript('../assets/js/demo/form-wizards-validation.demo.min.js'),
        $.Deferred(function( deferred ){
            $(deferred.resolve);
        })
    ).done(function() {
        FormWizardValidation.init();
        handleForm(<?php echo $RandID; ?>);

    });

    CKEDITOR.replace('Content');
    <?php if($_SESSION['License']['Lang2'] == '1'){
        ?>
        CKEDITOR.replace('Content_Lang2');
        <?php
    }
    ?>
    <?php if($_SESSION['License']['Lang3'] == '1'){
        ?>
        CKEDITOR.replace('Content_Lang3');
        <?php
    }
    ?>
    <?php if($_SESSION['License']['Lang4'] == '1'){
        ?>
        CKEDITOR.replace('Content_Lang4');
        <?php
    }
    ?>
    <?php if($_SESSION['License']['Lang5'] == '1'){
        ?>
        CKEDITOR.replace('Content_Lang5');
        <?php
    }
    ?>

    $('#CkUpdate').click(function(){
        CKupdate();
    });

    function CKupdate(){
        CKEDITOR.instances['Content'].updateElement();
        <?php if($_SESSION['License']['Lang2'] == '1'){
            ?>
            CKEDITOR.instances['Content_Lang2'].updateElement();
            <?php
        }
        ?>
        <?php if($_SESSION['License']['Lang3'] == '1'){
            ?>
            CKEDITOR.instances['Content_Lang3'].updateElement();
            <?php
        }
        ?>
        <?php if($_SESSION['License']['Lang4'] == '1'){
            ?>
            CKEDITOR.instances['Content_Lang4'].updateElement();
            <?php
        }
        ?>
        <?php if($_SESSION['License']['Lang5'] == '1'){
            ?>
            CKEDITOR.instances['Content_Lang5'].updateElement();
            <?php
        }
        ?>
    }

</script>
<!-- ================== END PAGE LEVEL JS ================== -->

