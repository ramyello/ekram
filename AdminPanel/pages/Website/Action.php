<?php
/**
 * Created by Mohammad reza Moshaver - Kaveh Zarifi.
 * zarifikaveh@gmail.com
 * Date: 7/23/2020 AD
 * Time: 18:18
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../../class/General/General.class.php');
require_once('../../class/Database/Database.class.php');
require_once('../../class/Website/Website.class.php');
$General = new General();
$Connection = new Database();
$Website = new Website();

if (isset($_GET['Action'])) {

    $Action = $_GET['Action'];

    switch ($Action) {
        case "AddBannerPosition":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'BannerPosition_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddBannerPosition($Connection, $Name);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditBannerPosition":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'BannerPosition_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditBannerPosition($Connection, $ID, $Name, $Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteBannerPosition":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'BannerPosition_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteBannerPosition($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddBanner":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Banner_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'جایگاه بنر', $_POST['PositionID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['PositionID']) {
                    $PositionID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'اولویت نمایش', $_POST['Priority'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['Priority']) {
                    $Priority = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang1_Name'], $_POST['ShowLang1'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang1']) {
                    $ShowLang1 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک', $_POST['Link'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link']) {
                    $Link = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang2_Name'], $_POST['ShowLang2'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang2']) {
                    $ShowLang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang2_Name'], $_POST['Name_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang2']) {
                    $Name_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang2_Name'], $_POST['Link_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang2']) {
                    $Link_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang3_Name'], $_POST['ShowLang3'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang3']) {
                    $ShowLang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang3_Name'], $_POST['Name_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang3']) {
                    $Name_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang3_Name'], $_POST['Link_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang3']) {
                    $Link_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang4_Name'], $_POST['ShowLang4'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang4']) {
                    $ShowLang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang4_Name'], $_POST['Name_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang4']) {
                    $Name_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang4_Name'], $_POST['Link_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang4']) {
                    $Link_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang5_Name'], $_POST['ShowLang5'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang5']) {
                    $ShowLang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang5_Name'], $_POST['Name_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang5']) {
                    $Name_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang5_Name'], $_POST['Link_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang5']) {
                    $Link_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['File'])){
                    $File = $_FILES['File'];
                }
                else{
                    $File = '';
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddBanner($Connection, $PositionID,$Name,$Title,$Link,$ShowLang1,$Name_Lang2,$Title_Lang2,$Link_Lang2,$ShowLang2,$Name_Lang3,$Title_Lang3,$Link_Lang3,$ShowLang3,$Name_Lang4,$Title_Lang4,$Link_Lang4,$ShowLang4,$Name_Lang5,$Title_Lang5,$Link_Lang5,$ShowLang5,$Priority,$File);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditBanner":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Banner_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'جایگاه بنر', $_POST['PositionID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['PositionID']) {
                    $PositionID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'اولویت نمایش', $_POST['Priority'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['Priority']) {
                    $Priority = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang1_Name'], $_POST['ShowLang1'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang1']) {
                    $ShowLang1 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک', $_POST['Link'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link']) {
                    $Link = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang2_Name'], $_POST['ShowLang2'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang2']) {
                    $ShowLang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang2_Name'], $_POST['Name_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang2']) {
                    $Name_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang2_Name'], $_POST['Link_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang2']) {
                    $Link_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang3_Name'], $_POST['ShowLang3'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang3']) {
                    $ShowLang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang3_Name'], $_POST['Name_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang3']) {
                    $Name_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang3_Name'], $_POST['Link_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang3']) {
                    $Link_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang4_Name'], $_POST['ShowLang4'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang4']) {
                    $ShowLang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang4_Name'], $_POST['Name_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang4']) {
                    $Name_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang4_Name'], $_POST['Link_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang4']) {
                    $Link_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang5_Name'], $_POST['ShowLang5'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang5']) {
                    $ShowLang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang5_Name'], $_POST['Name_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang5']) {
                    $Name_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang5_Name'], $_POST['Link_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang5']) {
                    $Link_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['File'])){
                    $File = $_FILES['File'];
                }
                else{
                    $File = $_POST['File'];
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditBanner($Connection, $ID,$PositionID, $Name,$Title,$Link,$ShowLang1,$Name_Lang2,$Title_Lang2,$Link_Lang2,$ShowLang2,$Name_Lang3,$Title_Lang3,$Link_Lang3,$ShowLang3,$Name_Lang4,$Title_Lang4,$Link_Lang4,$ShowLang4,$Name_Lang5,$Title_Lang5,$Link_Lang5,$ShowLang5,$Priority,$File, $Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteBanner":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Banner_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteBanner($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddSlideshow":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Slideshow_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddSlideshow($Connection, $Name);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditSlideshow":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Slideshow_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditSlideshow($Connection, $ID, $Name, $Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteSlideshow":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Slideshow_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteSlideshow($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddSlideshowImage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'SlideshowImage_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'اسلایدشو', $_POST['SlideshowID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['SlideshowID']) {
                    $SlideshowID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'اولویت نمایش', $_POST['Priority'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['Priority']) {
                    $Priority = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang1_Name'], $_POST['ShowLang1'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang1']) {
                    $ShowLang1 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک', $_POST['Link'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link']) {
                    $Link = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang2_Name'], $_POST['ShowLang2'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang2']) {
                    $ShowLang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang2_Name'], $_POST['Name_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang2']) {
                    $Name_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang2_Name'], $_POST['Link_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang2']) {
                    $Link_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang3_Name'], $_POST['ShowLang3'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang3']) {
                    $ShowLang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang3_Name'], $_POST['Name_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang3']) {
                    $Name_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang3_Name'], $_POST['Link_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang3']) {
                    $Link_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang4_Name'], $_POST['ShowLang4'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang4']) {
                    $ShowLang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang4_Name'], $_POST['Name_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang4']) {
                    $Name_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang4_Name'], $_POST['Link_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang4']) {
                    $Link_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang5_Name'], $_POST['ShowLang5'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang5']) {
                    $ShowLang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang5_Name'], $_POST['Name_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang5']) {
                    $Name_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang5_Name'], $_POST['Link_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang5']) {
                    $Link_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['File'])){
                    $File = $_FILES['File'];
                }
                else{
                    $File = '';
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddSlideshowImage($Connection, $SlideshowID,$Name,$Title,$Link, $ShowLang1, $Name_Lang2, $Title_Lang2, $Link_Lang2, $ShowLang2, $Name_Lang3, $Title_Lang3, $Link_Lang3, $ShowLang3, $Name_Lang4, $Title_Lang4, $Link_Lang4, $ShowLang4, $Name_Lang5, $Title_Lang5, $Link_Lang5, $ShowLang5,$Priority,$File);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditSlideshowImage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'SlideshowImage_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'اسلایدشو', $_POST['SlideshowID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['SlideshowID']) {
                    $SlideshowID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'اولویت نمایش', $_POST['Priority'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['Priority']) {
                    $Priority = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang1_Name'], $_POST['ShowLang1'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang1']) {
                    $ShowLang1 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک', $_POST['Link'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link']) {
                    $Link = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang2_Name'], $_POST['ShowLang2'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang2']) {
                    $ShowLang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang2_Name'], $_POST['Name_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang2']) {
                    $Name_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang2_Name'], $_POST['Link_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang2']) {
                    $Link_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang3_Name'], $_POST['ShowLang3'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang3']) {
                    $ShowLang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang3_Name'], $_POST['Name_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang3']) {
                    $Name_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang3_Name'], $_POST['Link_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang3']) {
                    $Link_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang4_Name'], $_POST['ShowLang4'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang4']) {
                    $ShowLang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang4_Name'], $_POST['Name_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang4']) {
                    $Name_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang4_Name'], $_POST['Link_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang4']) {
                    $Link_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang5_Name'], $_POST['ShowLang5'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang5']) {
                    $ShowLang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang5_Name'], $_POST['Name_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang5']) {
                    $Name_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang5_Name'], $_POST['Link_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Link_Lang5']) {
                    $Link_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['File'])){
                    $File = $_FILES['File'];
                }
                else{
                    $File = $_POST['File'];
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditSlideshowImage($Connection, $ID,$SlideshowID, $Name,$Title,$Link, $ShowLang1, $Name_Lang2, $Title_Lang2, $Link_Lang2, $ShowLang2, $Name_Lang3, $Title_Lang3, $Link_Lang3, $ShowLang3, $Name_Lang4, $Title_Lang4, $Link_Lang4, $ShowLang4, $Name_Lang5, $Title_Lang5, $Link_Lang5, $ShowLang5,$Priority,$File, $Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteSlideshowImage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'SlideshowImage_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteSlideshowImage($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddMenuPosition":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'MenuPosition_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddMenuPosition($Connection, $Name);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditMenuPosition":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'MenuPosition_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditMenuPosition($Connection, $ID, $Name, $Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteMenuPosition":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'MenuPosition_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteMenuPosition($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddMenu":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Menu_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'سطح منو', $_POST['Layer'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Layer']) {
                    $Layer = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'منو والد', $_POST['ParentID'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['ParentID']) {
                    $ParentID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'جایگاه منو', $_POST['PositionID'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['PositionID']) {
                    $PositionID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'اولویت', $_POST['Priority'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['Priority']) {
                    $Priority = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'منو بصورت والد است؟', $_POST['IsParent'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['IsParent']) {
                    $IsParent = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang1_Name'], $_POST['ShowLang1'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang1']) {
                    $ShowLang1 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک', $_POST['Link'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link']) {
                    $Link = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang2_Name'], $_POST['ShowLang2'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang2']) {
                    $ShowLang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang2_Name'], $_POST['Link_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link_Lang2']) {
                    $Link_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang3_Name'], $_POST['ShowLang3'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang3']) {
                    $ShowLang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang3_Name'], $_POST['Link_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link_Lang3']) {
                    $Link_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang4_Name'], $_POST['ShowLang4'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang4']) {
                    $ShowLang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang4_Name'], $_POST['Link_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link_Lang4']) {
                    $Link_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang5_Name'], $_POST['ShowLang5'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang5']) {
                    $ShowLang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang5_Name'], $_POST['Link_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link_Lang5']) {
                    $Link_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['Icon'])){
                    $Icon = $_FILES['Icon'];
                }
                else{
                    $Icon = $_POST['Icon'];
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddMenu($Connection,$PositionID,$Layer,$ParentID,$Title,$Link,$ShowLang1,$Title_Lang2,$Link_Lang2,$ShowLang2,$Title_Lang3,$Link_Lang3,$ShowLang3,$Title_Lang4,$Link_Lang4,$ShowLang4,$Title_Lang5,$Link_Lang5,$ShowLang5,$Icon,$Priority, $IsParent);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditMenu":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Menu_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'شناسه منو', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'منو والد', $_POST['ParentID'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['ParentID']) {
                    $ParentID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'جایگاه منو', $_POST['PositionID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['PositionID']) {
                    $PositionID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'اولویت', $_POST['Priority'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['Priority']) {
                    $Priority = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'منو بصورت والد است؟', $_POST['IsParent'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['IsParent']) {
                    $IsParent = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang1_Name'], $_POST['ShowLang1'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang1']) {
                    $ShowLang1 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک', $_POST['Link'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link']) {
                    $Link = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang2_Name'], $_POST['ShowLang2'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang2']) {
                    $ShowLang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang2_Name'], $_POST['Link_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link_Lang2']) {
                    $Link_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang3_Name'], $_POST['ShowLang3'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang3']) {
                    $ShowLang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang3_Name'], $_POST['Link_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link_Lang3']) {
                    $Link_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang4_Name'], $_POST['ShowLang4'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang4']) {
                    $ShowLang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang4_Name'], $_POST['Link_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link_Lang4']) {
                    $Link_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نمایش در نسخه ' . $_SESSION['License']['Lang5_Name'], $_POST['ShowLang5'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ShowLang5']) {
                    $ShowLang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان ' . $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'لینک ' . $_SESSION['License']['Lang5_Name'], $_POST['Link_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Link_Lang5']) {
                    $Link_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['Icon'])){
                    $Icon = $_FILES['Icon'];
                }
                else{
                    $Icon = $_POST['Icon'];
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditMenu($Connection,$ID,$PositionID,$ParentID,$Title,$Link,$ShowLang1,$Title_Lang2,$Link_Lang2,$ShowLang2,$Title_Lang3,$Link_Lang3,$ShowLang3,$Title_Lang4,$Link_Lang4,$ShowLang4,$Title_Lang5,$Link_Lang5,$ShowLang5,$Icon,$Priority, $IsParent,$Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteMenu":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Menu_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteMenu($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddPostCategory":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'PostCategory_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang2_Name'], $_POST['Name_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang2']) {
                    $Name_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang3_Name'], $_POST['Name_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang3']) {
                    $Name_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang4_Name'], $_POST['Name_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang4']) {
                    $Name_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang5_Name'], $_POST['Name_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang5']) {
                    $Name_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی (Title)', $_POST['SEO_Title'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title']) {
                    $SEO_Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی (Description)', $_POST['SEO_Description'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description']) {
                    $SEO_Description = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی (Keywords)', $_POST['SEO_Keywords'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords']) {
                    $SEO_Keywords = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang1_Name'] . ' (Title)', $_POST['SEO_Title'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title']) {
                    $SEO_Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang1_Name'] . ' (Description)', $_POST['SEO_Description'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description']) {
                    $SEO_Description = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang1_Name'] . ' (Keywords)', $_POST['SEO_Keywords'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords']) {
                    $SEO_Keywords = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang2_Name'] . ' (Title)', $_POST['SEO_Title_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang2']) {
                    $SEO_Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang2_Name'] . ' (Description)', $_POST['SEO_Description_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang2']) {
                    $SEO_Description_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang2_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang2']) {
                    $SEO_Keywords_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang3_Name'] . ' (Title)', $_POST['SEO_Title_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang3']) {
                    $SEO_Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang3_Name'] . ' (Description)', $_POST['SEO_Description_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang3']) {
                    $SEO_Description_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang3_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang3']) {
                    $SEO_Keywords_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang4_Name'] . ' (Title)', $_POST['SEO_Title_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang4']) {
                    $SEO_Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang4_Name'] . ' (Description)', $_POST['SEO_Description_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang4']) {
                    $SEO_Description_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang4_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang4']) {
                    $SEO_Keywords_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang5_Name'] . ' (Title)', $_POST['SEO_Title_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang5']) {
                    $SEO_Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang5_Name'] . ' (Description)', $_POST['SEO_Description_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang5']) {
                    $SEO_Description_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang5_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang5']) {
                    $SEO_Keywords_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'سطح دسته بندی', $_POST['Layer'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Layer']) {
                    $Layer = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'شناسه والد', $_POST['ParentID'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['ParentID']) {
                    $ParentID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddPostCategory($Connection, $Layer, $ParentID, $Name,$Name_Lang2,$Name_Lang3,$Name_Lang4,$Name_Lang5,$SEO_Title,$SEO_Description,$SEO_Keywords,'',$SEO_Title_Lang2,$SEO_Description_Lang2,$SEO_Keywords_Lang2,'',$SEO_Title_Lang3,$SEO_Description_Lang3,$SEO_Keywords_Lang3,'',$SEO_Title_Lang4,$SEO_Description_Lang4,$SEO_Keywords_Lang4,'',$SEO_Title_Lang5,$SEO_Description_Lang5,$SEO_Keywords_Lang5,'');

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditPostCategory":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'PostCategory_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang2_Name'], $_POST['Name_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang2']) {
                    $Name_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang3_Name'], $_POST['Name_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang3']) {
                    $Name_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang4_Name'], $_POST['Name_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang4']) {
                    $Name_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام ' . $_SESSION['License']['Lang5_Name'], $_POST['Name_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name_Lang5']) {
                    $Name_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی (Title)', $_POST['SEO_Title'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title']) {
                    $SEO_Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی (Description)', $_POST['SEO_Description'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description']) {
                    $SEO_Description = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی (Keywords)', $_POST['SEO_Keywords'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords']) {
                    $SEO_Keywords = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang1_Name'] . ' (Title)', $_POST['SEO_Title'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title']) {
                    $SEO_Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang1_Name'] . ' (Description)', $_POST['SEO_Description'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description']) {
                    $SEO_Description = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang1_Name'] . ' (Keywords)', $_POST['SEO_Keywords'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords']) {
                    $SEO_Keywords = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang2_Name'] . ' (Title)', $_POST['SEO_Title_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang2']) {
                    $SEO_Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang2_Name'] . ' (Description)', $_POST['SEO_Description_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang2']) {
                    $SEO_Description_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang2_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang2']) {
                    $SEO_Keywords_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang3_Name'] . ' (Title)', $_POST['SEO_Title_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang3']) {
                    $SEO_Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang3_Name'] . ' (Description)', $_POST['SEO_Description_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang3']) {
                    $SEO_Description_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang3_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang3']) {
                    $SEO_Keywords_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang4_Name'] . ' (Title)', $_POST['SEO_Title_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang4']) {
                    $SEO_Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang4_Name'] . ' (Description)', $_POST['SEO_Description_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang4']) {
                    $SEO_Description_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang4_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang4']) {
                    $SEO_Keywords_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان دسته بندی ' . $_SESSION['License']['Lang5_Name'] . ' (Title)', $_POST['SEO_Title_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang5']) {
                    $SEO_Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیجات دسته بندی ' . $_SESSION['License']['Lang5_Name'] . ' (Description)', $_POST['SEO_Description_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang5']) {
                    $SEO_Description_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی دسته بندی ' . $_SESSION['License']['Lang5_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang5']) {
                    $SEO_Keywords_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'سطح دسته بندی', $_POST['Layer'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Layer']) {
                    $Layer = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'شناسه والد', $_POST['ParentID'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['ParentID']) {
                    $ParentID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditPostCategory($Connection, $ID, $Layer, $ParentID,$Name,$Name_Lang2,$Name_Lang3,$Name_Lang4,$Name_Lang5,$SEO_Title,$SEO_Description,$SEO_Keywords,$SEO_Title_Lang2,$SEO_Description_Lang2,$SEO_Keywords_Lang2,$SEO_Title_Lang3,$SEO_Description_Lang3,$SEO_Keywords_Lang3,$SEO_Title_Lang4,$SEO_Description_Lang4,$SEO_Keywords_Lang4,$SEO_Title_Lang5,$SEO_Description_Lang5,$SEO_Keywords_Lang5, $Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeletePostCategory":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'PostCategory_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeletePostCategory($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddPost":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Post_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' .  $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' .  $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' .  $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' .  $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم', $_POST['FormID'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID']) {
                    $FormID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang2_Name'], $_POST['FormID_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang2']) {
                    $FormID_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang3_Name'], $_POST['FormID_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang3']) {
                    $FormID_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang4_Name'], $_POST['FormID_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang4']) {
                    $FormID_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang5_Name'], $_POST['FormID_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang5']) {
                    $FormID_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'دسته بندی', $_POST['CategoryID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['CategoryID']) {
                    $CategoryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'گالری', $_POST['GalleryID'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['GalleryID']) {
                    $GalleryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $Context = $_POST['Context'];

                $Content = $_POST['Content'];

                $Context_Lang2 = $_POST['Context_Lang2'];

                $Content_Lang2 = $_POST['Content_Lang2'];

                $Context_Lang3 = $_POST['Context_Lang3'];

                $Content_Lang3 = $_POST['Content_Lang3'];

                $Context_Lang4 = $_POST['Context_Lang4'];

                $Content_Lang4 = $_POST['Content_Lang4'];

                $Context_Lang5 = $_POST['Context_Lang5'];

                $Content_Lang5 = $_POST['Content_Lang5'];

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته (Title)', $_POST['SEO_Title'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title']) {
                    $SEO_Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته (Description)', $_POST['SEO_Description'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description']) {
                    $SEO_Description = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته (Keywords)', $_POST['SEO_Keywords'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords']) {
                    $SEO_Keywords = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' . $_SESSION['License']['Lang2_Name'] . ' (Title)', $_POST['SEO_Title_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang2']) {
                    $SEO_Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته ' . $_SESSION['License']['Lang2_Name'] . ' (Description)', $_POST['SEO_Description_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang2']) {
                    $SEO_Description_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته ' . $_SESSION['License']['Lang2_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang2']) {
                    $SEO_Keywords_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' . $_SESSION['License']['Lang3_Name'] . ' (Title)', $_POST['SEO_Title_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang3']) {
                    $SEO_Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته ' . $_SESSION['License']['Lang3_Name'] . ' (Description)', $_POST['SEO_Description_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang3']) {
                    $SEO_Description_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته ' . $_SESSION['License']['Lang3_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang3']) {
                    $SEO_Keywords_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' . $_SESSION['License']['Lang4_Name'] . ' (Title)', $_POST['SEO_Title_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang4']) {
                    $SEO_Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته ' . $_SESSION['License']['Lang4_Name'] . ' (Description)', $_POST['SEO_Description_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang4']) {
                    $SEO_Description_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته ' . $_SESSION['License']['Lang4_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang4']) {
                    $SEO_Keywords_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' . $_SESSION['License']['Lang5_Name'] . ' (Title)', $_POST['SEO_Title_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang5']) {
                    $SEO_Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته ' . $_SESSION['License']['Lang5_Name'] . ' (Description)', $_POST['SEO_Description_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang5']) {
                    $SEO_Description_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته ' . $_SESSION['License']['Lang5_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang5']) {
                    $SEO_Keywords_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['Thumb'])){
                    $Thumb = $_FILES['Thumb'];
                }
                else{
                    $Thumb = '';
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddPost($Connection,'1', $Title,$Context,$Content,$FormID,$Title_Lang2,$Context_Lang2,$Content_Lang2,$FormID_Lang2,$Title_Lang3,$Context_Lang3,$Content_Lang3,$FormID_Lang3,$Title_Lang4,$Context_Lang4,$Content_Lang4,$FormID_Lang4,$Title_Lang5,$Context_Lang5,$Content_Lang5,$FormID_Lang5,$CategoryID,$Thumb,$SEO_Title,$SEO_Description,$SEO_Keywords,'',$SEO_Title_Lang2,$SEO_Description_Lang2,$SEO_Keywords_Lang2,'',$SEO_Title_Lang3,$SEO_Description_Lang3,$SEO_Keywords_Lang3,'',$SEO_Title_Lang4,$SEO_Description_Lang4,$SEO_Keywords_Lang4,'',$SEO_Title_Lang5,$SEO_Description_Lang5,$SEO_Keywords_Lang5,'',$Status,$GalleryID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditPost":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Post_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'شناسه نوشته', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' .  $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' .  $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' .  $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' .  $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم', $_POST['FormID'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID']) {
                    $FormID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang2_Name'], $_POST['FormID_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang2']) {
                    $FormID_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang3_Name'], $_POST['FormID_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang3']) {
                    $FormID_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang4_Name'], $_POST['FormID_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang4']) {
                    $FormID_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang5_Name'], $_POST['FormID_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang5']) {
                    $FormID_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'دسته بندی', $_POST['CategoryID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['CategoryID']) {
                    $CategoryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'گالری', $_POST['GalleryID'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['GalleryID']) {
                    $GalleryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $Context = $_POST['Context'];

                $Content = $_POST['Content'];

                $Context_Lang2 = $_POST['Context_Lang2'];

                $Content_Lang2 = $_POST['Content_Lang2'];

                $Context_Lang3 = $_POST['Context_Lang3'];

                $Content_Lang3 = $_POST['Content_Lang3'];

                $Context_Lang4 = $_POST['Context_Lang4'];

                $Content_Lang4 = $_POST['Content_Lang4'];

                $Context_Lang5 = $_POST['Context_Lang5'];

                $Content_Lang5 = $_POST['Content_Lang5'];

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته (Title)', $_POST['SEO_Title'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title']) {
                    $SEO_Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته (Description)', $_POST['SEO_Description'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description']) {
                    $SEO_Description = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته (Keywords)', $_POST['SEO_Keywords'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords']) {
                    $SEO_Keywords = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' . $_SESSION['License']['Lang2_Name'] . ' (Title)', $_POST['SEO_Title_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang2']) {
                    $SEO_Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته ' . $_SESSION['License']['Lang2_Name'] . ' (Description)', $_POST['SEO_Description_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang2']) {
                    $SEO_Description_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته ' . $_SESSION['License']['Lang2_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang2']) {
                    $SEO_Keywords_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' . $_SESSION['License']['Lang3_Name'] . ' (Title)', $_POST['SEO_Title_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang3']) {
                    $SEO_Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته ' . $_SESSION['License']['Lang3_Name'] . ' (Description)', $_POST['SEO_Description_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang3']) {
                    $SEO_Description_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته ' . $_SESSION['License']['Lang3_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang3']) {
                    $SEO_Keywords_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' . $_SESSION['License']['Lang4_Name'] . ' (Title)', $_POST['SEO_Title_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang4']) {
                    $SEO_Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته ' . $_SESSION['License']['Lang4_Name'] . ' (Description)', $_POST['SEO_Description_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang4']) {
                    $SEO_Description_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته ' . $_SESSION['License']['Lang4_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang4']) {
                    $SEO_Keywords_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان نوشته ' . $_SESSION['License']['Lang5_Name'] . ' (Title)', $_POST['SEO_Title_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang5']) {
                    $SEO_Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات نوشته ' . $_SESSION['License']['Lang5_Name'] . ' (Description)', $_POST['SEO_Description_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang5']) {
                    $SEO_Description_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی نوشته ' . $_SESSION['License']['Lang5_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang5']) {
                    $SEO_Keywords_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['Thumb'])){
                    $Thumb = $_FILES['Thumb'];
                }
                else{
                    $Thumb = $_POST['Thumb'];
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditPost($Connection,$ID, $Title,$Context,$Content,$FormID,$Title_Lang2,$Context_Lang2,$Content_Lang2,$FormID_Lang2,$Title_Lang3,$Context_Lang3,$Content_Lang3,$FormID_Lang3,$Title_Lang4,$Context_Lang4,$Content_Lang4,$FormID_Lang4,$Title_Lang5,$Context_Lang5,$Content_Lang5,$FormID_Lang5,$CategoryID,$Thumb,$SEO_Title,$SEO_Description,$SEO_Keywords,$SEO_Title_Lang2,$SEO_Description_Lang2,$SEO_Keywords_Lang2,$SEO_Title_Lang3,$SEO_Description_Lang3,$SEO_Keywords_Lang3,$SEO_Title_Lang4,$SEO_Description_Lang4,$SEO_Keywords_Lang4,$SEO_Title_Lang5,$SEO_Description_Lang5,$SEO_Keywords_Lang5,$Status,$GalleryID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeletePost":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Post_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeletePost($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddPage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Page_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'عنوان برگه', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' .  $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' .  $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' .  $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' .  $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم', $_POST['FormID'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID']) {
                    $FormID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang2_Name'], $_POST['FormID_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang2']) {
                    $FormID_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang3_Name'], $_POST['FormID_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang3']) {
                    $FormID_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang4_Name'], $_POST['FormID_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang4']) {
                    $FormID_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang5_Name'], $_POST['FormID_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang5']) {
                    $FormID_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'دسته بندی', $_POST['CategoryID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['CategoryID']) {
                    $CategoryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                //$CV_result = $General->CVInput($Connection, 'گالری', $_POST['GalleryID'], '', '', '', '');
                //if (stripslashes($CV_result) == $_POST['GalleryID']) {
                   // $GalleryID = mysqli_real_escape_string($Connection, json_encode($CV_result));
                //} else {
                //    $CV_error[] = $CV_result;
                ///}
                $GalleryID =  json_encode($_POST['GalleryID']);
                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $Content = $_POST['Content'];

                $Content_Lang2 = $_POST['Content_Lang2'];

                $Content_Lang3 = $_POST['Content_Lang3'];

                $Content_Lang4 = $_POST['Content_Lang4'];

                $Content_Lang5 = $_POST['Content_Lang5'];

                $CV_result = $General->CVInput($Connection, 'عنوان برگه (Title)', $_POST['SEO_Title'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title']) {
                    $SEO_Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه (Description)', $_POST['SEO_Description'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description']) {
                    $SEO_Description = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه (Keywords)', $_POST['SEO_Keywords'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords']) {
                    $SEO_Keywords = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' . $_SESSION['License']['Lang2_Name'] . ' (Title)', $_POST['SEO_Title_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang2']) {
                    $SEO_Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه ' . $_SESSION['License']['Lang2_Name'] . ' (Description)', $_POST['SEO_Description_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang2']) {
                    $SEO_Description_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه ' . $_SESSION['License']['Lang2_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang2']) {
                    $SEO_Keywords_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' . $_SESSION['License']['Lang3_Name'] . ' (Title)', $_POST['SEO_Title_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang3']) {
                    $SEO_Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه ' . $_SESSION['License']['Lang3_Name'] . ' (Description)', $_POST['SEO_Description_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang3']) {
                    $SEO_Description_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه ' . $_SESSION['License']['Lang3_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang3']) {
                    $SEO_Keywords_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' . $_SESSION['License']['Lang4_Name'] . ' (Title)', $_POST['SEO_Title_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang4']) {
                    $SEO_Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه ' . $_SESSION['License']['Lang4_Name'] . ' (Description)', $_POST['SEO_Description_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang4']) {
                    $SEO_Description_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه ' . $_SESSION['License']['Lang4_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang4']) {
                    $SEO_Keywords_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' . $_SESSION['License']['Lang5_Name'] . ' (Title)', $_POST['SEO_Title_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang5']) {
                    $SEO_Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه ' . $_SESSION['License']['Lang5_Name'] . ' (Description)', $_POST['SEO_Description_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang5']) {
                    $SEO_Description_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه ' . $_SESSION['License']['Lang5_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang5']) {
                    $SEO_Keywords_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['Thumb'])){
                    $Thumb = $_FILES['Thumb'];
                }
                else{
                    $Thumb = '';
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddPost($Connection,'2', $Title,'',$Content,$FormID,$Title_Lang2,'',$Content_Lang2,$FormID_Lang2,$Title_Lang3,'',$Content_Lang3,$FormID_Lang3,$Title_Lang4,'',$Content_Lang4,$FormID_Lang4,$Title_Lang5,'',$Content_Lang5,$FormID_Lang5,$CategoryID,$Thumb,$SEO_Title,$SEO_Description,$SEO_Keywords,'',$SEO_Title_Lang2,$SEO_Description_Lang2,$SEO_Keywords_Lang2,'',$SEO_Title_Lang3,$SEO_Description_Lang3,$SEO_Keywords_Lang3,'',$SEO_Title_Lang4,$SEO_Description_Lang4,$SEO_Keywords_Lang4,'',$SEO_Title_Lang5,$SEO_Description_Lang5,$SEO_Keywords_Lang5,'',$Status, $GalleryID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditPage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Page_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'شناسه برگه', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' .  $_SESSION['License']['Lang2_Name'], $_POST['Title_Lang2'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang2']) {
                    $Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' .  $_SESSION['License']['Lang3_Name'], $_POST['Title_Lang3'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang3']) {
                    $Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' .  $_SESSION['License']['Lang4_Name'], $_POST['Title_Lang4'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang4']) {
                    $Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' .  $_SESSION['License']['Lang5_Name'], $_POST['Title_Lang5'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title_Lang5']) {
                    $Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم', $_POST['FormID'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID']) {
                    $FormID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang2_Name'], $_POST['FormID_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang2']) {
                    $FormID_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang3_Name'], $_POST['FormID_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang3']) {
                    $FormID_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang4_Name'], $_POST['FormID_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang4']) {
                    $FormID_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'فرم ' .  $_SESSION['License']['Lang5_Name'], $_POST['FormID_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['FormID_Lang5']) {
                    $FormID_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'دسته بندی', $_POST['CategoryID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['CategoryID']) {
                    $CategoryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'گالری', $_POST['GalleryID'], 'Number', '', '', '');
                if (stripslashes($CV_result) == $_POST['GalleryID']) {
                    $GalleryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $Content = $_POST['Content'];

                $Content_Lang2 = $_POST['Content_Lang2'];

                $Content_Lang3 = $_POST['Content_Lang3'];

                $Content_Lang4 = $_POST['Content_Lang4'];

                $Content_Lang5 = $_POST['Content_Lang5'];

                $CV_result = $General->CVInput($Connection, 'عنوان برگه (Title)', $_POST['SEO_Title'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title']) {
                    $SEO_Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه (Description)', $_POST['SEO_Description'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description']) {
                    $SEO_Description = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه (Keywords)', $_POST['SEO_Keywords'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords']) {
                    $SEO_Keywords = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' . $_SESSION['License']['Lang2_Name'] . ' (Title)', $_POST['SEO_Title_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang2']) {
                    $SEO_Title_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه ' . $_SESSION['License']['Lang2_Name'] . ' (Description)', $_POST['SEO_Description_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang2']) {
                    $SEO_Description_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه ' . $_SESSION['License']['Lang2_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang2'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang2']) {
                    $SEO_Keywords_Lang2 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' . $_SESSION['License']['Lang3_Name'] . ' (Title)', $_POST['SEO_Title_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang3']) {
                    $SEO_Title_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه ' . $_SESSION['License']['Lang3_Name'] . ' (Description)', $_POST['SEO_Description_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang3']) {
                    $SEO_Description_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه ' . $_SESSION['License']['Lang3_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang3'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang3']) {
                    $SEO_Keywords_Lang3 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' . $_SESSION['License']['Lang4_Name'] . ' (Title)', $_POST['SEO_Title_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang4']) {
                    $SEO_Title_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه ' . $_SESSION['License']['Lang4_Name'] . ' (Description)', $_POST['SEO_Description_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang4']) {
                    $SEO_Description_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه ' . $_SESSION['License']['Lang4_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang4'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang4']) {
                    $SEO_Keywords_Lang4 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان برگه ' . $_SESSION['License']['Lang5_Name'] . ' (Title)', $_POST['SEO_Title_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Title_Lang5']) {
                    $SEO_Title_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات برگه ' . $_SESSION['License']['Lang5_Name'] . ' (Description)', $_POST['SEO_Description_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Description_Lang5']) {
                    $SEO_Description_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'کلمات کلیدی برگه ' . $_SESSION['License']['Lang5_Name'] . ' (Keywords)', $_POST['SEO_Keywords_Lang5'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['SEO_Keywords_Lang5']) {
                    $SEO_Keywords_Lang5 = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['Thumb'])){
                    $Thumb = $_FILES['Thumb'];
                }
                else{
                    $Thumb = $_POST['Thumb'];
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditPost($Connection,$ID, $Title,'',$Content, $FormID,$Title_Lang2,'',$Content_Lang2, $FormID_Lang2,$Title_Lang3,'',$Content_Lang3, $FormID_Lang3,$Title_Lang4,'',$Content_Lang4, $FormID_Lang4,$Title_Lang5,'',$Content_Lang5, $FormID_Lang5,$CategoryID,$Thumb,$SEO_Title,$SEO_Description,$SEO_Keywords,$SEO_Title_Lang2,$SEO_Description_Lang2,$SEO_Keywords_Lang2,$SEO_Title_Lang3,$SEO_Description_Lang3,$SEO_Keywords_Lang3,$SEO_Title_Lang4,$SEO_Description_Lang4,$SEO_Keywords_Lang4,$SEO_Title_Lang5,$SEO_Description_Lang5,$SEO_Keywords_Lang5,$Status,$GalleryID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeletePage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Page_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeletePost($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddGallery":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Gallery_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddGallery($Connection, $Name);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditGallery":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Gallery_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditGallery($Connection, $ID, $Name, $Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteGallery":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Gallery_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteGallery($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddGalleryImage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'GalleryImage_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'گالری', $_POST['GalleryID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['GalleryID']) {
                    $GalleryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['File'])){
                    $File = $_FILES['File'];
                }
                else{
                    $File = '';
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddGalleryImage($Connection, $GalleryID,$Title,$File);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditGalleryImage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'GalleryImage_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'گالری', $_POST['GalleryID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['GalleryID']) {
                    $GalleryID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'عنوان', $_POST['Title'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Title']) {
                    $Title = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if(isset($_FILES['File'])){
                    $File = $_FILES['File'];
                }
                else{
                    $File = $_POST['File'];
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditGalleryImage($Connection, $ID,$GalleryID,$Title,$File, $Status);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteGalleryImage":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'GalleryImage_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteGalleryImage($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddForm":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Gallery_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'نام فرم', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $FormData = $_POST['FormData'];

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddForm($Connection, $Name, $FormData);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditForm":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Form_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام فرم', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $FormData = $_POST['FormData'];

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditForm($Connection, $ID, $Name, $Status, $FormData);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteForm":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'Form_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteForm($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteFormAnswer":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'FormAnswer_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteFormAnswer($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "AddContentBox":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'ContentBox_New', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'محتوا', $_POST['ContentType'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ContentType']) {
                    $ContentType = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات', $_POST['Desc'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Desc']) {
                    $Desc = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if($_POST['ContentType'] == '5'){
                    $Categories = $_POST['PostCategoryID'];
                }
                elseif($_POST['ContentType'] == '6'){
                    $Categories = $_POST['GoodsCategoryID'];
                }
                else{
                    $Categories = array();
                }


                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->AddContentBox($Connection, $Name, $Desc, $ContentType, $Categories);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "EditContentBox":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'ContentBox_Edit', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'نام', $_POST['Name'], '', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Name']) {
                    $Name = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'محتوا', $_POST['ContentType'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['ContentType']) {
                    $ContentType = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'وضعیت', $_POST['Status'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_POST['Status']) {
                    $Status = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                $CV_result = $General->CVInput($Connection, 'توضیحات', $_POST['Desc'], '', '', '', '');
                if (stripslashes($CV_result) == $_POST['Desc']) {
                    $Desc = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                if($_POST['ContentType'] == '5'){
                    $Categories = $_POST['PostCategoryID'];
                }
                elseif($_POST['ContentType'] == '6'){
                    $Categories = $_POST['GoodsCategoryID'];
                }
                else{
                    $Categories = array();
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->EditContentBox($Connection, $ID, $Name, $Desc, $Status, $ContentType, $Categories);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        case "DeleteContentBox":

            if ($General->CheckAdminPrivilege($Connection, $_SESSION['AdminID'], 'ContentBox_Delete', '0', '')) {
                ############ Start of validation ############
                $CV_error = array();

                $CV_result = $General->CVInput($Connection, 'ID', $_GET['ID'], 'Number', '', '', '1');
                if (stripslashes($CV_result) == $_GET['ID']) {
                    $ID = $CV_result;
                } else {
                    $CV_error[] = $CV_result;
                }

                ############ End of validation ############

                if (empty($CV_error)) {
                    $result = $Website->DeleteContentBox($Connection, $ID);

                    $FormResult['status'] = $result['status'];
                    $FormResult['msg'] = $result['msg'];
                    $FormResult['error'] = $result['error'];

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);

                } else {

                    $Msg = '';
                    foreach ($CV_error as $Error) {
                        if ($Msg != '') {
                            $Msg .= '<br>';
                        }

                        $Msg .= $Error;
                    }

                    $FormResult['status'] = false;
                    $FormResult['msg'] = $Msg;

                    header('Content-Type: application/json');
                    echo json_encode($FormResult);
                }
            } else {
                $FormResult['status'] = false;
                $FormResult['msg'] = 'شما دسترسی های لازم به این بخش را ندارید';

                header('Content-Type: application/json');
                echo json_encode($FormResult);
            }

            break;

        default:
            $FormResult['status'] = false;
            $FormResult['msg'] = 'عملیات مورد نظر تعریف نشده است';

            header('Content-Type: application/json');
            echo json_encode($FormResult);

    }

} else {
    $FormResult['status'] = false;
    $FormResult['msg'] = 'عملیات تعریف نشده است';

    header('Content-Type: application/json');
    echo json_encode($FormResult);
}

