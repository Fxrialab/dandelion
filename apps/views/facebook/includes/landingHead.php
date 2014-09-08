<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->f3->get('ENCODING'); ?>" />
    <title><?php echo $this->f3->get('site2'); ?></title>
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>reset.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>main.css" type="text/css" />
    <!--[if IE 7 ]>
    <link rel="stylesheet" href="<?php echo $this->f3->get('CSS'); ?>ink-ie7.css" type="text/css" media="screen"
          title="no title">
    <![endif]-->
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/holder.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/ink-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>libs/autoload.js"></script>
    <script type="text/javascript" src="<?php echo $this->f3->get('JS'); ?>customs/validate.js"></script>
    <?php
    //@TODO: refactor below js later
    $msgSignUp = $this->f3->get('msgSignUp');
    if ( $msgSignUp != '') {
        ?>
        <script>
            $(document).ready(function(){
                msgSignUp = "<?php echo $msgSignUp; ?>";
                $('#rightLanding').append("<div class='ink-alert basic success' id='msgSignUp'>" +
                    "<button class='ink-dismiss'>&times;</button>" +
                    "<p>"+msgSignUp+"</p></div> ");
            });
        </script>
    <?php
    }
    $msgSignIn  = $this->f3->get('msgSignIn');
    if ($msgSignIn != '') {?>
        <script>
            $(document).ready(function(){
                msgSignIn = "<?php echo $msgSignIn; ?>";
                $('#rightLanding').prepend("<div class='ink-alert basic success' id='msgLogIn'>" +
                    "<button class='ink-dismiss'>&times;</button>" +
                    "<p>"+msgSignIn+"</p></div> ");
            });
        </script>
    <?php
    }
    $msgOther = $this->f3->get('msgValidate');
    if ($msgOther != '') {
        ?>
        <script>
            $(document).ready(function(){
                msgOther = "<?php echo $msgOther; ?>";
                $('.title').append("<div class='ink-alert basic success' id='msgOther'>" +
                    "<button class='ink-dismiss'>&times;</button>" +
                    "<p>"+msgOther+"</p></div> ");
            });
        </script>
    <?php
    }
    ?>
</head>