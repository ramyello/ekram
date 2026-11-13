<?php
/**
 * Created by Mohammad reza Moshaver - Kaveh Zarifi.
 * zarifikaveh@gmail.com
 * Date: 7/23/2020 AD
 * Time: 17:51
 */

$ROOT = dirname(dirname(dirname(__FILE__)));

require_once($ROOT . '/class/General/General.class.php');
require_once($ROOT . '/class/Database/Database.class.php');
require_once($ROOT . '/class/Goods/Goods.class.php');

class Website
{

    public function __construct()
    {

    }

    public function AddBannerPosition($Connection, $Name)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        if($_SESSION['License']['MaxBannerPosition'] <= $Connection->NumRows('web.banner_position', 'ID', "")){
            $Result['status'] = false;
            $Result['msg'] = 'ظرفیت تعریف جایگاه بنر در لایسنس شما تکمیل شده است.';
            $Result['error'] = 'MaxBannerPosition: ' . $_SESSION['License']['MaxBannerPosition'];
            $Result['key'] = '';

            return $Result;
        }

        $QUERY = $Connection->Insert('web.banner_position', array(), array(array('NULL', $Name, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function EditBannerPosition($Connection, $ID, $Name, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Update('web.banner_position', array('Name' => $Name, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeleteBannerPosition($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.banner_position', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectBannerPosition($Connection, $ID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.banner_position', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function AddBanner($Connection, $PositionID, $Name, $Title, $Link, $ShowLang1, $Name_Lang2, $Title_Lang2, $Link_Lang2, $ShowLang2, $Name_Lang3, $Title_Lang3, $Link_Lang3, $ShowLang3, $Name_Lang4, $Title_Lang4, $Link_Lang4, $ShowLang4, $Name_Lang5, $Title_Lang5, $Link_Lang5, $ShowLang5, $Priority, $File)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if($Priority == ''){
            $Priority = $this->GetLastBannerPriority($Connection,$PositionID);
        }

        if($_SESSION['License']['Lang2'] != '1'){
            $Name_Lang2 = '';
            $Title_Lang2 = '';
            $Link_Lang2 = '';
            $ShowLang2 = '0';
        }
        if($_SESSION['License']['Lang3'] != '1'){
            $Name_Lang3 = '';
            $Title_Lang3 = '';
            $Link_Lang3 = '';
            $ShowLang3 = '0';
        }
        if($_SESSION['License']['Lang4'] != '1'){
            $Name_Lang4 = '';
            $Title_Lang4 = '';
            $Link_Lang4 = '';
            $ShowLang4 = '0';
        }
        if($_SESSION['License']['Lang5'] != '1'){
            $Name_Lang5 = '';
            $Title_Lang5 = '';
            $Link_Lang5 = '';
            $ShowLang5 = '0';
        }

        $FileUploadResult = $General->FileUpload($File,true,'',array('jpg','jpeg','gif','png','svg'));
        if($FileUploadResult['status']){
            $File = $FileUploadResult['key'];
        }
        else{
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
            $Result['error'] = $FileUploadResult['error'];
            $Result['key'] = '';

            return $Result;
        }

        $QUERY = $Connection->Insert('web.banner', array(), array(array('NULL', $PositionID, $Name, $Title, $Link, $ShowLang1, $Name_Lang2, $Title_Lang2, $Link_Lang2, $ShowLang2, $Name_Lang3, $Title_Lang3, $Link_Lang3, $ShowLang3, $Name_Lang4, $Title_Lang4, $Link_Lang4, $ShowLang4, $Name_Lang5, $Title_Lang5, $Link_Lang5, $ShowLang5, $Priority, $File, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function GetLastBannerPriority($Connection, $PositionID){
        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Select('web.banner',array('Priority'),"`PositionID` = '$PositionID'",'Priority','Desc','1');
        if(mysqli_num_rows($QUERY) > 0){
            $row_QUERY = mysqli_fetch_assoc($QUERY);
            $NewPriority = $row_QUERY['Priority'] + 1;
        }
        else{
            $NewPriority = 1;
        }

        return $NewPriority;
    }

    public function EditBanner($Connection, $ID, $PositionID, $Name, $Title, $Link, $ShowLang1, $Name_Lang2, $Title_Lang2, $Link_Lang2, $ShowLang2, $Name_Lang3, $Title_Lang3, $Link_Lang3, $ShowLang3, $Name_Lang4, $Title_Lang4, $Link_Lang4, $ShowLang4, $Name_Lang5, $Title_Lang5, $Link_Lang5, $ShowLang5, $Priority, $File, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if($_SESSION['License']['Lang2'] != '1'){
            $ShowLang2 = '0';
        }
        if($_SESSION['License']['Lang3'] != '1'){
            $ShowLang3 = '0';
        }
        if($_SESSION['License']['Lang4'] != '1'){
            $ShowLang4 = '0';
        }
        if($_SESSION['License']['Lang5'] != '1'){
            $ShowLang5 = '0';
        }

        if(isset($File["error"]) and $File["error"] != 4){              //Upload File if is set
            $FileUploadResult = $General->FileUpload($File,true,'',array('jpg','jpeg','gif','png'));
            if($FileUploadResult['status']){
                $File = $FileUploadResult['key'];
            }
            else{
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] = $FileUploadResult['error'];
                $Result['key'] = '';

                return $Result;
            }
        }

        $QUERY = $Connection->Update('web.banner', array('PositionID' => $PositionID, 'Name' => $Name, 'Title' => $Title, 'Link' => $Link, 'ShowLang1' => $ShowLang1, 'Name_Lang2' => $Name_Lang2, 'Title_Lang2' => $Title_Lang2, 'Link_Lang2' => $Link_Lang2, 'ShowLang2' => $ShowLang2, 'Name_Lang3' => $Name_Lang3, 'Title_Lang3' => $Title_Lang3, 'Link_Lang3' => $Link_Lang3, 'ShowLang3' => $ShowLang3, 'Name_Lang4' => $Name_Lang4, 'Title_Lang4' => $Title_Lang4, 'Link_Lang4' => $Link_Lang4, 'ShowLang4' => $ShowLang4, 'Name_Lang5' => $Name_Lang5, 'Title_Lang5' => $Title_Lang5, 'Link_Lang5' => $Link_Lang5, 'ShowLang5' => $ShowLang5, 'Priority' => $Priority, 'File' => $File, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeleteBanner($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.banner', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectBanner($Connection, $ID, $PositionID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT, $ShowLang1 = '', $ShowLang2 = '', $ShowLang3 = '', $ShowLang4 = '', $ShowLang5 = '')
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($PositionID != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`PositionID`='$PositionID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }
        if ($ShowLang1 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang1`='$ShowLang1')";
        }
        if ($ShowLang2 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang2`='$ShowLang2')";
        }
        if ($ShowLang3 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang3`='$ShowLang3')";
        }
        if ($ShowLang4 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang4`='$ShowLang4')";
        }
        if ($ShowLang5 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang5`='$ShowLang5')";
        }

        $Query = $Connection->Select('web.banner', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {
            $BannerPositionInfo = $this->SelectBannerPosition($Connection,$row['PositionID'],'','','','1');

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['PositionID'] = $row['PositionID'];
            $Result[$i]['PositionName'] = $BannerPositionInfo['1']['Name'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Title'] = $row['Title'];
            $Result[$i]['Link'] = $row['Link'];
            $Result[$i]['ShowLang1Flag'] = $row['ShowLang1'];
            $Result[$i]['Priority'] = $row['Priority'];
            $Result[$i]['File'] = $row['File'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            if($_SESSION['License']['Lang2'] == '1'){
                $Result[$i]['Name_Lang2'] = $row['Name_Lang2'];
                $Result[$i]['Title_Lang2'] = $row['Title_Lang2'];
                $Result[$i]['Link_Lang2'] = $row['Link_Lang2'];
                $Result[$i]['ShowLang2Flag'] = $row['ShowLang2'];
            }
            if($_SESSION['License']['Lang3'] == '1'){
                $Result[$i]['Name_Lang3'] = $row['Name_Lang3'];
                $Result[$i]['Title_Lang3'] = $row['Title_Lang3'];
                $Result[$i]['Link_Lang3'] = $row['Link_Lang3'];
                $Result[$i]['ShowLang3Flag'] = $row['ShowLang3'];
            }
            if($_SESSION['License']['Lang4'] == '1'){
                $Result[$i]['Name_Lang4'] = $row['Name_Lang4'];
                $Result[$i]['Title_Lang4'] = $row['Title_Lang4'];
                $Result[$i]['Link_Lang4'] = $row['Link_Lang4'];
                $Result[$i]['ShowLang4Flag'] = $row['ShowLang4'];
            }
            if($_SESSION['License']['Lang5'] == '1'){
                $Result[$i]['Name_Lang5'] = $row['Name_Lang5'];
                $Result[$i]['Title_Lang5'] = $row['Title_Lang5'];
                $Result[$i]['Link_Lang5'] = $row['Link_Lang5'];
                $Result[$i]['ShowLang5Flag'] = $row['ShowLang5'];
            }

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function AddSlideshow($Connection, $Name)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        if($_SESSION['License']['MaxSlideshowPosition'] <= $Connection->NumRows('web.slideshow', 'ID', "")){
            $Result['status'] = false;
            $Result['msg'] = 'ظرفیت تعریف جایگاه اسلایدشو در لایسنس شما تکمیل شده است.';
            $Result['error'] = 'MaxSlideshowPosition: ' . $_SESSION['License']['MaxSlideshowPosition'];
            $Result['key'] = '';

            return $Result;
        }

        $QUERY = $Connection->Insert('web.slideshow', array(), array(array('NULL', $Name, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function EditSlideshow($Connection, $ID, $Name, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Update('web.slideshow', array('Name' => $Name, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeleteSlideshow($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.slideshow', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectSlideshow($Connection, $ID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.slideshow', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function AddSlideshowImage($Connection, $SlideshowID, $Name, $Title, $Link, $ShowLang1, $Name_Lang2, $Title_Lang2, $Link_Lang2, $ShowLang2, $Name_Lang3, $Title_Lang3, $Link_Lang3, $ShowLang3, $Name_Lang4, $Title_Lang4, $Link_Lang4, $ShowLang4, $Name_Lang5, $Title_Lang5, $Link_Lang5, $ShowLang5, $Priority, $File)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if($Priority == ''){
            $Priority = $this->GetLastSlideshowImagePriority($Connection,$SlideshowID);
        }

        $FileUploadResult = $General->FileUpload($File,true,'',array('jpg','jpeg','gif','png','mp4'));
        if($FileUploadResult['status']){
            $File = $FileUploadResult['key'];
        }
        else{
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
            $Result['error'] = $FileUploadResult['error'];
            $Result['key'] = '';

            return $Result;
        }

        $QUERY = $Connection->Insert('web.slideshow_image', array(), array(array('NULL', $SlideshowID, $Name, $Title, $Link, $ShowLang1, $Name_Lang2, $Title_Lang2, $Link_Lang2, $ShowLang2, $Name_Lang3, $Title_Lang3, $Link_Lang3, $ShowLang3, $Name_Lang4, $Title_Lang4, $Link_Lang4, $ShowLang4, $Name_Lang5, $Title_Lang5, $Link_Lang5, $ShowLang5, $Priority, $File, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function GetLastSlideshowImagePriority($Connection, $SlideshowID){
        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Select('web.slideshow',array('Priority'),"`SlideshowID` = '$SlideshowID'",'Priority','Desc','1');
        if(mysqli_num_rows($QUERY) > 0){
            $row_QUERY = mysqli_fetch_assoc($QUERY);
            $NewPriority = $row_QUERY['Priority'] + 1;
        }
        else{
            $NewPriority = 1;
        }

        return $NewPriority;
    }

    public function EditSlideshowImage($Connection, $ID, $SlideshowID, $Name, $Title, $Link, $ShowLang1, $Name_Lang2, $Title_Lang2, $Link_Lang2, $ShowLang2, $Name_Lang3, $Title_Lang3, $Link_Lang3, $ShowLang3, $Name_Lang4, $Title_Lang4, $Link_Lang4, $ShowLang4, $Name_Lang5, $Title_Lang5, $Link_Lang5, $ShowLang5, $Priority, $File, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if(isset($File["error"]) and $File["error"] != 4){              //Upload File if is set
            $FileUploadResult = $General->FileUpload($File,true,'',array('jpg','jpeg','gif','png','mp4'));
            if($FileUploadResult['status']){
                $File = $FileUploadResult['key'];
            }
            else{
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] = $FileUploadResult['error'];
                $Result['key'] = '';

                return $Result;
            }
        }

        $QUERY = $Connection->Update('web.slideshow_image', array('SlideshowID' => $SlideshowID, 'Name' => $Name, 'Title' => $Title, 'Link' => $Link, 'ShowLang1' => $ShowLang1, 'Name_Lang2' => $Name_Lang2, 'Title_Lang2' => $Title_Lang2, 'Link_Lang2' => $Link_Lang2, 'ShowLang2' => $ShowLang2, 'Name_Lang3' => $Name_Lang3, 'Title_Lang3' => $Title_Lang3, 'Link_Lang3' => $Link_Lang3, 'ShowLang3' => $ShowLang3, 'Name_Lang4' => $Name_Lang4, 'Title_Lang4' => $Title_Lang4, 'Link_Lang4' => $Link_Lang4, 'ShowLang4' => $ShowLang4, 'Name_Lang5' => $Name_Lang5, 'Title_Lang5' => $Title_Lang5, 'Link_Lang5' => $Link_Lang5, 'ShowLang5' => $ShowLang5, 'Priority' => $Priority, 'File' => $File, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeleteSlideshowImage($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.slideshow_image', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectSlideshowImage($Connection, $ID, $SlideshowID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($SlideshowID != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`SlideshowID`='$SlideshowID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.slideshow_image', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {
            $SlideshowInfo = $this->SelectSlideshow($Connection,$row['SlideshowID'],'','','','1');

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['SlideshowID'] = $row['SlideshowID'];
            $Result[$i]['SlideshowName'] = $SlideshowInfo['1']['Name'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Title'] = $row['Title'];
            $Result[$i]['Link'] = $row['Link'];
            $Result[$i]['ShowLang1Flag'] = $row['ShowLang1'];
            $Result[$i]['Priority'] = $row['Priority'];
            $Result[$i]['File'] = $row['File'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            if($_SESSION['License']['Lang2'] == '1'){
                $Result[$i]['Name_Lang2'] = $row['Name_Lang2'];
                $Result[$i]['Title_Lang2'] = $row['Title_Lang2'];
                $Result[$i]['Link_Lang2'] = $row['Link_Lang2'];
                $Result[$i]['ShowLang2Flag'] = $row['ShowLang2'];
            }
            if($_SESSION['License']['Lang3'] == '1'){
                $Result[$i]['Name_Lang3'] = $row['Name_Lang3'];
                $Result[$i]['Title_Lang3'] = $row['Title_Lang3'];
                $Result[$i]['Link_Lang3'] = $row['Link_Lang3'];
                $Result[$i]['ShowLang3Flag'] = $row['ShowLang3'];
            }
            if($_SESSION['License']['Lang4'] == '1'){
                $Result[$i]['Name_Lang4'] = $row['Name_Lang4'];
                $Result[$i]['Title_Lang4'] = $row['Title_Lang4'];
                $Result[$i]['Link_Lang4'] = $row['Link_Lang4'];
                $Result[$i]['ShowLang4Flag'] = $row['ShowLang4'];
            }
            if($_SESSION['License']['Lang5'] == '1'){
                $Result[$i]['Name_Lang5'] = $row['Name_Lang5'];
                $Result[$i]['Title_Lang5'] = $row['Title_Lang5'];
                $Result[$i]['Link_Lang5'] = $row['Link_Lang5'];
                $Result[$i]['ShowLang5Flag'] = $row['ShowLang5'];
            }

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function AddMenuPosition($Connection, $Name)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        if($_SESSION['License']['MaxMenuPosition'] <= $Connection->NumRows('web.menu_position', 'ID', "")){
            $Result['status'] = false;
            $Result['msg'] = 'ظرفیت تعریف جایگاه منو در لایسنس شما تکمیل شده است.';
            $Result['error'] = 'MaxMenuPosition: ' . $_SESSION['License']['MaxMenuPosition'];
            $Result['key'] = '';

            return $Result;
        }

        $QUERY = $Connection->Insert('web.menu_position', array(), array(array('NULL', $Name, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function EditMenuPosition($Connection, $ID, $Name, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Update('web.menu_position', array('Name' => $Name, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeleteMenuPosition($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.menu_position', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectMenuPosition($Connection, $ID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.menu_position', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function AddMenu($Connection, $PositionID, $Layer, $ParentID, $Title, $Link, $ShowLang1, $Title_Lang2, $Link_Lang2, $ShowLang2, $Title_Lang3, $Link_Lang3, $ShowLang3, $Title_Lang4, $Link_Lang4, $ShowLang4, $Title_Lang5, $Link_Lang5, $ShowLang5, $Icon, $Priority, $IsParent)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if($Priority == ''){
            $Priority = $this->GetLastMenuPriority($Connection,$PositionID);
        }

        if ($Layer > 1 AND $ParentID == '') {
            $Result['status'] = false;
            $Result['msg'] = 'انتخاب منوی والد اجباری است';
            $Result['error'] = 'ParentID is null';
            $Result['key'] = '';

            return $Result;
        }

        if ($Layer == 1 AND $PositionID == '') {
            $Result['status'] = false;
            $Result['msg'] = 'انتخاب جایگاه منو اجباری است';
            $Result['error'] = 'PositionID is null';
            $Result['key'] = '';

            return $Result;
        }

        if($Layer > 1) {
            $GetParentInfo = $this->SelectMenu($Connection,$ParentID,'','','','','','','','1');
            $PositionID = $GetParentInfo['1']['PositionID'];
        }

        if($ParentID == ''){
            $ParentID = 'NULL';
        }

        if(isset($Icon["error"]) and $Icon["error"] != 4) {              //Upload Icon if is set
            $IconUploadResult = $General->FileUpload($Icon, true, '', array('jpg', 'jpeg', 'gif', 'png', 'svg'));
            if ($IconUploadResult['status']) {
                $Icon = $IconUploadResult['key'];
            } else {
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] =$IconUploadResult['error'];
                $Result['key'] = '';

                return $Result;
            }
        }

        if($_SESSION['License']['Lang2'] != '1'){
            $Title_Lang2 = '';
            $Link_Lang2 = '';
            $ShowLang2 = '0';
        }
        if($_SESSION['License']['Lang3'] != '1'){
            $Title_Lang3 = '';
            $Link_Lang3 = '';
            $ShowLang3 = '0';
        }
        if($_SESSION['License']['Lang4'] != '1'){
            $Title_Lang4 = '';
            $Link_Lang4 = '';
            $ShowLang4 = '0';
        }
        if($_SESSION['License']['Lang5'] != '1'){
            $Title_Lang5 = '';
            $Link_Lang5 = '';
            $ShowLang5 = '0';
        }

        $QUERY = $Connection->Insert('web.menu', array(), array(array('NULL', $PositionID, $Layer, $ParentID, $Title, $Link, $ShowLang1, $Title_Lang2, $Link_Lang2, $ShowLang2, $Title_Lang3, $Link_Lang3, $ShowLang3, $Title_Lang4, $Link_Lang4, $ShowLang4, $Title_Lang5, $Link_Lang5, $ShowLang5, $Icon, $Priority, $IsParent, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function GetLastMenuPriority($Connection, $PositionID){
        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Select('web.menu',array('Priority'),"`PositionID` = '$PositionID'",'Priority','Desc','1');
        if(mysqli_num_rows($QUERY) > 0){
            $row_QUERY = mysqli_fetch_assoc($QUERY);
            $NewPriority = $row_QUERY['Priority'] + 1;
        }
        else{
            $NewPriority = 1;
        }

        return $NewPriority;
    }

    public function EditMenu($Connection, $ID, $PositionID, $ParentID, $Title, $Link, $ShowLang1, $Title_Lang2, $Link_Lang2, $ShowLang2, $Title_Lang3, $Link_Lang3, $ShowLang3, $Title_Lang4, $Link_Lang4, $ShowLang4, $Title_Lang5, $Link_Lang5, $ShowLang5, $Icon, $Priority, $IsParent, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if($ParentID == ''){
            $ParentID = 'NULL';
        }

        if(isset($Icon["error"]) and $Icon["error"] != 4) {              //Upload Icon if is set
            $IconUploadResult = $General->FileUpload($Icon, true, '', array('jpg', 'jpeg', 'gif', 'png'));
            if ($IconUploadResult['status']) {
                $Icon = $IconUploadResult['key'];
            } else {
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] =$IconUploadResult['error'];
                $Result['key'] = '';

                return $Result;
            }
        }

        if($_SESSION['License']['Lang2'] != '1'){
            $ShowLang2 = '0';
        }
        if($_SESSION['License']['Lang3'] != '1'){
            $ShowLang3 = '0';
        }
        if($_SESSION['License']['Lang4'] != '1'){
            $ShowLang4 = '0';
        }
        if($_SESSION['License']['Lang5'] != '1'){
            $ShowLang5 = '0';
        }

        $QUERY = $Connection->Update('web.menu', array('PositionID' => $PositionID, 'ParentID' => $ParentID, 'Title' => $Title, 'Link' => $Link, 'ShowLang1' => $ShowLang1, 'Title_Lang2' => $Title_Lang2, 'Link_Lang2' => $Link_Lang2, 'ShowLang2' => $ShowLang2, 'Title_Lang3' => $Title_Lang3, 'Link_Lang3' => $Link_Lang3, 'ShowLang3' => $ShowLang3, 'Title_Lang4' => $Title_Lang4, 'Link_Lang4' => $Link_Lang4, 'ShowLang4' => $ShowLang4, 'Title_Lang5' => $Title_Lang5, 'Link_Lang5' => $Link_Lang5, 'ShowLang5' => $ShowLang5, 'Icon' => $Icon, 'Priority' => $Priority, 'IsParent' => $IsParent, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeleteMenu($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.menu', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectMenu($Connection, $ID, $PositionID, $Layer, $ParentID, $IsParent, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT, $ShowLang1 = '', $ShowLang2 = '', $ShowLang3 = '', $ShowLang4 = '', $ShowLang5 = '')
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        $License = $General->CheckAndGetLicense('');

        if ($ID == '' AND $Layer == '') {
            $Result['status'] = false;
            $Result['msg'] = 'وارد کردن لایه اجباری است.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Layer != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Layer`='$Layer')";
        }
        if ($ParentID != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ParentID`='$ParentID')";
        }
        if ($IsParent != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`IsParent`='$IsParent')";
        }
        if ($PositionID != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`PositionID`='$PositionID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }
        if ($ShowLang1 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang1`='$ShowLang1')";
        }
        if ($ShowLang2 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang2`='$ShowLang2')";
        }
        if ($ShowLang3 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang3`='$ShowLang3')";
        }
        if ($ShowLang4 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang4`='$ShowLang4')";
        }
        if ($ShowLang5 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ShowLang5`='$ShowLang5')";
        }

        $Query = $Connection->Select('web.menu', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {
            $ID = $row['ID'];
            $MenuPositionInfo = $this->SelectMenuPosition($Connection,$row['PositionID'],'','','','1');
            if($row['ParentID'] != ''){
                $ParentID = $row['ParentID'];
                $GetParentInfo = $Connection->Select('web.menu',array('Title'),"`ID` = '$ParentID'",'','','1');
                $ParentInfo = mysqli_fetch_assoc($GetParentInfo);
                $ParentTitle = $ParentInfo['Title'];
            }
            else{
                $ParentTitle = '----';
            }

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            if($row['IsParent'] == '1'){
                $IsParent = 'بله';
            }
            elseif($row['IsParent'] == '0'){
                $IsParent = 'خیر';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['PositionID'] = $row['PositionID'];
            $Result[$i]['PositionName'] = $MenuPositionInfo['1']['Name'];
            $Result[$i]['Layer'] = $row['Layer'];
            $Result[$i]['ParentID'] = $row['ParentID'];
            $Result[$i]['ParentTitle'] = $ParentTitle;
            $Result[$i]['Title'] = $row['Title'];
            $Result[$i]['Link'] = $row['Link'];
            $Result[$i]['ShowLang1Flag'] = $row['ShowLang1'];
            $Result[$i]['Icon'] = $row['Icon'];
            $Result[$i]['Priority'] = $row['Priority'];
            $Result[$i]['IsParent'] = $IsParent;
            $Result[$i]['IsParentFlag'] = $row['IsParent'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            if($License['Lang2'] == '1'){
                $Result[$i]['Title_Lang2'] = $row['Title_Lang2'];
                $Result[$i]['Link_Lang2'] = $row['Link_Lang2'];
                $Result[$i]['ShowLang2Flag'] = $row['ShowLang2'];
            }
            if($License['Lang3'] == '1'){
                $Result[$i]['Title_Lang3'] = $row['Title_Lang3'];
                $Result[$i]['Link_Lang3'] = $row['Link_Lang3'];
                $Result[$i]['ShowLang3Flag'] = $row['ShowLang3'];
            }
            if($License['Lang4'] == '1'){
                $Result[$i]['Title_Lang4'] = $row['Title_Lang4'];
                $Result[$i]['Link_Lang4'] = $row['Link_Lang4'];
                $Result[$i]['ShowLang4Flag'] = $row['ShowLang4'];
            }
            if($License['Lang5'] == '1'){
                $Result[$i]['Title_Lang5'] = $row['Title_Lang5'];
                $Result[$i]['Link_Lang5'] = $row['Link_Lang5'];
                $Result[$i]['ShowLang5Flag'] = $row['ShowLang5'];
            }

            ######### Get Childes #########
            $GetChildes = $Connection->Select('web.menu',array('*'),"`ParentID` = '$ID'",$ORDER_BY,$ORDER_TYPE,'');
            $x = '1';
            while ($RowChildes = mysqli_fetch_assoc($GetChildes)) {

                if ($RowChildes['Status'] == '1') {
                    $Status = 'فعال';
                } elseif ($RowChildes['Status'] == '0') {
                    $Status = 'غیرفعال';
                }

                if($RowChildes['IsParent'] == '1'){
                    $IsParent = 'بله';
                }
                elseif($RowChildes['IsParent'] == '0'){
                    $IsParent = 'خیر';
                }

                $ChildID = $RowChildes['ID'];

                $Result[$i]['Child'][$x]['ID'] = $ChildID;
                $Result[$i]['Child'][$x]['PositionID'] = $RowChildes['PositionID'];
                $Result[$i]['Child'][$x]['PositionName'] = $Result[$i]['PositionName'];
                $Result[$i]['Child'][$x]['Layer'] = $RowChildes['Layer'];
                $Result[$i]['Child'][$x]['ParentID'] = $RowChildes['ParentID'];
                $Result[$i]['Child'][$x]['ParentTitle'] = $Result[$i]['Title'];
                $Result[$i]['Child'][$x]['Title'] = $RowChildes['Title'];
                $Result[$i]['Child'][$x]['Link'] = $RowChildes['Link'];
                $Result[$i]['Child'][$x]['ShowLang1Flag'] = $RowChildes['ShowLang1'];
                $Result[$i]['Child'][$x]['Icon'] = $RowChildes['Icon'];
                $Result[$i]['Child'][$x]['Priority'] = $RowChildes['Priority'];
                $Result[$i]['Child'][$x]['IsParent'] = $IsParent;
                $Result[$i]['Child'][$x]['IsParentFlag'] = $RowChildes['IsParent'];
                $Result[$i]['Child'][$x]['StatusFlag'] = $RowChildes['Status'];
                $Result[$i]['Child'][$x]['Status'] = $Status;

                if($License['Lang2'] == '1'){
                    $Result[$i]['Child'][$x]['Title_Lang2'] = $RowChildes['Title_Lang2'];
                    $Result[$i]['Child'][$x]['Link_Lang2'] = $RowChildes['Link_Lang2'];
                    $Result[$i]['Child'][$x]['ShowLang2Flag'] = $RowChildes['ShowLang2'];
                }
                if($License['Lang3'] == '1'){
                    $Result[$i]['Child'][$x]['Title_Lang3'] = $RowChildes['Title_Lang3'];
                    $Result[$i]['Child'][$x]['Link_Lang3'] = $RowChildes['Link_Lang3'];
                    $Result[$i]['Child'][$x]['ShowLang3Flag'] = $RowChildes['ShowLang3'];
                }
                if($License['Lang4'] == '1'){
                    $Result[$i]['Child'][$x]['Title_Lang4'] = $RowChildes['Title_Lang4'];
                    $Result[$i]['Child'][$x]['Link_Lang4'] = $RowChildes['Link_Lang4'];
                    $Result[$i]['Child'][$x]['ShowLang4Flag'] = $RowChildes['ShowLang4'];
                }
                if($License['Lang5'] == '1'){
                    $Result[$i]['Child'][$x]['Title_Lang5'] = $RowChildes['Title_Lang5'];
                    $Result[$i]['Child'][$x]['Link_Lang5'] = $RowChildes['Link_Lang5'];
                    $Result[$i]['Child'][$x]['ShowLang5Flag'] = $RowChildes['ShowLang5'];
                }

                ######### Get Second childes #########
                $GetSecondChildes = $Connection->Select('web.menu',array('*'),"`ParentID` = '$ChildID'",$ORDER_BY,$ORDER_TYPE,'');
                $y = '1';
                while($RowSecondChildes = mysqli_fetch_assoc($GetSecondChildes)){

                    $SecondChildID = $RowSecondChildes['ID'];

                    if ($RowSecondChildes['Status'] == '1') {
                        $Status = 'فعال';
                    } elseif ($RowSecondChildes['Status'] == '0') {
                        $Status = 'غیرفعال';
                    }

                    if($RowSecondChildes['IsParent'] == '1'){
                        $IsParent = 'بله';
                    }
                    elseif($RowSecondChildes['IsParent'] == '0'){
                        $IsParent = 'خیر';
                    }

                    $Result[$i]['Child'][$x]['Child'][$y]['ID'] = $SecondChildID;
                    $Result[$i]['Child'][$x]['Child'][$y]['PositionID'] = $RowSecondChildes['PositionID'];
                    $Result[$i]['Child'][$x]['Child'][$y]['PositionName'] = $Result[$i]['PositionName'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Layer'] = $RowSecondChildes['Layer'];
                    $Result[$i]['Child'][$x]['Child'][$y]['ParentID'] = $RowSecondChildes['ParentID'];
                    $Result[$i]['Child'][$x]['Child'][$y]['ParentTitle'] = $Result[$i]['Child'][$x]['Title'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Title'] = $RowSecondChildes['Title'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Link'] = $RowSecondChildes['Link'];
                    $Result[$i]['Child'][$x]['Child'][$y]['ShowLang1Flag'] = $RowSecondChildes['ShowLang1'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Icon'] = $RowSecondChildes['Icon'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Priority'] = $RowSecondChildes['Priority'];
                    $Result[$i]['Child'][$x]['Child'][$y]['IsParent'] = $IsParent;
                    $Result[$i]['Child'][$x]['Child'][$y]['IsParentFlag'] = $RowSecondChildes['IsParent'];
                    $Result[$i]['Child'][$x]['Child'][$y]['StatusFlag'] = $RowSecondChildes['Status'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Status'] = $Status;

                    if($License['Lang2'] == '1'){
                        $Result[$i]['Child'][$x]['Child'][$y]['Title_Lang2'] = $RowSecondChildes['Title_Lang2'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Link_Lang2'] = $RowSecondChildes['Link_Lang2'];
                        $Result[$i]['Child'][$x]['Child'][$y]['ShowLang2Flag'] = $RowSecondChildes['ShowLang2'];
                    }
                    if($License['Lang3'] == '1'){
                        $Result[$i]['Child'][$x]['Child'][$y]['Title_Lang3'] = $RowSecondChildes['Title_Lang3'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Link_Lang3'] = $RowSecondChildes['Link_Lang3'];
                        $Result[$i]['Child'][$x]['Child'][$y]['ShowLang3Flag'] = $RowSecondChildes['ShowLang3'];
                    }
                    if($License['Lang4'] == '1'){
                        $Result[$i]['Child'][$x]['Child'][$y]['Title_Lang4'] = $RowSecondChildes['Title_Lang4'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Link_Lang4'] = $RowSecondChildes['Link_Lang4'];
                        $Result[$i]['Child'][$x]['Child'][$y]['ShowLang4Flag'] = $RowSecondChildes['ShowLang4'];
                    }
                    if($License['Lang5'] == '1'){
                        $Result[$i]['Child'][$x]['Child'][$y]['Title_Lang5'] = $RowSecondChildes['Title_Lang5'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Link_Lang5'] = $RowSecondChildes['Link_Lang5'];
                        $Result[$i]['Child'][$x]['Child'][$y]['ShowLang5Flag'] = $RowSecondChildes['ShowLang5'];
                    }

                    ######### Get Third childes #########
                    $GetThirdChildes = $Connection->Select('web.menu',array('*'),"`ParentID` = '$SecondChildID'",$ORDER_BY,$ORDER_TYPE,'');
                    $z = '1';
                    while($RowThirdChildes = mysqli_fetch_assoc($GetThirdChildes)){

                        $ThirdChildID = $RowThirdChildes['ID'];

                        if ($RowThirdChildes['Status'] == '1') {
                            $Status = 'فعال';
                        } elseif ($RowThirdChildes['Status'] == '0') {
                            $Status = 'غیرفعال';
                        }

                        if($RowThirdChildes['IsParent'] == '1'){
                            $IsParent = 'بله';
                        }
                        elseif($RowThirdChildes['IsParent'] == '0'){
                            $IsParent = 'خیر';
                        }

                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ID'] = $ThirdChildID;
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['PositionID'] = $RowThirdChildes['PositionID'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['PositionName'] = $Result[$i]['PositionName'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Layer'] = $RowThirdChildes['Layer'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ParentID'] = $RowThirdChildes['ParentID'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ParentTitle'] = $Result[$i]['Child'][$x]['Child'][$y]['Title'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Title'] = $RowThirdChildes['Title'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Link'] = $RowThirdChildes['Link'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ShowLang1Flag'] = $RowThirdChildes['ShowLang1'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Icon'] = $RowThirdChildes['Icon'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Priority'] = $RowThirdChildes['Priority'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['IsParent'] = $IsParent;
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['IsParentFlag'] = $RowThirdChildes['IsParent'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['StatusFlag'] = $RowThirdChildes['Status'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Status'] = $Status;

                        if($License['Lang2'] == '1'){
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Title_Lang2'] = $RowThirdChildes['Title_Lang2'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Link_Lang2'] = $RowThirdChildes['Link_Lang2'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ShowLang2Flag'] = $RowThirdChildes['ShowLang2'];
                        }
                        if($License['Lang3'] == '1'){
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Title_Lang3'] = $RowThirdChildes['Title_Lang3'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Link_Lang3'] = $RowThirdChildes['Link_Lang3'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ShowLang3Flag'] = $RowThirdChildes['ShowLang3'];
                        }
                        if($License['Lang4'] == '1'){
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Title_Lang4'] = $RowThirdChildes['Title_Lang4'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Link_Lang4'] = $RowThirdChildes['Link_Lang4'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ShowLang4Flag'] = $RowThirdChildes['ShowLang4'];
                        }
                        if($License['Lang5'] == '1'){
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Title_Lang5'] = $RowThirdChildes['Title_Lang5'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Link_Lang5'] = $RowThirdChildes['Link_Lang5'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ShowLang5Flag'] = $RowThirdChildes['ShowLang5'];
                        }

                        $z++;

                    }
                    ######### Get Third childes #########

                    $y++;

                }
                ######### Get Second childes #########

                $x++;
            }
            ######### Get Childes #########

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function AddPostCategory($Connection, $Layer, $ParentID, $Name, $Name_Lang2, $Name_Lang3, $Name_Lang4, $Name_Lang5, $SEO_Title, $SEO_Description, $SEO_Keywords, $Slug, $SEO_Title_Lang2, $SEO_Description_Lang2, $SEO_Keywords_Lang2, $Slug_Lang2, $SEO_Title_Lang3, $SEO_Description_Lang3, $SEO_Keywords_Lang3, $Slug_Lang3, $SEO_Title_Lang4, $SEO_Description_Lang4, $SEO_Keywords_Lang4, $Slug_Lang4, $SEO_Title_Lang5, $SEO_Description_Lang5, $SEO_Keywords_Lang5, $Slug_Lang5)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        if ($Layer > 1 AND $ParentID == '') {
            $Result['status'] = false;
            $Result['msg'] = 'انتخاب دسته بندی والد اجباری است.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        if($Slug == ''){                //Define slug
            if($SEO_Title != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Name);
            }
            $Slug = str_replace(' ', '-',$TempSlug);
            $FinalSlug = '';

            $i = 1;
            while($FinalSlug == ''){

                if ($Connection->NumRows('web.post_category', 'ID', "`Slug` = '$Slug'") > 0) {
                    $Slug .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug = $Slug;
                }

            }
        }

        if($Slug_Lang2 == ''){                //Define slug
            if($SEO_Title_Lang2 != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title_Lang2);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Name_Lang2);
            }
            $Slug_Lang2 = str_replace(' ', '-',$TempSlug);
            $FinalSlug_Lang2 = '';

            $i = 1;
            while($FinalSlug_Lang2 == ''){

                if ($Connection->NumRows('web.post_category', 'ID', "`Slug_Lang2` = '$Slug_Lang2'") > 0) {
                    $Slug_Lang2 .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug_Lang2 = $Slug_Lang2;
                }

            }
        }

        if($Slug_Lang3 == ''){                //Define slug
            if($SEO_Title_Lang3 != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title_Lang3);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Name_Lang3);
            }
            $Slug_Lang3 = str_replace(' ', '-',$TempSlug);
            $FinalSlug_Lang3 = '';

            $i = 1;
            while($FinalSlug_Lang3 == ''){

                if ($Connection->NumRows('web.post_category', 'ID', "`Slug_Lang3` = '$Slug_Lang3'") > 0) {
                    $Slug_Lang3 .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug_Lang3 = $Slug_Lang3;
                }

            }
        }

        if($Slug_Lang4 == ''){                //Define slug
            if($SEO_Title_Lang4 != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title_Lang4);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Name_Lang4);
            }
            $Slug_Lang4 = str_replace(' ', '-',$TempSlug);
            $FinalSlug_Lang4 = '';

            $i = 1;
            while($FinalSlug_Lang4 == ''){

                if ($Connection->NumRows('web.post_category', 'ID', "`Slug_Lang4` = '$Slug_Lang4'") > 0) {
                    $Slug_Lang4 .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug_Lang4 = $Slug_Lang4;
                }

            }
        }

        if($Slug_Lang5 == ''){                //Define slug
            if($SEO_Title_Lang5 != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title_Lang5);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Name_Lang5);
            }
            $Slug_Lang5 = str_replace(' ', '-',$TempSlug);
            $FinalSlug_Lang5 = '';

            $i = 1;
            while($FinalSlug_Lang5 == ''){

                if ($Connection->NumRows('web.post_category', 'ID', "`Slug_Lang5` = '$Slug_Lang5'") > 0) {
                    $Slug_Lang5 .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug_Lang5 = $Slug_Lang5;
                }

            }
        }

        if($ParentID == ''){
            $ParentID = 'NULL';
        }

        $QUERY = $Connection->Insert('web.post_category', array(), array(array('NULL', $Layer, $ParentID, $Name, $Name_Lang2, $Name_Lang3, $Name_Lang4, $Name_Lang5, $SEO_Title, $SEO_Description, $SEO_Keywords, $Slug, $SEO_Title_Lang2, $SEO_Description_Lang2, $SEO_Keywords_Lang2, $Slug_Lang2, $SEO_Title_Lang3, $SEO_Description_Lang3, $SEO_Keywords_Lang3, $Slug_Lang3, $SEO_Title_Lang4, $SEO_Description_Lang4, $SEO_Keywords_Lang4, $Slug_Lang4, $SEO_Title_Lang5, $SEO_Description_Lang5, $SEO_Keywords_Lang5, $Slug_Lang5, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function EditPostCategory($Connection, $ID, $Layer, $ParentID, $Name, $Name_Lang2, $Name_Lang3, $Name_Lang4, $Name_Lang5, $SEO_Title, $SEO_Description, $SEO_Keywords, $SEO_Title_Lang2, $SEO_Description_Lang2, $SEO_Keywords_Lang2, $SEO_Title_Lang3, $SEO_Description_Lang3, $SEO_Keywords_Lang3, $SEO_Title_Lang4, $SEO_Description_Lang4, $SEO_Keywords_Lang4, $SEO_Title_Lang5, $SEO_Description_Lang5, $SEO_Keywords_Lang5, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        if ($Layer > 1 AND $ParentID == '') {
            $Result['status'] = false;
            $Result['msg'] = 'انتخاب دسته بندی والد اجباری است.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        if($ParentID == ''){
            $ParentID = 'NULL';
        }

        $QUERY = $Connection->Update('web.post_category', array('Layer' => $Layer, 'ParentID' => $ParentID, 'Name' => $Name, 'Name_Lang2' => $Name_Lang2, 'Name_Lang3' => $Name_Lang3, 'Name_Lang4' => $Name_Lang4, 'Name_Lang5' => $Name_Lang5, 'SEO_Title' => $SEO_Title, 'SEO_Description' => $SEO_Description, 'SEO_Keywords' => $SEO_Keywords, 'SEO_Title_Lang2' => $SEO_Title_Lang2, 'SEO_Description_Lang2' => $SEO_Description_Lang2, 'SEO_Keywords_Lang2' => $SEO_Keywords_Lang2, 'SEO_Title_Lang3' => $SEO_Title_Lang3, 'SEO_Description_Lang3' => $SEO_Description_Lang3, 'SEO_Keywords_Lang3' => $SEO_Keywords_Lang3, 'SEO_Title_Lang4' => $SEO_Title_Lang4, 'SEO_Description_Lang4' => $SEO_Description_Lang4, 'SEO_Keywords_Lang4' => $SEO_Keywords_Lang4, 'SEO_Title_Lang5' => $SEO_Title_Lang5, 'SEO_Description_Lang5' => $SEO_Description_Lang5, 'SEO_Keywords_Lang5' => $SEO_Keywords_Lang5, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeletePostCategory($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.post_category', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectPostCategory($Connection, $ID, $Layer, $ParentID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT, $Slug = '', $Slug_Lang2 = '', $Slug_Lang3 = '', $Slug_Lang4 = '', $Slug_Lang5 = '')
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        $Settings = $General->GetSettings($Connection);

        $License = $General->CheckAndGetLicense($Connection);

        if ($ID == '' AND $Slug == '' AND $Slug_Lang2 == '' AND $Slug_Lang3 == '' AND $Slug_Lang4 == '' AND $Slug_Lang5 == '' AND $Layer == '') {
            $Result['status'] = false;
            $Result['msg'] = 'وارد کردن لایه اجباری است.';
            $Result['error'] = '';
            $Result['key'] = '';

            return $Result;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Layer != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Layer`='$Layer')";
        }
        if ($ParentID != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`ParentID`='$ParentID')";
        }
        if ($Slug != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug`='$Slug')";
        }
        if ($Slug_Lang2 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug_Lang2`='$Slug_Lang2')";
        }
        if ($Slug_Lang3 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug_Lang3`='$Slug_Lang3')";
        }
        if ($Slug_Lang4 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug_Lang4`='$Slug_Lang4')";
        }
        if ($Slug_Lang5 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug_Lang5`='$Slug_Lang5')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.post_category', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            if ($row['Status'] == '1') {
                $Status = 'فعال';
            } elseif ($row['Status'] == '0') {
                $Status = 'غیرفعال';
            } else {
                $Status = '----';
            }

            $ID = $row['ID'];

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['Layer'] = $row['Layer'];
            $Result[$i]['ParentID'] = $row['ParentID'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];
            if($row['SEO_Title'] != '') {
                $Result[$i]['SEO_Title'] = $row['SEO_Title'];
            }
            else{
                $Result[$i]['SEO_Title'] = $row['Name'];
            }
            if($row['SEO_Description'] != '') {
                $Result[$i]['SEO_Description'] = $row['SEO_Description'];
            }
            else{
                $Result[$i]['SEO_Description'] = $Settings['bas_SiteTitle'];
            }
            $Result[$i]['SEO_Keywords'] = $row['SEO_Keywords'];
            $Result[$i]['Slug'] = $row['Slug'];

            if($License['Lang2'] == '1'){
                $Result[$i]['Name_Lang2'] = $row['Name_Lang2'];

                if($row['SEO_Title_Lang2'] != '') {
                    $Result[$i]['SEO_Title_Lang2'] = $row['SEO_Title_Lang2'];
                }
                else{
                    $Result[$i]['SEO_Title_Lang2'] = $row['Name_Lang2'];
                }
                if($row['SEO_Description_Lang2'] != '') {
                    $Result[$i]['SEO_Description_Lang2'] = $row['SEO_Description_Lang2'];
                }
                else{
                    $Result[$i]['SEO_Description_Lang2'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['SEO_Keywords_Lang2'] = $row['SEO_Keywords_Lang2'];
                $Result[$i]['Slug_Lang2'] = $row['Slug_Lang2'];

            }

            if($License['Lang3'] == '1'){
                $Result[$i]['Name_Lang3'] = $row['Name_Lang3'];

                if($row['SEO_Title_Lang3'] != '') {
                    $Result[$i]['SEO_Title_Lang3'] = $row['SEO_Title_Lang3'];
                }
                else{
                    $Result[$i]['SEO_Title_Lang3'] = $row['Name_Lang3'];
                }
                if($row['SEO_Description_Lang3'] != '') {
                    $Result[$i]['SEO_Description_Lang3'] = $row['SEO_Description_Lang3'];
                }
                else{
                    $Result[$i]['SEO_Description_Lang3'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['SEO_Keywords_Lang3'] = $row['SEO_Keywords_Lang3'];
                $Result[$i]['Slug_Lang3'] = $row['Slug_Lang3'];

            }

            if($License['Lang4'] == '1'){
                $Result[$i]['Name_Lang4'] = $row['Name_Lang4'];

                if($row['SEO_Title_Lang4'] != '') {
                    $Result[$i]['SEO_Title_Lang4'] = $row['SEO_Title_Lang4'];
                }
                else{
                    $Result[$i]['SEO_Title_Lang4'] = $row['Name_Lang4'];
                }
                if($row['SEO_Description_Lang4'] != '') {
                    $Result[$i]['SEO_Description_Lang4'] = $row['SEO_Description_Lang4'];
                }
                else{
                    $Result[$i]['SEO_Description_Lang4'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['SEO_Keywords_Lang4'] = $row['SEO_Keywords_Lang4'];
                $Result[$i]['Slug_Lang4'] = $row['Slug_Lang4'];

            }

            if($License['Lang5'] == '1'){
                $Result[$i]['Name_Lang5'] = $row['Name_Lang5'];

                if($row['SEO_Title_Lang5'] != '') {
                    $Result[$i]['SEO_Title_Lang5'] = $row['SEO_Title_Lang5'];
                }
                else{
                    $Result[$i]['SEO_Title_Lang5'] = $row['Name_Lang4'];
                }
                if($row['SEO_Description_Lang5'] != '') {
                    $Result[$i]['SEO_Description_Lang5'] = $row['SEO_Description_Lang5'];
                }
                else{
                    $Result[$i]['SEO_Description_Lang5'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['SEO_Keywords_Lang5'] = $row['SEO_Keywords_Lang5'];
                $Result[$i]['Slug_Lang5'] = $row['Slug_Lang5'];

            }

            ######### Get Childes #########
            $GetChildes = $Connection->Select('web.post_category',array('*'),"`ParentID` = '$ID'",$ORDER_BY,$ORDER_TYPE,'');
            $x = '1';
            while ($RowChildes = mysqli_fetch_assoc($GetChildes)) {

                if ($RowChildes['Status'] == '1') {
                    $Status = 'فعال';
                } elseif ($RowChildes['Status'] == '0') {
                    $Status = 'غیرفعال';
                } else {
                    $Status = '----';
                }

                $ChildID = $RowChildes['ID'];

                $Result[$i]['Child'][$x]['ID'] = $ChildID;
                $Result[$i]['Child'][$x]['Layer'] = $RowChildes['Layer'];
                $Result[$i]['Child'][$x]['ParentID'] = $RowChildes['ParentID'];
                $Result[$i]['Child'][$x]['Name'] = $RowChildes['Name'];
                $Result[$i]['Child'][$x]['StatusFlag'] = $RowChildes['Status'];
                $Result[$i]['Child'][$x]['Status'] = $Status;
                if($RowChildes['SEO_Title'] != '') {
                    $Result[$i]['Child'][$x]['SEO_Title'] = $RowChildes['SEO_Title'];
                }
                else{
                    $Result[$i]['Child'][$x]['SEO_Title'] = $RowChildes['Name'];
                }
                if($RowChildes['SEO_Description'] != '') {
                    $Result[$i]['Child'][$x]['SEO_Description'] = $RowChildes['SEO_Description'];
                }
                else{
                    $Result[$i]['Child'][$x]['SEO_Description'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['Child'][$x]['SEO_Keywords'] = $RowChildes['SEO_Keywords'];
                $Result[$i]['Child'][$x]['Slug'] = $RowChildes['Slug'];

                if($License['Lang2'] == '1'){
                    $Result[$i]['Child'][$x]['Name_Lang2'] = $RowChildes['Name_Lang2'];

                    if($RowChildes['SEO_Title_Lang2'] != '') {
                        $Result[$i]['Child'][$x]['SEO_Title_Lang2'] = $RowChildes['SEO_Title_Lang2'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['SEO_Title_Lang2'] = $RowChildes['Name_Lang2'];
                    }
                    if($RowChildes['SEO_Description_Lang2'] != '') {
                        $Result[$i]['Child'][$x]['SEO_Description_Lang2'] = $RowChildes['SEO_Description_Lang2'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['SEO_Description_Lang2'] = $Settings['bas_SiteTitle'];
                    }
                    $Result[$i]['Child'][$x]['SEO_Keywords_Lang2'] = $RowChildes['SEO_Keywords_Lang2'];
                    $Result[$i]['Child'][$x]['Slug_Lang2'] = $RowChildes['Slug_Lang2'];

                }

                if($License['Lang3'] == '1'){
                    $Result[$i]['Child'][$x]['Name_Lang3'] = $RowChildes['Name_Lang3'];

                    if($RowChildes['SEO_Title_Lang3'] != '') {
                        $Result[$i]['Child'][$x]['SEO_Title_Lang3'] = $RowChildes['SEO_Title_Lang3'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['SEO_Title_Lang3'] = $RowChildes['Name_Lang3'];
                    }
                    if($RowChildes['SEO_Description_Lang3'] != '') {
                        $Result[$i]['Child'][$x]['SEO_Description_Lang3'] = $RowChildes['SEO_Description_Lang3'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['SEO_Description_Lang3'] = $Settings['bas_SiteTitle'];
                    }
                    $Result[$i]['Child'][$x]['SEO_Keywords_Lang3'] = $RowChildes['SEO_Keywords_Lang3'];
                    $Result[$i]['Child'][$x]['Slug_Lang3'] = $RowChildes['Slug_Lang3'];

                }

                if($License['Lang4'] == '1'){
                    $Result[$i]['Child'][$x]['Name_Lang4'] = $RowChildes['Name_Lang4'];

                    if($RowChildes['SEO_Title_Lang4'] != '') {
                        $Result[$i]['Child'][$x]['SEO_Title_Lang4'] = $RowChildes['SEO_Title_Lang4'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['SEO_Title_Lang4'] = $RowChildes['Name_Lang4'];
                    }
                    if($RowChildes['SEO_Description_Lang4'] != '') {
                        $Result[$i]['Child'][$x]['SEO_Description_Lang4'] = $RowChildes['SEO_Description_Lang4'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['SEO_Description_Lang4'] = $Settings['bas_SiteTitle'];
                    }
                    $Result[$i]['Child'][$x]['SEO_Keywords_Lang4'] = $RowChildes['SEO_Keywords_Lang4'];
                    $Result[$i]['Child'][$x]['Slug_Lang4'] = $RowChildes['Slug_Lang4'];

                }

                if($License['Lang5'] == '1'){
                    $Result[$i]['Child'][$x]['Name_Lang5'] = $RowChildes['Name_Lang5'];

                    if($RowChildes['SEO_Title_Lang5'] != '') {
                        $Result[$i]['Child'][$x]['SEO_Title_Lang5'] = $RowChildes['SEO_Title_Lang5'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['SEO_Title_Lang5'] = $RowChildes['Name_Lang4'];
                    }
                    if($RowChildes['SEO_Description_Lang5'] != '') {
                        $Result[$i]['Child'][$x]['SEO_Description_Lang5'] = $RowChildes['SEO_Description_Lang5'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['SEO_Description_Lang5'] = $Settings['bas_SiteTitle'];
                    }
                    $Result[$i]['Child'][$x]['SEO_Keywords_Lang5'] = $RowChildes['SEO_Keywords_Lang5'];
                    $Result[$i]['Child'][$x]['Slug_Lang5'] = $RowChildes['Slug_Lang5'];

                }

                ######### Get Second childes #########
                $GetSecondChildes = $Connection->Select('web.post_category',array('*'),"`ParentID` = '$ChildID'",$ORDER_BY,$ORDER_TYPE,'');
                $y = '1';
                while($RowSecondChildes = mysqli_fetch_assoc($GetSecondChildes)){

                    $SecondChildID = $RowSecondChildes['ID'];

                    if ($RowSecondChildes['Status'] == '1') {
                        $Status = 'فعال';
                    } elseif ($RowSecondChildes['Status'] == '0') {
                        $Status = 'غیرفعال';
                    } else {
                        $Status = '----';
                    }

                    $Result[$i]['Child'][$x]['Child'][$y]['ID'] = $SecondChildID;
                    $Result[$i]['Child'][$x]['Child'][$y]['Layer'] = $RowSecondChildes['Layer'];
                    $Result[$i]['Child'][$x]['Child'][$y]['ParentID'] = $RowSecondChildes['ParentID'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Name'] = $RowSecondChildes['Name'];
                    $Result[$i]['Child'][$x]['Child'][$y]['StatusFlag'] = $RowSecondChildes['Status'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Status'] = $Status;
                    if($RowSecondChildes['SEO_Title'] != '') {
                        $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title'] = $RowSecondChildes['SEO_Title'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title'] = $RowSecondChildes['Name'];
                    }
                    if($RowSecondChildes['SEO_Description'] != '') {
                        $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description'] = $RowSecondChildes['SEO_Description'];
                    }
                    else{
                        $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description'] = $Settings['bas_SiteTitle'];
                    }
                    $Result[$i]['Child'][$x]['Child'][$y]['SEO_Keywords'] = $RowSecondChildes['SEO_Keywords'];
                    $Result[$i]['Child'][$x]['Child'][$y]['Slug'] = $RowSecondChildes['Slug'];

                    if($License['Lang2'] == '1'){
                        $Result[$i]['Child'][$x]['Child'][$y]['Name_Lang2'] = $RowSecondChildes['Name_Lang2'];

                        if($RowSecondChildes['SEO_Title_Lang2'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title_Lang2'] = $RowSecondChildes['SEO_Title_Lang2'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title_Lang2'] = $RowSecondChildes['Name_Lang2'];
                        }
                        if($RowSecondChildes['SEO_Description_Lang2'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description_Lang2'] = $RowSecondChildes['SEO_Description_Lang2'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description_Lang2'] = $Settings['bas_SiteTitle'];
                        }
                        $Result[$i]['Child'][$x]['Child'][$y]['SEO_Keywords_Lang2'] = $RowSecondChildes['SEO_Keywords_Lang2'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Slug_Lang2'] = $RowSecondChildes['Slug_Lang2'];

                    }

                    if($License['Lang3'] == '1'){
                        $Result[$i]['Child'][$x]['Child'][$y]['Name_Lang3'] = $RowSecondChildes['Name_Lang3'];

                        if($row['SEO_Title_Lang3'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title_Lang3'] = $RowSecondChildes['SEO_Title_Lang3'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title_Lang3'] = $RowSecondChildes['Name_Lang3'];
                        }
                        if($row['SEO_Description_Lang3'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description_Lang3'] = $RowSecondChildes['SEO_Description_Lang3'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description_Lang3'] = $Settings['bas_SiteTitle'];
                        }
                        $Result[$i]['Child'][$x]['Child'][$y]['SEO_Keywords_Lang3'] = $RowSecondChildes['SEO_Keywords_Lang3'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Slug_Lang3'] = $RowSecondChildes['Slug_Lang3'];

                    }

                    if($License['Lang4'] == '1'){
                        $Result[$i]['Child'][$x]['Child'][$y]['Name_Lang4'] = $RowSecondChildes['Name_Lang4'];

                        if($RowSecondChildes['SEO_Title_Lang4'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title_Lang4'] = $RowSecondChildes['SEO_Title_Lang4'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title_Lang4'] = $RowSecondChildes['Name_Lang4'];
                        }
                        if($RowSecondChildes['SEO_Description_Lang4'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description_Lang4'] = $RowSecondChildes['SEO_Description_Lang4'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description_Lang4'] = $Settings['bas_SiteTitle'];
                        }
                        $Result[$i]['Child'][$x]['Child'][$y]['SEO_Keywords_Lang4'] = $RowSecondChildes['SEO_Keywords_Lang4'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Slug_Lang4'] = $RowSecondChildes['Slug_Lang4'];

                    }

                    if($License['Lang5'] == '1'){
                        $Result[$i]['Child'][$x]['Child'][$y]['Name_Lang5'] = $RowSecondChildes['Name_Lang5'];

                        if($row['SEO_Title_Lang5'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title_Lang5'] = $RowSecondChildes['SEO_Title_Lang5'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Title_Lang5'] = $RowSecondChildes['Name_Lang4'];
                        }
                        if($row['SEO_Description_Lang5'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description_Lang5'] = $RowSecondChildes['SEO_Description_Lang5'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['SEO_Description_Lang5'] = $Settings['bas_SiteTitle'];
                        }
                        $Result[$i]['Child'][$x]['Child'][$y]['SEO_Keywords_Lang5'] = $RowSecondChildes['SEO_Keywords_Lang5'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Slug_Lang5'] = $RowSecondChildes['Slug_Lang5'];

                    }

                    ######### Get Third childes #########
                    $GetThirdChildes = $Connection->Select('web.post_category',array('*'),"`ParentID` = '$SecondChildID'",$ORDER_BY,$ORDER_TYPE,'');
                    $z = '1';
                    while($RowThirdChildes = mysqli_fetch_assoc($GetThirdChildes)){

                        $ThirdChildID = $RowThirdChildes['ID'];

                        if ($RowThirdChildes['Status'] == '1') {
                            $Status = 'فعال';
                        } elseif ($RowThirdChildes['Status'] == '0') {
                            $Status = 'غیرفعال';
                        } else {
                            $Status = '----';
                        }

                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ID'] = $ThirdChildID;
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Layer'] = $RowThirdChildes['Layer'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['ParentID'] = $RowThirdChildes['ParentID'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Name'] = $RowThirdChildes['Name'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['StatusFlag'] = $RowThirdChildes['Status'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Status'] = $Status;
                        if($RowThirdChildes['SEO_Title'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title'] = $RowThirdChildes['SEO_Title'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title'] = $RowThirdChildes['Name'];
                        }
                        if($RowThirdChildes['SEO_Description'] != '') {
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description'] = $RowThirdChildes['SEO_Description'];
                        }
                        else{
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description'] = $Settings['bas_SiteTitle'];
                        }
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Keywords'] = $RowThirdChildes['SEO_Keywords'];
                        $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Slug'] = $RowThirdChildes['Slug'];

                        if($License['Lang2'] == '1'){
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Name_Lang2'] = $RowThirdChildes['Name_Lang2'];

                            if($RowThirdChildes['SEO_Title_Lang2'] != '') {
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title_Lang2'] = $RowThirdChildes['SEO_Title_Lang2'];
                            }
                            else{
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title_Lang2'] = $RowThirdChildes['Name_Lang2'];
                            }
                            if($RowThirdChildes['SEO_Description_Lang2'] != '') {
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description_Lang2'] = $RowThirdChildes['SEO_Description_Lang2'];
                            }
                            else{
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description_Lang2'] = $Settings['bas_SiteTitle'];
                            }
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Keywords_Lang2'] = $RowThirdChildes['SEO_Keywords_Lang2'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Slug_Lang2'] = $RowThirdChildes['Slug_Lang2'];

                        }

                        if($License['Lang3'] == '1'){
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Name_Lang3'] = $RowThirdChildes['Name_Lang3'];

                            if($RowThirdChildes['SEO_Title_Lang3'] != '') {
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title_Lang3'] = $RowThirdChildes['SEO_Title_Lang3'];
                            }
                            else{
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title_Lang3'] = $RowThirdChildes['Name_Lang3'];
                            }
                            if($RowThirdChildes['SEO_Description_Lang3'] != '') {
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description_Lang3'] = $RowThirdChildes['SEO_Description_Lang3'];
                            }
                            else{
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description_Lang3'] = $Settings['bas_SiteTitle'];
                            }
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Keywords_Lang3'] = $RowThirdChildes['SEO_Keywords_Lang3'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Slug_Lang3'] = $RowThirdChildes['Slug_Lang3'];

                        }

                        if($License['Lang4'] == '1'){
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Name_Lang4'] = $RowThirdChildes['Name_Lang4'];

                            if($RowThirdChildes['SEO_Title_Lang4'] != '') {
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title_Lang4'] = $RowThirdChildes['SEO_Title_Lang4'];
                            }
                            else{
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title_Lang4'] = $RowThirdChildes['Name_Lang4'];
                            }
                            if($RowThirdChildes['SEO_Description_Lang4'] != '') {
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description_Lang4'] = $RowThirdChildes['SEO_Description_Lang4'];
                            }
                            else{
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description_Lang4'] = $Settings['bas_SiteTitle'];
                            }
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Keywords_Lang4'] = $RowThirdChildes['SEO_Keywords_Lang4'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Slug_Lang4'] = $RowThirdChildes['Slug_Lang4'];

                        }

                        if($License['Lang5'] == '1'){
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Name_Lang5'] = $RowThirdChildes['Name_Lang5'];

                            if($RowThirdChildes['SEO_Title_Lang5'] != '') {
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title_Lang5'] = $RowThirdChildes['SEO_Title_Lang5'];
                            }
                            else{
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Title_Lang5'] = $RowThirdChildes['Name_Lang4'];
                            }
                            if($RowThirdChildes['SEO_Description_Lang5'] != '') {
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description_Lang5'] = $RowThirdChildes['SEO_Description_Lang5'];
                            }
                            else{
                                $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Description_Lang5'] = $Settings['bas_SiteTitle'];
                            }
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['SEO_Keywords_Lang5'] = $RowThirdChildes['SEO_Keywords_Lang5'];
                            $Result[$i]['Child'][$x]['Child'][$y]['Child'][$z]['Slug_Lang5'] = $RowThirdChildes['Slug_Lang5'];

                        }

                        $z++;

                    }
                    ######### Get Third childes #########

                    $y++;

                }
                ######### Get Second childes #########

                $x++;
            }
            ######### Get Childes #########

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    /*
     * Type: 1 => Post
     * Type: 2 => Page
     * Status: 1 => Enable
     * Status: 0 => Disable
     */
    public function AddPost($Connection, $Type, $Title, $Context, $Content, $FormID, $Title_Lang2, $Context_Lang2, $Content_Lang2, $FormID_Lang2, $Title_Lang3, $Context_Lang3, $Content_Lang3, $FormID_Lang3, $Title_Lang4, $Context_Lang4, $Content_Lang4, $FormID_Lang4, $Title_Lang5, $Context_Lang5, $Content_Lang5, $FormID_Lang5, $CategoryID, $Thumb, $SEO_Title, $SEO_Description, $SEO_Keywords, $Slug, $SEO_Title_Lang2, $SEO_Description_Lang2, $SEO_Keywords_Lang2, $Slug_Lang2, $SEO_Title_Lang3, $SEO_Description_Lang3, $SEO_Keywords_Lang3, $Slug_Lang3, $SEO_Title_Lang4, $SEO_Description_Lang4, $SEO_Keywords_Lang4, $Slug_Lang4, $SEO_Title_Lang5, $SEO_Description_Lang5, $SEO_Keywords_Lang5, $Slug_Lang5, $Status, $GalleryID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if($_SESSION['License']['MaxPages'] <= $Connection->NumRows('web.post', 'ID', "")){
            $Result['status'] = false;
            $Result['msg'] = 'ظرفیت ثبت مطلب در لایسنس شما تکمیل شده است.';
            $Result['error'] = 'MaxPages: ' . $_SESSION['License']['MaxPages'];
            $Result['key'] = '';

            return $Result;
        }

        if(isset($Thumb["error"]) and $Thumb["error"] != 4){              //Upload File if is set
            $ThumbUploadResult = $General->FileUpload($Thumb,true,'',array('jpg','jpeg','gif','png'));

            if($ThumbUploadResult['status']){
                $Thumb = $ThumbUploadResult['key'];
            }
            else{
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] = $ThumbUploadResult['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;
            }
        }

        if($Slug == ''){                //Define slug
            if($SEO_Title != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Title);
            }
            $Slug = str_replace(' ', '-',$TempSlug);
            $FinalSlug = '';

            $i = 1;
            while($FinalSlug == ''){

                if ($Connection->NumRows('web.post', 'ID', "`Slug` = '$Slug'") > 0) {
                    $Slug .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug = $Slug;
                }

            }
        }

        if($Slug_Lang2 == ''){                //Define slug
            if($SEO_Title_Lang2 != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title_Lang2);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Title_Lang2);
            }
            $Slug_Lang2 = str_replace(' ', '-',$TempSlug);
            $FinalSlug_Lang2 = '';

            $i = 1;
            while($FinalSlug_Lang2 == ''){

                if ($Connection->NumRows('web.post', 'ID', "`Slug_Lang2` = '$Slug_Lang2'") > 0) {
                    $Slug_Lang2 .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug_Lang2 = $Slug_Lang2;
                }

            }
        }

        if($Slug_Lang3 == ''){                //Define slug
            if($SEO_Title_Lang3 != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title_Lang3);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Title_Lang3);
            }
            $Slug_Lang3 = str_replace(' ', '-',$TempSlug);
            $FinalSlug_Lang3 = '';

            $i = 1;
            while($FinalSlug_Lang3 == ''){

                if ($Connection->NumRows('web.post', 'ID', "`Slug_Lang3` = '$Slug_Lang3'") > 0) {
                    $Slug_Lang3 .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug_Lang3 = $Slug_Lang3;
                }

            }
        }

        if($Slug_Lang4 == ''){                //Define slug
            if($SEO_Title_Lang4 != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title_Lang4);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Title_Lang4);
            }
            $Slug_Lang4 = str_replace(' ', '-',$TempSlug);
            $FinalSlug_Lang4 = '';

            $i = 1;
            while($FinalSlug_Lang4 == ''){

                if ($Connection->NumRows('web.post', 'ID', "`Slug_Lang4` = '$Slug_Lang4'") > 0) {
                    $Slug_Lang4 .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug_Lang4 = $Slug_Lang4;
                }

            }
        }

        if($Slug_Lang5 == ''){                //Define slug
            if($SEO_Title_Lang5 != ''){
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $SEO_Title_Lang5);
            }
            else{
                $TempSlug = str_replace(array('/', '\\', '\'', '^', '%', '&','@', '#', '~', '?', '>', '<', ',', '|', '=', '_', '+', '!', '-', '«', '»', ':'), '', $Title_Lang5);
            }
            $Slug_Lang5 = str_replace(' ', '-',$TempSlug);
            $FinalSlug_Lang5 = '';

            $i = 1;
            while($FinalSlug_Lang5 == ''){

                if ($Connection->NumRows('web.post', 'ID', "`Slug_Lang5` = '$Slug_Lang5'") > 0) {
                    $Slug_Lang5 .= '-' . $i;
                    $i++;
                }
                else{
                    $FinalSlug_Lang5 = $Slug_Lang5;
                }

            }
        }

        if($FormID == ''){
            $FormID = 'NULL';
        }
        if($FormID_Lang2 == ''){
            $FormID_Lang2 = 'NULL';
        }
        if($FormID_Lang3 == ''){
            $FormID_Lang3 = 'NULL';
        }
        if($FormID_Lang4 == ''){
            $FormID_Lang4 = 'NULL';
        }
        if($FormID_Lang5 == ''){
            $FormID_Lang5 = 'NULL';
        }
        if($GalleryID == ''){
            $GalleryID = 'NULL';
        }

        $CT = time();
        $QUERY = $Connection->Insert('web.post', array(), array(array('NULL', $Type, $Title, $Context, $Content, $FormID, $Title_Lang2, $Context_Lang2, $Content_Lang2, $FormID_Lang2, $Title_Lang3, $Context_Lang3, $Content_Lang3, $FormID_Lang3, $Title_Lang4, $Context_Lang4, $Content_Lang4, $FormID_Lang4, $Title_Lang5, $Context_Lang5, $Content_Lang5, $FormID_Lang5, $CategoryID, $Thumb, '0', $CT, $SEO_Title, $SEO_Description, $SEO_Keywords, $FinalSlug, $SEO_Title_Lang2, $SEO_Description_Lang2, $SEO_Keywords_Lang2, $FinalSlug_Lang2, $SEO_Title_Lang3, $SEO_Description_Lang3, $SEO_Keywords_Lang3, $FinalSlug_Lang3, $SEO_Title_Lang4, $SEO_Description_Lang4, $SEO_Keywords_Lang4, $FinalSlug_Lang4, $SEO_Title_Lang5, $SEO_Description_Lang5, $SEO_Keywords_Lang5, $FinalSlug_Lang5, $Status, $GalleryID)));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function EditPost($Connection, $ID, $Title, $Context, $Content, $FormID, $Title_Lang2, $Context_Lang2, $Content_Lang2, $FormID_Lang2, $Title_Lang3, $Context_Lang3, $Content_Lang3, $FormID_Lang3, $Title_Lang4, $Context_Lang4, $Content_Lang4, $FormID_Lang4, $Title_Lang5, $Context_Lang5, $Content_Lang5, $FormID_Lang5, $CategoryID, $Thumb, $SEO_Title, $SEO_Description, $SEO_Keywords, $SEO_Title_Lang2, $SEO_Description_Lang2, $SEO_Keywords_Lang2, $SEO_Title_Lang3, $SEO_Description_Lang3, $SEO_Keywords_Lang3, $SEO_Title_Lang4, $SEO_Description_Lang4, $SEO_Keywords_Lang4, $SEO_Title_Lang5, $SEO_Description_Lang5, $SEO_Keywords_Lang5, $Status, $GalleryID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if(isset($Thumb["error"]) and $Thumb["error"] != 4){              //Upload File if is set
            $ThumbUploadResult = $General->FileUpload($Thumb,true,'',array('jpg','jpeg','gif','png'));

            if($ThumbUploadResult['status']){
                $Thumb = $ThumbUploadResult['key'];
            }
            else{
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] = $ThumbUploadResult['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;
            }
        }

        if($FormID == ''){
            $FormID = 'NULL';
        }
        if($FormID_Lang2 == ''){
            $FormID_Lang2 = 'NULL';
        }
        if($FormID_Lang3 == ''){
            $FormID_Lang3 = 'NULL';
        }
        if($FormID_Lang4 == ''){
            $FormID_Lang4 = 'NULL';
        }
        if($FormID_Lang5 == ''){
            $FormID_Lang5 = 'NULL';
        }
        if($GalleryID == ''){
            $GalleryID = 'NULL';
        }

        $QUERY = $Connection->Update('web.post', array('Title' => $Title, 'Context' => $Context, 'Content' => $Content, 'FormID' => $FormID, 'Title_Lang2' => $Title_Lang2, 'Context_Lang2' => $Context_Lang2, 'Content_Lang2' => $Content_Lang2, 'FormID_Lang2' => $FormID_Lang2, 'Title_Lang3' => $Title_Lang3, 'Context_Lang3' => $Context_Lang3, 'Content_Lang3' => $Content_Lang3, 'FormID_Lang3' => $FormID_Lang3, 'Title_Lang4' => $Title_Lang4, 'Context_Lang4' => $Context_Lang4, 'Content_Lang4' => $Content_Lang4, 'FormID_Lang4' => $FormID_Lang4, 'Title_Lang5' => $Title_Lang5, 'Context_Lang5' => $Context_Lang5, 'Content_Lang5' => $Content_Lang5, 'FormID_Lang5' => $FormID_Lang5, 'CategoryID' => $CategoryID, 'Thumb' => $Thumb, 'SEO_Title' => $SEO_Title, 'SEO_Description' => $SEO_Description, 'SEO_Keywords' => $SEO_Keywords, 'SEO_Title_Lang2' => $SEO_Title_Lang2, 'SEO_Description_Lang2' => $SEO_Description_Lang2, 'SEO_Keywords_Lang2' => $SEO_Keywords_Lang2, 'SEO_Title_Lang3' => $SEO_Title_Lang3, 'SEO_Description_Lang3' => $SEO_Description_Lang3, 'SEO_Keywords_Lang3' => $SEO_Keywords_Lang3, 'SEO_Title_Lang4' => $SEO_Title_Lang4, 'SEO_Description_Lang4' => $SEO_Description_Lang4, 'SEO_Keywords_Lang4' => $SEO_Keywords_Lang4, 'SEO_Title_Lang5' => $SEO_Title_Lang5, 'SEO_Description_Lang5' => $SEO_Description_Lang5, 'SEO_Keywords_Lang5' => $SEO_Keywords_Lang5, 'Status' => $Status, 'GalleryID' => $GalleryID), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeletePost($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.post', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectPost($Connection, $ID, $Type, $Slug, $CategoryID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT, $Slug_Lang2 = '', $Slug_Lang3 = '', $Slug_Lang4 = '', $Slug_Lang5 = '')
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        $Settings = $General->GetSettings($Connection);

        $License = $General->CheckAndGetLicense($Connection);

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Type != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Type`='$Type')";
        }
        if ($Slug != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug`='$Slug')";
        }
        if ($Slug_Lang2 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug_Lang2`='$Slug_Lang2')";
        }
        if ($Slug_Lang3 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug_Lang3`='$Slug_Lang3')";
        }
        if ($Slug_Lang4 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug_Lang4`='$Slug_Lang4')";
        }
        if ($Slug_Lang5 != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Slug_Lang5`='$Slug_Lang5')";
        }
        if ($CategoryID != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`CategoryID`='$CategoryID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.post', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {
            $CategoryInfo = $this->SelectPostCategory($Connection,$row['CategoryID'],'','','','','','1');
            if($row['FormID'] != ''){
                $FormInfo = $this->SelectForm($Connection,$row['FormID'],'','','','1');
            }
            if($row['FormID_Lang2'] != ''){
                $FormInfo_Lang2 = $this->SelectForm($Connection,$row['FormID_Lang2'],'','','','1');
            }
            if($row['FormID_Lang3'] != ''){
                $FormInfo_Lang3 = $this->SelectForm($Connection,$row['FormID_Lang3'],'','','','1');
            }
            if($row['FormID_Lang4'] != ''){
                $FormInfo_Lang4 = $this->SelectForm($Connection,$row['FormID_Lang4'],'','','','1');
            }
            if($row['FormID_Lang5'] != ''){
                $FormInfo_Lang5 = $this->SelectForm($Connection,$row['FormID_Lang5'],'','','','1');
            }

            if($row['Type'] == '1'){
                $Type = 'نوشته';
            }
            elseif($row['Type'] == '2'){
                $Type = 'برگه';
            }

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['TypeFlag'] = $row['Type'];
            $Result[$i]['Type'] = $Type;
            $Result[$i]['Title'] = $row['Title'];
            $Result[$i]['Context'] = $row['Context'];
            $Result[$i]['Content'] = $row['Content'];
            $Result[$i]['CategoryID'] = $row['CategoryID'];
            $Result[$i]['Category'] = $CategoryInfo['1']['Name'];
            $Result[$i]['Thumb'] = $row['Thumb'];
            $Result[$i]['Views'] = $row['Views'];
            $Result[$i]['CT'] = date('Y m d H:i', $row['CT']);
            $Result[$i]['CTJalali'] = jdate('Y/m/d H:i', $row['CT'], '', 'Asia/Tehran', 'en');
            $Result[$i]['CTString'] = $row['CT'];
            if($row['SEO_Title'] != '') {
                $Result[$i]['SEO_Title'] = $row['SEO_Title'];
            }
            else{
                $Result[$i]['SEO_Title'] = $row['Title'];
            }
            if($row['SEO_Description'] != '') {
                $Result[$i]['SEO_Description'] = $row['SEO_Description'];
            }
            else{
                $Result[$i]['SEO_Description'] = $Settings['bas_SiteTitle'];
            }
            $Result[$i]['SEO_Keywords'] = $row['SEO_Keywords'];
            $Result[$i]['Slug'] = $row['Slug'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            if($License['Lang2'] == '1'){
                $Result[$i]['Title_Lang2'] = $row['Title_Lang2'];
                $Result[$i]['Context_Lang2'] = $row['Context_Lang2'];
                $Result[$i]['Content_Lang2'] = $row['Content_Lang2'];

                if($row['SEO_Title_Lang2'] != '') {
                    $Result[$i]['SEO_Title_Lang2'] = $row['SEO_Title_Lang2'];
                }
                else{
                    $Result[$i]['SEO_Title_Lang2'] = $row['Title_Lang2'];
                }
                if($row['SEO_Description_Lang2'] != '') {
                    $Result[$i]['SEO_Description_Lang2'] = $row['SEO_Description_Lang2'];
                }
                else{
                    $Result[$i]['SEO_Description_Lang2'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['SEO_Keywords_Lang2'] = $row['SEO_Keywords_Lang2'];
                $Result[$i]['Slug_Lang2'] = $row['Slug_Lang2'];

            }
            if($License['Lang3'] == '1'){
                $Result[$i]['Title_Lang3'] = $row['Title_Lang3'];
                $Result[$i]['Context_Lang3'] = $row['Context_Lang3'];
                $Result[$i]['Content_Lang3'] = $row['Content_Lang3'];

                if($row['SEO_Title_Lang3'] != '') {
                    $Result[$i]['SEO_Title_Lang3'] = $row['SEO_Title_Lang3'];
                }
                else{
                    $Result[$i]['SEO_Title_Lang3'] = $row['Title_Lang3'];
                }
                if($row['SEO_Description_Lang3'] != '') {
                    $Result[$i]['SEO_Description_Lang3'] = $row['SEO_Description_Lang3'];
                }
                else{
                    $Result[$i]['SEO_Description_Lang3'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['SEO_Keywords_Lang3'] = $row['SEO_Keywords_Lang3'];
                $Result[$i]['Slug_Lang3'] = $row['Slug_Lang3'];

            }
            if($License['Lang4'] == '1'){
                $Result[$i]['Title_Lang4'] = $row['Title_Lang4'];
                $Result[$i]['Context_Lang4'] = $row['Context_Lang4'];
                $Result[$i]['Content_Lang4'] = $row['Content_Lang4'];

                if($row['SEO_Title_Lang4'] != '') {
                    $Result[$i]['SEO_Title_Lang4'] = $row['SEO_Title_Lang4'];
                }
                else{
                    $Result[$i]['SEO_Title_Lang4'] = $row['Title_Lang4'];
                }
                if($row['SEO_Description_Lang4'] != '') {
                    $Result[$i]['SEO_Description_Lang4'] = $row['SEO_Description_Lang4'];
                }
                else{
                    $Result[$i]['SEO_Description_Lang4'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['SEO_Keywords_Lang4'] = $row['SEO_Keywords_Lang4'];
                $Result[$i]['Slug_Lang4'] = $row['Slug_Lang4'];

            }
            if($License['Lang5'] == '1'){
                $Result[$i]['Title_Lang5'] = $row['Title_Lang5'];
                $Result[$i]['Context_Lang5'] = $row['Context_Lang5'];
                $Result[$i]['Content_Lang5'] = $row['Content_Lang5'];

                if($row['SEO_Title_Lang5'] != '') {
                    $Result[$i]['SEO_Title_Lang5'] = $row['SEO_Title_Lang5'];
                }
                else{
                    $Result[$i]['SEO_Title_Lang5'] = $row['Title_Lang5'];
                }
                if($row['SEO_Description_Lang5'] != '') {
                    $Result[$i]['SEO_Description_Lang5'] = $row['SEO_Description_Lang5'];
                }
                else{
                    $Result[$i]['SEO_Description_Lang5'] = $Settings['bas_SiteTitle'];
                }
                $Result[$i]['SEO_Keywords_Lang5'] = $row['SEO_Keywords_Lang5'];
                $Result[$i]['Slug_Lang5'] = $row['Slug_Lang5'];

            }


            ######### Form #########
            /*
             * Fields: JsonArray
             * FieldTypes: button, file, header, hidden, radio-group, select, text, textarea
             * Type: submit, reset, file, h1, h2, h3, h4, h5, h6, text, password, email, color
             */
            if(isset($FormInfo) AND count($FormInfo) > 0){
                $Result[$i]['Form']['ID'] = $FormInfo['1']['ID'];
                $Result[$i]['Form']['Name'] = $FormInfo['1']['Name'];
                $Result[$i]['Form']['enctype'] = $FormInfo['1']['enctype'];

                for($x = 1, $xMax = count($FormInfo['1']['Fields']); $x <= $xMax; $x++){
                    $Result[$i]['Form']['Fields'][$x]['FieldName'] = $FormInfo['1']['Fields'][$x]['FieldName'];
                    $Result[$i]['Form']['Fields'][$x]['FieldType'] = $FormInfo['1']['Fields'][$x]['FieldType'];
                    $Result[$i]['Form']['Fields'][$x]['Label'] = $FormInfo['1']['Fields'][$x]['Label'];
                    $Result[$i]['Form']['Fields'][$x]['Placeholder'] = $FormInfo['1']['Fields'][$x]['Placeholder'];
                    $Result[$i]['Form']['Fields'][$x]['Description'] = $FormInfo['1']['Fields'][$x]['Description'];
                    $Result[$i]['Form']['Fields'][$x]['RequiredFlag'] = $FormInfo['1']['Fields'][$x]['RequiredFlag'];
                    $Result[$i]['Form']['Fields'][$x]['DefaultValue'] = $FormInfo['1']['Fields'][$x]['DefaultValue'];
                    $Result[$i]['Form']['Fields'][$x]['Class'] = $FormInfo['1']['Fields'][$x]['Class'];
                    $Result[$i]['Form']['Fields'][$x]['Type'] = $FormInfo['1']['Fields'][$x]['Type'];

                    if(isset($FormInfo['1']['Fields'][$x]['Options'])){
                        for($z = 1, $zMax = count($FormInfo['1']['Fields'][$x]['Options']); $z <= $zMax; $z++){
                            $Result[$i]['Form']['Fields'][$x]['Options'][$z]['Label'] = $FormInfo['1']['Fields'][$x]['Options'][$z]['Label'];
                            $Result[$i]['Form']['Fields'][$x]['Options'][$z]['Value'] = $FormInfo['1']['Fields'][$x]['Options'][$z]['Value'];
                        }
                    }

                }
            }

            if($License['Lang2'] == '1' AND isset($FormInfo_Lang2) AND count($FormInfo_Lang2) > 0){
                $Result[$i]['Form_Lang2']['ID'] = $FormInfo_Lang2['1']['ID'];
                $Result[$i]['Form_Lang2']['Name'] = $FormInfo_Lang2['1']['Name'];
                $Result[$i]['Form_Lang2']['enctype'] = $FormInfo_Lang2['1']['enctype'];

                for($x = 1, $xMax = count($FormInfo_Lang2['1']['Fields']); $x <= $xMax; $x++){
                    $Result[$i]['Form_Lang2']['Fields'][$x]['FieldName'] = $FormInfo_Lang2['1']['Fields'][$x]['FieldName'];
                    $Result[$i]['Form_Lang2']['Fields'][$x]['FieldType'] = $FormInfo_Lang2['1']['Fields'][$x]['FieldType'];
                    $Result[$i]['Form_Lang2']['Fields'][$x]['Label'] = $FormInfo_Lang2['1']['Fields'][$x]['Label'];
                    $Result[$i]['Form_Lang2']['Fields'][$x]['Placeholder'] = $FormInfo_Lang2['1']['Fields'][$x]['Placeholder'];
                    $Result[$i]['Form_Lang2']['Fields'][$x]['Description'] = $FormInfo_Lang2['1']['Fields'][$x]['Description'];
                    $Result[$i]['Form_Lang2']['Fields'][$x]['RequiredFlag'] = $FormInfo_Lang2['1']['Fields'][$x]['RequiredFlag'];
                    $Result[$i]['Form_Lang2']['Fields'][$x]['DefaultValue'] = $FormInfo_Lang2['1']['Fields'][$x]['DefaultValue'];
                    $Result[$i]['Form_Lang2']['Fields'][$x]['Class'] = $FormInfo_Lang2['1']['Fields'][$x]['Class'];
                    $Result[$i]['Form_Lang2']['Fields'][$x]['Type'] = $FormInfo_Lang2['1']['Fields'][$x]['Type'];

                    if(isset($FormInfo_Lang2['1']['Fields'][$x]['Options'])){
                        for($z = 1, $zMax = count($FormInfo_Lang2['1']['Fields'][$x]['Options']); $z <= $zMax; $z++){
                            $Result[$i]['Form_Lang2']['Fields'][$x]['Options'][$z]['Label'] = $FormInfo_Lang2['1']['Fields'][$x]['Options'][$z]['Label'];
                            $Result[$i]['Form_Lang2']['Fields'][$x]['Options'][$z]['Value'] = $FormInfo_Lang2['1']['Fields'][$x]['Options'][$z]['Value'];
                        }
                    }

                }
            }

            if($License['Lang3'] == '1' AND isset($FormInfo_Lang3) AND count($FormInfo_Lang3) > 0){
                $Result[$i]['Form_Lang3']['ID'] = $FormInfo_Lang3['1']['ID'];
                $Result[$i]['Form_Lang3']['Name'] = $FormInfo_Lang3['1']['Name'];
                $Result[$i]['Form_Lang3']['enctype'] = $FormInfo_Lang3['1']['enctype'];

                for($x = 1, $xMax = count($FormInfo_Lang3['1']['Fields']); $x <= $xMax; $x++){
                    $Result[$i]['Form_Lang3']['Fields'][$x]['FieldName'] = $FormInfo_Lang3['1']['Fields'][$x]['FieldName'];
                    $Result[$i]['Form_Lang3']['Fields'][$x]['FieldType'] = $FormInfo_Lang3['1']['Fields'][$x]['FieldType'];
                    $Result[$i]['Form_Lang3']['Fields'][$x]['Label'] = $FormInfo_Lang3['1']['Fields'][$x]['Label'];
                    $Result[$i]['Form_Lang3']['Fields'][$x]['Placeholder'] = $FormInfo_Lang3['1']['Fields'][$x]['Placeholder'];
                    $Result[$i]['Form_Lang3']['Fields'][$x]['Description'] = $FormInfo_Lang3['1']['Fields'][$x]['Description'];
                    $Result[$i]['Form_Lang3']['Fields'][$x]['RequiredFlag'] = $FormInfo_Lang3['1']['Fields'][$x]['RequiredFlag'];
                    $Result[$i]['Form_Lang3']['Fields'][$x]['DefaultValue'] = $FormInfo_Lang3['1']['Fields'][$x]['DefaultValue'];
                    $Result[$i]['Form_Lang3']['Fields'][$x]['Class'] = $FormInfo_Lang3['1']['Fields'][$x]['Class'];
                    $Result[$i]['Form_Lang3']['Fields'][$x]['Type'] = $FormInfo_Lang3['1']['Fields'][$x]['Type'];

                    if(isset($FormInfo_Lang3['1']['Fields'][$x]['Options'])){
                        for($z = 1, $zMax = count($FormInfo_Lang3['1']['Fields'][$x]['Options']); $z <= $zMax; $z++){
                            $Result[$i]['Form_Lang3']['Fields'][$x]['Options'][$z]['Label'] = $FormInfo_Lang3['1']['Fields'][$x]['Options'][$z]['Label'];
                            $Result[$i]['Form_Lang3']['Fields'][$x]['Options'][$z]['Value'] = $FormInfo_Lang3['1']['Fields'][$x]['Options'][$z]['Value'];
                        }
                    }

                }
            }

            if($License['Lang4'] == '1' AND isset($FormInfo_Lang4) AND count($FormInfo_Lang4) > 0){
                $Result[$i]['Form_Lang4']['ID'] = $FormInfo_Lang4['1']['ID'];
                $Result[$i]['Form_Lang4']['Name'] = $FormInfo_Lang4['1']['Name'];
                $Result[$i]['Form_Lang4']['enctype'] = $FormInfo_Lang4['1']['enctype'];

                for($x = 1, $xMax = count($FormInfo_Lang4['1']['Fields']); $x <= $xMax; $x++){
                    $Result[$i]['Form_Lang4']['Fields'][$x]['FieldName'] = $FormInfo_Lang4['1']['Fields'][$x]['FieldName'];
                    $Result[$i]['Form_Lang4']['Fields'][$x]['FieldType'] = $FormInfo_Lang4['1']['Fields'][$x]['FieldType'];
                    $Result[$i]['Form_Lang4']['Fields'][$x]['Label'] = $FormInfo_Lang4['1']['Fields'][$x]['Label'];
                    $Result[$i]['Form_Lang4']['Fields'][$x]['Placeholder'] = $FormInfo_Lang4['1']['Fields'][$x]['Placeholder'];
                    $Result[$i]['Form_Lang4']['Fields'][$x]['Description'] = $FormInfo_Lang4['1']['Fields'][$x]['Description'];
                    $Result[$i]['Form_Lang4']['Fields'][$x]['RequiredFlag'] = $FormInfo_Lang4['1']['Fields'][$x]['RequiredFlag'];
                    $Result[$i]['Form_Lang4']['Fields'][$x]['DefaultValue'] = $FormInfo_Lang4['1']['Fields'][$x]['DefaultValue'];
                    $Result[$i]['Form_Lang4']['Fields'][$x]['Class'] = $FormInfo_Lang4['1']['Fields'][$x]['Class'];
                    $Result[$i]['Form_Lang4']['Fields'][$x]['Type'] = $FormInfo_Lang4['1']['Fields'][$x]['Type'];

                    if(isset($FormInfo_Lang4['1']['Fields'][$x]['Options'])){
                        for($z = 1, $zMax = count($FormInfo_Lang4['1']['Fields'][$x]['Options']); $z <= $zMax; $z++){
                            $Result[$i]['Form_Lang4']['Fields'][$x]['Options'][$z]['Label'] = $FormInfo_Lang4['1']['Fields'][$x]['Options'][$z]['Label'];
                            $Result[$i]['Form_Lang4']['Fields'][$x]['Options'][$z]['Value'] = $FormInfo_Lang4['1']['Fields'][$x]['Options'][$z]['Value'];
                        }
                    }

                }
            }

            if($License['Lang5'] == '1' AND isset($FormInfo_Lang5) AND count($FormInfo_Lang5) > 0){
                $Result[$i]['Form_Lang5']['ID'] = $FormInfo_Lang5['1']['ID'];
                $Result[$i]['Form_Lang5']['Name'] = $FormInfo_Lang5['1']['Name'];
                $Result[$i]['Form_Lang5']['enctype'] = $FormInfo_Lang5['1']['enctype'];

                for($x = 1, $xMax = count($FormInfo_Lang5['1']['Fields']); $x <= $xMax; $x++){
                    $Result[$i]['Form_Lang5']['Fields'][$x]['FieldName'] = $FormInfo_Lang5['1']['Fields'][$x]['FieldName'];
                    $Result[$i]['Form_Lang5']['Fields'][$x]['FieldType'] = $FormInfo_Lang5['1']['Fields'][$x]['FieldType'];
                    $Result[$i]['Form_Lang5']['Fields'][$x]['Label'] = $FormInfo_Lang5['1']['Fields'][$x]['Label'];
                    $Result[$i]['Form_Lang5']['Fields'][$x]['Placeholder'] = $FormInfo_Lang5['1']['Fields'][$x]['Placeholder'];
                    $Result[$i]['Form_Lang5']['Fields'][$x]['Description'] = $FormInfo_Lang5['1']['Fields'][$x]['Description'];
                    $Result[$i]['Form_Lang5']['Fields'][$x]['RequiredFlag'] = $FormInfo_Lang5['1']['Fields'][$x]['RequiredFlag'];
                    $Result[$i]['Form_Lang5']['Fields'][$x]['DefaultValue'] = $FormInfo_Lang5['1']['Fields'][$x]['DefaultValue'];
                    $Result[$i]['Form_Lang5']['Fields'][$x]['Class'] = $FormInfo_Lang5['1']['Fields'][$x]['Class'];
                    $Result[$i]['Form_Lang5']['Fields'][$x]['Type'] = $FormInfo_Lang5['1']['Fields'][$x]['Type'];

                    if(isset($FormInfo_Lang5['1']['Fields'][$x]['Options'])){
                        for($z = 1, $zMax = count($FormInfo_Lang5['1']['Fields'][$x]['Options']); $z <= $zMax; $z++){
                            $Result[$i]['Form_Lang5']['Fields'][$x]['Options'][$z]['Label'] = $FormInfo_Lang5['1']['Fields'][$x]['Options'][$z]['Label'];
                            $Result[$i]['Form_Lang5']['Fields'][$x]['Options'][$z]['Value'] = $FormInfo_Lang5['1']['Fields'][$x]['Options'][$z]['Value'];
                        }
                    }

                }
            }
            ######### Form #########

            ######### Gallery #########
            if($row['GalleryID'] != ''){
                $GalleryInfo = $this->SelectGallery($Connection,$row['GalleryID'],'','','','1');
            }

           if(isset($GalleryInfo)){
                $Result[$i]['Gallery']['ID'] = $GalleryInfo['1']['ID'];
                $Result[$i]['Gallery']['Name'] = $GalleryInfo['1']['Name'];

                $GalleryImages = $this->SelectGalleryImage($Connection,'',$GalleryInfo['1']['ID'],'','','','');
                for($x = 1, $xMax = count($GalleryImages); $x <=  $xMax; $x++ ){
                    $Result[$i]['Gallery']['Image'][$x]['ID'] = $GalleryImages[$x]['ID'];
                    $Result[$i]['Gallery']['Image'][$x]['Title'] = $GalleryImages[$x]['Title'];
                    $Result[$i]['Gallery']['Image'][$x]['File'] = $GalleryImages[$x]['File'];
                }
            }

            
            
            ######### Gallery #########

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function InsertVisitorActivity($Connection, $IP, $URL){
        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Time = time();
        $Date = strtotime('today midnight');

        $QUERY = $Connection->Insert('web.visitors_activity',array(),array(array('NULL',$IP,$URL,$Time,$Date)));

    }

    public function VisitorsActivityStatistics($Connection, $LIMIT){
        if (empty($Connection)) {
            $Connection = new Database;
        }

        $i = 1;
        $QUERY = $Connection->CustomSelectQuery("SELECT `Date`, COUNT(DISTINCT `IP`) AS `UniqueIP`, COUNT(DISTINCT `ID`) AS `Views` FROM `web.visitors_activity` GROUP BY `Date` ORDER BY `Date` Desc LIMIT $LIMIT");
        while($row = mysqli_fetch_assoc($QUERY)){
            $Result[$i]['MilliDateSTR'] =  $row['Date'] * 1000;
            $Result[$i]['DateSTR'] =  $row['Date'];
            $Result[$i]['Date'] =  date('F d',$row['Date']);
            $Result[$i]['JalaliDate'] = jdate('Y/m/d',$row['Date'],'','','en');
            $Result[$i]['UniqueIP'] =  $row['UniqueIP'];
            $Result[$i]['Views'] =  $row['Views'];
            $LastDate = $row['Date'];

            $i++;
        }

        if(!isset($LastDate)){
            $LastDate = strtotime('today midnight') + 86400;
        }

        while($i <= $LIMIT){
            $LastDate -= 86400;

            $Result[$i]['MilliDateSTR'] =  $LastDate * 1000;
            $Result[$i]['DateSTR'] =  $LastDate;
            $Result[$i]['Date'] =  date('F d',$LastDate);
            $Result[$i]['JalaliDate'] = jdate('Y/m/d',$LastDate,'','','en');
            $Result[$i]['UniqueIP'] =  '0';
            $Result[$i]['Views'] =  '0';

            $i++;
        }

        return $Result;

    }

    public function AddGallery($Connection, $Name)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        if($_SESSION['License']['MaxGallery'] <= $Connection->NumRows('web.gallery', 'ID', "")){
            $Result['status'] = false;
            $Result['msg'] = 'ظرفیت تعریف گالری در لایسنس شما تکمیل شده است.';
            $Result['error'] = 'MaxGallery: ' . $_SESSION['License']['MaxGallery'];
            $Result['key'] = '';

            return $Result;
        }

        $QUERY = $Connection->Insert('web.gallery', array(), array(array('NULL', $Name, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function EditGallery($Connection, $ID, $Name, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Update('web.gallery', array('Name' => $Name, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeleteGallery($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.gallery', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectGallery($Connection, $ID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.gallery', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

       // return array();

    }

    public function AddGalleryImage($Connection, $GalleryID, $Title, $File)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        $FileUploadResult = $General->FileUpload($File,true,'',array('jpg','jpeg','gif','png','svg'));
        if($FileUploadResult['status']){
            $File = $FileUploadResult['key'];
        }
        else{
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
            $Result['error'] = $FileUploadResult['error'];
            $Result['key'] = '';

            return $Result;
        }

        $QUERY = $Connection->Insert('web.gallery_image', array(), array(array('NULL', $GalleryID, $Title, $File, '1')));
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;
    }

    public function EditGalleryImage($Connection, $ID, $GalleryID, $Title, $File, $Status)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        if(isset($File["error"]) and $File["error"] != 4){              //Upload File if is set
            $FileUploadResult = $General->FileUpload($File,true,'',array('jpg','jpeg','gif','png','svg'));
            if($FileUploadResult['status']){
                $File = $FileUploadResult['key'];
            }
            else{
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] = $FileUploadResult['error'];
                $Result['key'] = '';

                return $Result;
            }
        }

        $QUERY = $Connection->Update('web.gallery_image', array('GalleryID' => $GalleryID, 'Title' => $Title, 'File' => $File, 'Status' => $Status), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $ID;
            $Result['error'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = $ID;
        }

        return $Result;
    }

    public function DeleteGalleryImage($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.gallery_image', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function SelectGalleryImage($Connection, $ID, $GalleryID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($GalleryID != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`GalleryID`='$GalleryID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.gallery_image', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {
            $GalleryInfo = $this->SelectGallery($Connection,$row['GalleryID'],'','','','1');

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['GalleryID'] = $row['GalleryID'];
            $Result[$i]['GalleryName'] = $GalleryInfo['1']['Name'];
            $Result[$i]['Title'] = $row['Title'];
            $Result[$i]['File'] = $row['File'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    /*
     * Fields: JsonArray
     * FieldTypes: button, file, header, hidden, radio-group, select, text, textarea
     * Type: submit, reset, file, h1, h2, h3, h4, h5, h6, text, password, email, color
     */
    public function AddForm($Connection, $Name, $Fields)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Connection->StartTransaction();

        $QUERY = $Connection->Insert('web.form_hdr', array(), array(array('NULL', $Name, '1', '0', $Fields)));
        if ($QUERY['status']) {
            $HdrID = $QUERY['key'];

            $Fields = json_decode($Fields,true);
            for($i = 0, $iMax = count($Fields); $i < $iMax; $i++){

                $FieldName = isset($Fields[$i]['name']) ? $Fields[$i]['name'] : '';
                $FieldType = isset($Fields[$i]['type']) ? $Fields[$i]['type'] : '';
                $Label = isset($Fields[$i]['label']) ? $Fields[$i]['label'] : '';
                $Placeholder = isset($Fields[$i]['placeholder']) ? $Fields[$i]['placeholder'] : '';
                $Description = isset($Fields[$i]['description']) ? $Fields[$i]['description'] : '';
                $Required = isset($Fields[$i]['required']) ? $Fields[$i]['required'] : '';
                $DefaultValue = isset($Fields[$i]['value']) ? $Fields[$i]['value'] : '';
                $Class = isset($Fields[$i]['className']) ? $Fields[$i]['className'] : '';
                $Type = isset($Fields[$i]['subtype']) ? $Fields[$i]['subtype'] : 'NULL';
                $Options = isset($Fields[$i]['values']) ? json_encode($Fields[$i]['values']) : '';
                $Rows = isset($Fields[$i]['rows']) ? $Fields[$i]['rows'] : '0';

                if($FieldType == 'header'){
                    $FieldName = 'Header' . mt_rand();
                }

                if($FieldName == ''){
                    $Result['status'] = false;
                    $Result['msg'] = 'نام یکتا فیلد شماره ' . ($i + 1) . ' وارد نشده است.';
                    $Result['error'] = '';
                    $Result['key'] = '';

                    $Connection->Rollback();

                    return $Result;
                }
                if($FieldType == ''){
                    $Result['status'] = false;
                    $Result['msg'] = 'نوع فیلد شماره ' . ($i + 1) . ' انتخاب نشده است.';
                    $Result['error'] = '';
                    $Result['key'] = '';

                    $Connection->Rollback();

                    return $Result;
                }
                if(($FieldType == 'radio-group' || $FieldType == 'select') AND $Options = ''){
                    $Result['status'] = false;
                    $Result['msg'] = 'در فیلد شماره ' . ($i + 1) . ' گزینه ها تعریف نشده اند.';
                    $Result['error'] = '';
                    $Result['key'] = '';

                    $Connection->Rollback();

                    return $Result;
                }
                if($Required == ''){
                    $Required = '0';
                }

                $QUERY = $Connection->Insert('web.form_dtl', array(), array(array('NULL',$HdrID, $FieldName, $FieldType, $Label, $Placeholder, $Description, $Required, $DefaultValue, $Class, $Type, $Options, $Rows)));
                if(!$QUERY['status']){
                    $Result['status'] = false;
                    $Result['msg'] = 'خطا در ثبت ردیف ' . ($i + 1);
                    $Result['error'] = $QUERY['error'];
                    $Result['key'] = '';

                    $Connection->Rollback();

                    return $Result;
                }

            }

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

            $Connection->Commit();

            return $Result;

        }

        $Result['status'] = false;
        $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
        $Result['error'] = $QUERY['error'];
        $Result['key'] = '';

        $Connection->Rollback();

        return $Result;

    }

    public function SelectForm($Connection, $ID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.form_hdr', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            $FormID = $row['ID'];

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            if($row['Used'] == '1'){
                $Used = 'استفاده شده';
            }
            elseif($row['Used'] == '0'){
                $Used = 'استفاده نشده';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];
            $Result[$i]['Used'] = $Used;
            $Result[$i]['UsedFlag'] = $row['Used'];
            $Result[$i]['JsonFormData'] = $row['JsonFormData'];
            $Result[$i]['enctype'] = '';

            $Dtl = $Connection->Select('web.form_dtl',array('*'),"`HdrID` = '$FormID'",'ID','ASC','');
            $x = 1;
            while ($row_Dtl = mysqli_fetch_assoc($Dtl)) {

                $Result[$i]['Fields'][$x]['FieldName'] = $row_Dtl['FieldName'];
                $Result[$i]['Fields'][$x]['FieldType'] = $row_Dtl['FieldType'];
                $Result[$i]['Fields'][$x]['Label'] = $row_Dtl['Label'];
                $Result[$i]['Fields'][$x]['Placeholder'] = $row_Dtl['Placeholder'];
                $Result[$i]['Fields'][$x]['Description'] = $row_Dtl['Description'];
                $Result[$i]['Fields'][$x]['RequiredFlag'] = $row_Dtl['Required'];
                $Result[$i]['Fields'][$x]['DefaultValue'] = $row_Dtl['DefaultValue'];
                $Result[$i]['Fields'][$x]['Class'] = $row_Dtl['Class'];
                $Result[$i]['Fields'][$x]['Type'] = $row_Dtl['Type'];

                if($row_Dtl['Options'] != ''){
                    $Options = json_decode($row_Dtl['Options'],true);
                    for($z = 0, $zMax = count($Options); $z < $zMax; $z++){
                        $Result[$i]['Fields'][$x]['Options'][($z + 1)]['Label'] = $Options[$z]['label'];
                        $Result[$i]['Fields'][$x]['Options'][($z + 1)]['Value'] = $Options[$z]['value'];
                    }
                }

                if($row_Dtl['FieldType'] == 'file'){
                    $Result[$i]['enctype'] = 'multipart/form-data';
                }

                $x++;
            }

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function EditForm($Connection, $ID, $Name, $Status, $Fields)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $GetStatus = $Connection->Select('web.form_hdr',array('Status','Used'),"`ID` = '$ID'",'','','1');
        $row_GetStatus = mysqli_fetch_assoc($GetStatus);
        if($row_GetStatus['Used'] == '1'){
            $QUERY = $Connection->Update('web.form_hdr', array('Name' => $Name, 'Status' => $Status), "`ID` = '$ID'");
            if ($QUERY['status']) {

                $Result['status'] = true;
                $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                $Result['key'] = $ID;
                $Result['error'] = '';

            } else {
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
                $Result['error'] = $QUERY['error'];
                $Result['key'] = $ID;
            }

            return $Result;
        }
        elseif($row_GetStatus['Used'] == '0'){

            $Connection->StartTransaction();

            $DeleteFields = $Connection->Delete('web.form_dtl',"`HdrID` = '$ID'");
            if(!$DeleteFields['status']){
                $Result['status'] = false;
                $Result['msg'] = 'خطا در پاکسازی اطلاعات قدیمی';
                $Result['error'] = $DeleteFields['error'];
                $Result['key'] = '';

                $Connection->Rollback();

                return $Result;
            }

            $QUERY = $Connection->Update('web.form_hdr', array('Name' => $Name, 'Status' => $Status, 'JsonFormData' => $Fields), "`ID` = '$ID'");
            if ($QUERY['status']) {

                $Fields = json_decode($Fields, true);
                for ($i = 0, $iMax = count($Fields); $i < $iMax; $i++) {

                    $FieldName = isset($Fields[$i]['name']) ? $Fields[$i]['name'] : '';
                    $FieldType = isset($Fields[$i]['type']) ? $Fields[$i]['type'] : '';
                    $Label = isset($Fields[$i]['label']) ? $Fields[$i]['label'] : '';
                    $Placeholder = isset($Fields[$i]['placeholder']) ? $Fields[$i]['placeholder'] : '';
                    $Description = isset($Fields[$i]['description']) ? $Fields[$i]['description'] : '';
                    $Required = isset($Fields[$i]['required']) ? $Fields[$i]['required'] : '';
                    $DefaultValue = isset($Fields[$i]['value']) ? $Fields[$i]['value'] : '';
                    $Class = isset($Fields[$i]['className']) ? $Fields[$i]['className'] : '';
                    $Type = isset($Fields[$i]['subtype']) ? $Fields[$i]['subtype'] : 'NULL';
                    $Options = isset($Fields[$i]['values']) ? json_encode($Fields[$i]['values']) : '';
                    $Rows = isset($Fields[$i]['rows']) ? $Fields[$i]['rows'] : '0';

                    if ($FieldType == 'header') {
                        $FieldName = 'Header' . mt_rand();
                    }

                    if ($FieldName == '') {
                        $Result['status'] = false;
                        $Result['msg'] = 'نام یکتا فیلد شماره ' . ($i + 1) . ' وارد نشده است.';
                        $Result['error'] = '';
                        $Result['key'] = '';

                        $Connection->Rollback();

                        return $Result;
                    }
                    if ($FieldType == '') {
                        $Result['status'] = false;
                        $Result['msg'] = 'نوع فیلد شماره ' . ($i + 1) . ' انتخاب نشده است.';
                        $Result['error'] = '';
                        $Result['key'] = '';

                        $Connection->Rollback();

                        return $Result;
                    }
                    if (($FieldType == 'radio-group' || $FieldType == 'select') AND $Options = '') {
                        $Result['status'] = false;
                        $Result['msg'] = 'در فیلد شماره ' . ($i + 1) . ' گزینه ها تعریف نشده اند.';
                        $Result['error'] = '';
                        $Result['key'] = '';

                        $Connection->Rollback();

                        return $Result;
                    }
                    if ($Required == '') {
                        $Required = '0';
                    }

                    $QUERY = $Connection->Insert('web.form_dtl', array(), array(array('NULL', $ID, $FieldName, $FieldType, $Label, $Placeholder, $Description, $Required, $DefaultValue, $Class, $Type, $Options, $Rows)));
                    if (!$QUERY['status']) {
                        $Result['status'] = false;
                        $Result['msg'] = 'خطا در ثبت ردیف ' . ($i + 1);
                        $Result['error'] = $QUERY['error'];
                        $Result['key'] = '';

                        $Connection->Rollback();

                        return $Result;
                    }

                }

                $Result['status'] = true;
                $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                $Result['key'] = $QUERY['key'];
                $Result['error'] = '';

                $Connection->Commit();

                return $Result;

            }

            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';

            $Connection->Rollback();

            return $Result;

        }

    }

    public function DeleteForm($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.form_hdr', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    /*
     * Status: 1 => New
     * Status: 2 => Viewed
     */
    public function AddFormAnswer($Connection, $FormID){
        if (empty($Connection)) {
            $Connection = new Database;
        }
        $General = new General();

        $Connection->StartTransaction();

        $CT = time();

        $QUERY = $Connection->Insert('web.form_answer_hdr',array(),array(array('NULL',$FormID,$CT,'1')) );
        if($QUERY['status']){
            $HdrID = $QUERY['key'];

            $Connection->Update('web.form_hdr',array('Used' => '1'),"`ID` = '$FormID'");

            foreach ($_POST as $Key => $KeyValue){              //Key: FieldName, KeyValue: Value

                if($Connection->NumRows('web.form_dtl','ID',"`HdrID` = '$FormID' AND `FieldName` = '$Key'") > 0) {

                    $KeyValue = $Connection->CInput($KeyValue);

                    $Dtl = $Connection->Insert('web.form_answer_dtl', array(), array(array('NULL', $HdrID, $Key, $KeyValue)));
                    if (!$Dtl['status']) {
                        $Result['status'] = false;
                        $Result['msg'] = 'خطا در ثبت اطلاعات فرم';
                        $Result['error'] = $Dtl['error'];
                        $Result['key'] = '';

                        $Connection->Rollback();

                        return $Result;
                    }

                }

            }

            foreach ($_FILES as $Key => $KeyValue){              //Key: FieldName, KeyValue: Value(File)

                if($Connection->NumRows('web.form_dtl','ID',"`HdrID` = '$FormID' AND `FieldName` = '$Key'") > 0) {


                    $FileUploadResult = $General->FileUpload($KeyValue,true,'',array('jpg','jpeg','gif','png','xlsx','xls','pdf'));
                    if($FileUploadResult['status']){
                        $File = $FileUploadResult['key'];
                    }
                    else{
                        $Result['status'] = false;
                        $Result['msg'] = 'خطا در بارگذاری فایل';
                        $Result['error'] = $FileUploadResult['error'];
                        $Result['key'] = '';

                        $Connection->Rollback();

                        return $Result;
                    }

                    $Dtl = $Connection->Insert('web.form_answer_dtl', array(), array(array('NULL', $HdrID, $Key, $File)));
                    if (!$Dtl['status']) {
                        $Result['status'] = false;
                        $Result['msg'] = 'خطا در ثبت اطلاعات (فایل) فرم';
                        $Result['error'] = $Dtl['error'];
                        $Result['key'] = '';

                        $Connection->Rollback();

                        return $Result;
                    }

                }

            }

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $HdrID;
            $Result['error'] = '';

            $Connection->Commit();

            return $Result;

        }

        $Result['status'] = false;
        $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
        $Result['error'] = $QUERY['error'];
        $Result['key'] = '';

        $Connection->Rollback();

        return $Result;

    }

    public function SelectFormAnswer($Connection, $ID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.form_answer_hdr', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            $FormID = $row['FormID'];
            $AnswerID = $row['ID'];
            $FormInfo = $this->SelectForm($Connection,$FormID,'','','','1');

            if($row['Status'] == '1'){
                $Status = 'جدید';
            }
            elseif($row['Status'] == '2'){
                $Status = 'خوانده شده';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['FormID'] = $row['FormID'];
            $Result[$i]['FormName'] = $FormInfo['1']['Name'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];
            $Result[$i]['CT'] = date('Y m d H:i', $row['CT']);
            $Result[$i]['CTJalali'] = jdate('Y/m/d H:i', $row['CT'], '', 'Asia/Tehran', 'en');
            $Result[$i]['CTString'] = $row['CT'];

            for($x = 1, $xMax = count($FormInfo['1']['Fields']); $x <= $xMax; $x++){

                $FieldName = $FormInfo['1']['Fields'][$x]['FieldName'];

                $GetValue = $Connection->Select('web.form_answer_dtl',array('ID','Value'),"`HdrID` = '$AnswerID' AND `FieldName` = '$FieldName'",'','','1');
                if(mysqli_num_rows($GetValue) > 0){
                    $row_Value = mysqli_fetch_assoc($GetValue);
                    $Value = $row_Value['Value'];
                }
                else{
                    $Value = '-----';
                }

                $Result[$i]['Fields'][$x]['FieldName'] = $FieldName;
                $Result[$i]['Fields'][$x]['FieldType'] = $FormInfo['1']['Fields'][$x]['FieldType'];
                $Result[$i]['Fields'][$x]['FieldLabel'] = $FormInfo['1']['Fields'][$x]['Label'];
                $Result[$i]['Fields'][$x]['Value'] = $Value;

            }

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function DeleteFormAnswer($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.form_answer_hdr', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    /*
     * ContentType: 1 => Best sellers goods
     * ContentType: 2 => New goods
     * ContentType: 3 => New post
     * ContentType: 4 => New page
     * ContentType: 5 => Goods categories
     * ContentType: 6 => Post categories
     * Categories: Array(CategoryID)
     */
    public function AddContentBox($Connection, $Name, $Desc, $ContentType, array $Categories)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Connection->StartTransaction();

        $QUERY = $Connection->Insert('web.content_box', array(), array(array('NULL', $Name, $Desc, '1', $ContentType)));
        if ($QUERY['status']) {

            $HdrID = $QUERY['key'];

            if ($ContentType == '5') {
                foreach ($Categories as $Key => $KeyValue) {             //Key: ArrayIndex, KeyValue:ID
                    $Values[] = array('NULL', $HdrID, 'NULL', $KeyValue);
                }

                $QUERY = $Connection->Insert('web.content_box_dtl',array(),$Values);
                if($QUERY['status']){
                    $Result['status'] = true;
                    $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                    $Result['key'] = $QUERY['key'];
                    $Result['error'] = '';

                    $Connection->Commit();

                    return $Result;
                }

                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] = $QUERY['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;

            } elseif ($ContentType == '6') {
                foreach ($Categories as $Key => $KeyValue) {             //Key: ArrayIndex, KeyValue:ID
                    $Values[] = array('NULL', $HdrID, $KeyValue, 'NULL');
                }

                $QUERY = $Connection->Insert('web.content_box_dtl',array(),$Values);
                if($QUERY['status']){
                    $Result['status'] = true;
                    $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                    $Result['key'] = $QUERY['key'];
                    $Result['error'] = '';

                    $Connection->Commit();

                    return $Result;
                }

                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 2)';
                $Result['error'] = $QUERY['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;

            }

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

            $Connection->Commit();

            return $Result;

        }

        $Result['status'] = false;
        $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
        $Result['error'] = $QUERY['error'];
        $Result['key'] = '';

        $Connection->RollBack();

        return $Result;
    }

    /*
     * ContentType: 1 => Best sellers goods
     * ContentType: 2 => New goods
     * ContentType: 3 => New post
     * ContentType: 4 => New page
     * ContentType: 5 => Goods categories
     * ContentType: 6 => Post categories
     * Categories: Array(CategoryID)
     */
    public function EditContentBox($Connection, $ID, $Name, $Desc, $Status, $ContentType, array $Categories)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Connection->StartTransaction();

        $QUERY = $Connection->Update('web.content_box', array('Name' => $Name, 'Desc' => $Desc, 'Status' => $Status, 'ContentType' => $ContentType), "`ID` = '$ID'");
        if ($QUERY['status']) {

            $QUERY = $Connection->Delete('web.content_box_dtl',"`HdrID` = '$ID'");
            if(!$QUERY['status']){
                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 1)';
                $Result['error'] = $QUERY['error'];
                $Result['key'] = $ID;

                $Connection->RollBack();

                return $Result;
            }

            if ($ContentType == '5') {
                foreach ($Categories as $Key => $KeyValue) {             //Key: ArrayIndex, KeyValue:ID
                    $Values[] = array('NULL', $ID, 'NULL', $KeyValue);
                }

                $QUERY = $Connection->Insert('web.content_box_dtl',array(),$Values);
                if($QUERY['status']){
                    $Result['status'] = true;
                    $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                    $Result['key'] = $QUERY['key'];
                    $Result['error'] = '';

                    $Connection->Commit();

                    return $Result;
                }

                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 2)';
                $Result['error'] = $QUERY['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;

            } elseif ($ContentType == '6') {
                foreach ($Categories as $Key => $KeyValue) {             //Key: ArrayIndex, KeyValue:ID
                    $Values[] = array('NULL', $ID, $KeyValue, 'NULL');
                }

                $QUERY = $Connection->Insert('web.content_box_dtl',array(),$Values);
                if($QUERY['status']){
                    $Result['status'] = true;
                    $Result['msg'] = 'عملیات با موفقیت انجام شد!';
                    $Result['key'] = $QUERY['key'];
                    $Result['error'] = '';

                    $Connection->Commit();

                    return $Result;
                }

                $Result['status'] = false;
                $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید (مرحله 3)';
                $Result['error'] = $QUERY['error'];
                $Result['key'] = '';

                $Connection->RollBack();

                return $Result;

            }

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['key'] = $QUERY['key'];
            $Result['error'] = '';

            $Connection->Commit();

            return $Result;

        }

        $Result['status'] = false;
        $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
        $Result['error'] = $QUERY['error'];
        $Result['key'] = $ID;

        $Connection->RollBack();

        return $Result;
    }

    public function DeleteContentBox($Connection, $ID)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $QUERY = $Connection->Delete('web.content_box', "`ID` = '$ID'");
        if ($QUERY['status']) {

            $Result['status'] = true;
            $Result['msg'] = 'عملیات با موفقیت انجام شد!';
            $Result['error'] = '';
            $Result['key'] = '';

        } else {
            $Result['status'] = false;
            $Result['msg'] = 'خطایی رخ داده است. مجددا تلاش کنید';
            $Result['error'] = $QUERY['error'];
            $Result['key'] = '';
        }

        return $Result;

    }

    public function CheckPostCategoryRelationWithContentBox($Connection, $ContentBoxID, $PostCategoryID){
        if (empty($Connection)) {
            $Connection = new Database;
        }

        if($Connection->NumRows('web.content_box_dtl','ID',"`HdrID` = '$ContentBoxID' AND `PostCategoryID` = '$PostCategoryID'") > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function CheckGoodsCategoryRelationWithContentBox($Connection, $ContentBoxID, $GoodsCategoryID){
        if (empty($Connection)) {
            $Connection = new Database;
        }

        if($Connection->NumRows('web.content_box_dtl','ID',"`HdrID` = '$ContentBoxID' AND `GoodsCategoryID` = '$GoodsCategoryID'") > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function SelectContentBox($Connection, $ID, $Status, $ORDER_BY, $ORDER_TYPE, $LIMIT)
    {

        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Condition = '';
        if ($ID != '') {
            $Condition = " (`ID`='$ID')";
        }
        if ($Status != '') {
            if ($Condition != '') {
                $Condition .= ' AND ';
            }
            $Condition .= "(`Status`='$Status')";
        }

        $Query = $Connection->Select('web.content_box', array('*'), $Condition, $ORDER_BY, $ORDER_TYPE, $LIMIT);

        $i = '1';
        while ($row = mysqli_fetch_assoc($Query)) {

            if($row['Status'] == '1'){
                $Status = 'فعال';
            }
            elseif($row['Status'] == '0'){
                $Status = 'غیرفعال';
            }

            if($row['ContentType'] == '1'){
                $ContentType = 'کالا های پر فروش';
            }
            elseif($row['ContentType'] == '2'){
                $ContentType = 'کالا های جدید';
            }
            elseif($row['ContentType'] == '3'){
                $ContentType = 'مطالب جدید';
            }
            elseif($row['ContentType'] == '4'){
                $ContentType = 'برگه های جدید';
            }
            elseif($row['ContentType'] == '5'){
                $ContentType = 'مطالب دسته بندی';
            }
            elseif($row['ContentType'] == '6'){
                $ContentType = 'کالا های دسته بندی';
            }

            $Result[$i]['ID'] = $row['ID'];
            $Result[$i]['Name'] = $row['Name'];
            $Result[$i]['Desc'] = $row['Desc'];
            $Result[$i]['Status'] = $Status;
            $Result[$i]['StatusFlag'] = $row['Status'];
            $Result[$i]['ContentTypeFlag'] = $row['ContentType'];
            $Result[$i]['ContentType'] = $ContentType;

            $i++;
        }

        if (isset($Result)) {
            return $Result;
        }

        return array();

    }

    public function GetBoxContent($Connection, $BoxID){
        if (empty($Connection)) {
            $Connection = new Database;
        }

        $Goods = new Goods();

        $BoxInfo = $this->SelectContentBox($Connection,$BoxID,'','','','1');
        if($BoxInfo['1']['ContentTypeFlag'] == '1'){                //Best sellers goods
            $ListGoods = $Goods->GetBestSellersGoods($Connection,array(),'10');

            $Result = $ListGoods;

            return $Result;
        }
        elseif($BoxInfo['1']['ContentTypeFlag'] == '2'){                //New goods
            $ListGoods = $Goods->SelectGoods($Connection,'','','','','','',array('1','2'),'CT','DESC','10','',false,false,true,true,true,true,false,false,false,'','','',false);

            $Result = $ListGoods;

            return $Result;
        }
        elseif($BoxInfo['1']['ContentTypeFlag'] == '3'){                //New post
            $ListPost = $this->SelectPost($Connection,'','1','','','1','CT','DESC','10','','','','');

            $Result = $ListPost;

            return $Result;
        }
        elseif($BoxInfo['1']['ContentTypeFlag'] == '4'){                //New page
            $ListPost = $this->SelectPost($Connection,'','2','','','1','CT','DESC','10','','','','');

            $Result = $ListPost;

            return $Result;
        }
        elseif($BoxInfo['1']['ContentTypeFlag'] == '6'){                //Goods categories

            $GetBoxDtl = $Connection->Select('web.content_box_dtl',array('*'),"`HdrID` = '$BoxID'",'','','');
            while($row = mysqli_fetch_assoc($GetBoxDtl)){
                $Categories[] = $row['GoodsCategoryID'];
            }

            $ListGoods = $Goods->SelectGoods($Connection,'','',$Categories,'','','',array('1','2'),'CT','DESC','10','',false,false,true,true,true,true,false,false,false,'','','',true);

            $Result = $ListGoods;

            return $Result;
        }
        elseif($BoxInfo['1']['ContentTypeFlag'] == '5'){                //Post categories

            $GetBoxDtl = $Connection->Select('web.content_box_dtl',array('*'),"`HdrID` = '$BoxID'",'','','1');
            while($row = mysqli_fetch_assoc($GetBoxDtl)){
                $Categories = $row['PostCategoryID'];
            }

            $ListPost = $this->SelectPost($Connection,'','','',$Categories,'1','CT','DESC','10','','','','');

            $Result = $ListPost;

            return $Result;
        }
    }

    public function CreateSitemap(){
        $Connection = new Database;

        $Goods = new Goods();

        $ROOT = dirname(dirname(dirname(__FILE__)));

        if(!file_exists($ROOT . '/' . 'Sitemap')){
            mkdir($ROOT . '/' . 'Sitemap',0755);
        }

        $SitemapFile = $ROOT . '/' . 'Sitemap/Sitemap.xml';
        $Sitemap = '';

        $fileHandle = fopen($SitemapFile, 'w+');

        ###### Delete old content ######
        fwrite($fileHandle, $Sitemap);
        fclose($fileHandle);
        ###### Delete old content ######

        $fileHandle = fopen($SitemapFile, 'a');

        $Sitemap = "<?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        fwrite($fileHandle, $Sitemap);

        //آدرس صفحه اصلی سایت
        $Sitemap = "<url>\n<loc>http://darunet.com</loc>\n</url>\n";
        fwrite($fileHandle, $Sitemap);

        $ListGoods = $Goods->SelectGoods($Connection,'','','','','','',array(),'','','','',false,false,false,false,false,false,false,false,false,'','','',false,false);
        for($i = 1, $iMax = count($ListGoods); $i <= $iMax; $i++){
            $Sitemap = "<url>\n<loc>http://darunet.com/محصول-" . $ListGoods[$i]['Slug'] . "</loc>\n</url>\n";
            fwrite($fileHandle, $Sitemap);
        }

        $ListPost = $this->SelectPost($Connection,'','','','','','','','','','','','');
        for($i = 1, $iMax = count($ListPost); $i <= $iMax; $i++){
            $Sitemap = "<url>\n<loc>http://darunet.com/مطلب-" . $ListPost[$i]['Slug'] . "</loc>\n</url>\n";
            fwrite($fileHandle, $Sitemap);
        }

        $Sitemap = "</urlset>";
        fwrite($fileHandle, $Sitemap);
        fclose($fileHandle);

    }

}
