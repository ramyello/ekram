
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $PageName; ?> </title>
    <meta name="description" content="<?php echo $PageDesc; ?>">
    <meta name="keywords" content="<?php echo $PageText; ?>">

     <link rel="stylesheet" href="dist/css/home.css">
     <?php if( $_SESSION['lang'] == "ir" ||  $_SESSION['lang'] == "ar"){ ?>
   <link rel="stylesheet" href="dist/css/rtl.css">
   <?php } ?>
    <link rel="stylesheet" href="dist/css/about.css">
    <link rel="stylesheet" href="dist/css/service.css">
    <link rel="stylesheet" href="dist/css/product.css">
</head>