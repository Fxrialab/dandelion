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

    </head>
    <body class="body">
        <div class="ink-grid">
            <?php
            echo View::instance()->render($page);
            ?>  
        </div>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>jquery.pgw.js"></script>
        <script type="text/javascript" src="<?php echo F3::get('JS') ?>pgwmodal.js"></script>
    </body>

</html>