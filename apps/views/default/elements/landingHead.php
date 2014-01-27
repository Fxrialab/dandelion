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
    <script type="text/javascript">
        $(document).ready(function() {
            $("a.uiTabNav").click(function () {
                //inactive all tab
                $(".activeLink").removeClass("activeLink");
                // active tab is clicking
                $(this).addClass("activeLink");
                // slideUp for tab's clicking
                $(".uiContent").slideUp();
                // if first tab is set to slideDown
                var contentShow = $(this).attr("name");
                $("#"+contentShow).slideDown();
            });
        });
    </script>
    <?php
    //@TODO: refactor below js later
    $msgSignUp = $this->f3->get('MsgSignUp');
    if ( $msgSignUp != '') {
        ?>
        <script>
            $(document).ready(function(){
                $("#uiLogInLink").removeClass("activeLink");
                $("#uiLogInBox").css('display', 'none');
                $("#uiSignUpLink").addClass("activeLink");
                $("#uiSignUpBox").css('display', 'block');
                msgSignUp = "<?php echo $msgSignUp; ?>";
                $('#uiSignUpBox').append("<div class='ink-alert basic success' id='msgSignUp'>" +
                    "<button class='ink-dismiss'>&times;</button>" +
                    "<p>"+msgSignUp+"</p></div> ");
            });
        </script>
    <?php
    }
    $msgSignIn  = $this->f3->get('MsgSignIn');
    if ($msgSignIn != '') {?>
        <script>
            $(document).ready(function(){
                msgSignIn = "<?php echo $msgSignIn; ?>";
                $('#uiLogInBox').append("<div class='ink-alert basic success' id='msgLogIn'>" +
                    "<button class='ink-dismiss'>&times;</button>" +
                    "<p>"+msgSignIn+"</p></div> ");
            });
        </script>
    <?php
    }
    $msgOther = $this->f3->get('MsgValidate');
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
    <?php $asd = $this->f3->get('user');
    //var_dump($asd);
    ?>
</head>