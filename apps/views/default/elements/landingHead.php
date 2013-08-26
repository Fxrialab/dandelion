<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/1/13 - 8:53 AM
 * Project: joinShare Network - Version: 1.0
 */
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php F3::get('ENCODING'); ?>" />
    <title><?php F3::get('SITE'); ?></title>

    <link rel="stylesheet" href="<?php echo F3::get('STATIC'); ?>css/reset.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo F3::get('STATIC'); ?>css/style.css" type="text/css" />

    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/signUp.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/inputToggle.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/bootstrap-alert.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/forgotPassword.js"></script>
    <script type="text/javascript" src="<?php echo F3::get('STATIC'); ?>js/joinShare/contact.js"></script>
    <?php
    //@TODO: refactor below js later
    $msgSignUp = F3::get('MsgSignUp');
    if ( $msgSignUp != '') {
        ?>
        <script>
            $(document).ready(function(){
                msgSignUp = "<?php echo $msgSignUp; ?>";
                $('#reg_error').html(msgSignUp);
                $('#reg_error').show();
                $('#reg_error').css("height","auto");
            });
        </script>
    <?php
    }
    $msgSignIn  = F3::get('MsgSignIn');
    if ($msgSignIn != '') {?>
        <script>
            $(document).ready(function(){
                msgSignIn = "<?php echo $msgSignIn; ?>";
                $('#error_signin').html(msgSignIn);
                $('#error_signin').show();
                $('#error_signin').css("height","auto");
            });
        </script>
    <?php
    }
    $errorErrorEmail = F3::get('MsgValidate');
    if ( $errorErrorEmail != '') {
        ?>
        <script>
            $(document).ready(function(){
                message_error = "<?php echo $errorErrorEmail; ?>";
                $('#email_error').html(message_error);
                $('#email_error').show();
                $('#email_error').css("height","auto");
            });
        </script>
    <?php
    }
    ?>
</head>