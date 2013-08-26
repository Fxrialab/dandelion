<?php
//check loaded page
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$start = $time;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<?php $this->element('landingHead'); ?>
<body>
    <div class="landingPage">
        <?php $this->element('landingHeader'); ?>
        <?php echo F3::render($page); ?>
        <?php $this->element('landingFooter'); ?>
    </div>
    <script type="text/javascript">
        var errorLogin = "<?php echo F3::get('MsgSignIn');?>";
        if(errorLogin) {
            $('#errorMsg').show();
        }
    </script>
</body>
</html>
<?php
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$finish = $time;
$totaltime = ($finish - $start);
printf ("Page Loaded in %f Seconds.", $totaltime);
echo "<br />";
?>