<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dandelion</title>
        <link href="<?php echo F3::get('CSS') ?>ink.css" rel="stylesheet">
        <link href="<?php echo F3::get('CSS') ?>style.css" rel="stylesheet">
        <link href="<?php echo F3::get('CSS') ?>pgwmodal.css" rel="stylesheet">
        <link href="<?php echo F3::get('CSS') ?>jquery.mCustomScrollbar.css" rel="stylesheet">
        <link href="<?php echo F3::get('CSS') ?>jquery.dropdown.css" rel="stylesheet">
        <link href="<?php echo F3::get('CSS') ?>token-input.css" rel="stylesheet">
        <link href="<?php echo F3::get('CSS') ?>select2.css" rel="stylesheet">
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.js"></script>

    </head>
    <body>

        <?php
        ViewHtml::render('topBar');
        echo View::instance()->render($page);
        ?>  


      
        <!--<script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery-1.11.0.js"></script>-->
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.pgw.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.masonry.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.infinitescroll.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery-migrate.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>pgwmodal.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.uploadfile.min.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.tmpl.min.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>init.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.mCustomScrollbar.concat.min.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.dropdown.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>upload.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.tokeninput.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>select2.js"></script>
  



</html>
