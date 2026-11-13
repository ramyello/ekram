<?php
ob_start();
 session_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('AdminPanel/class/General/General.class.php');
require_once('AdminPanel/class/Database/Database.class.php');
require_once('AdminPanel/class/Website/Website.class.php');
require_once('AdminPanel/class/Sale/Sale.class.php');
require_once('AdminPanel/class/Buy/Buy.class.php');
require_once('AdminPanel/class/Goods/Goods.class.php');
require_once('AdminPanel/class/Financial/Financial.class.php');
require_once('AdminPanel/class/ClientRequest/ClientRequest.class.php');
$General = new General();
$Connection = new Database();
$Website = new Website();
$Sale = new Sale();
$Buy = new Buy();
$Goods = new Goods();
$Financial = new Financial();
$ClientRequest = new ClientRequest();


if(isset($_GET['ir'])){
    $_SESSION['lang'] = 'ir';
}elseif(isset($_GET['en'])){
    $_SESSION['lang'] = 'en';
}elseif(isset($_GET['ar'])){
    $_SESSION['lang'] = 'ar';
}elseif(isset($_GET['fr'])){
    $_SESSION['lang'] = 'fr';
}elseif(isset($_GET['ru'])){
    $_SESSION['lang'] = 'ru';
}elseif(!isset($_SESSION['lang'])){
    $_SESSION['lang'] = 'ir';
}

######### Fetch data #########
$DataSetting = $General->GetSettings($Connection);
##############################
?>

