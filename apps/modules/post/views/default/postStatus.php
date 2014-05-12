<?php
$status     = $this->f3->get('status');
$activity   = $status->data;
$currentUser= $this->f3->get('currentUser');
$statusID   = $this->f3->get('statusID');
$avatar     = $currentUser->data->profilePic;
$username   = $currentUser->data->username;
$like       = false;
$rand       = rand(100, 100000);
$f3         = require('viewPost.php');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".oembed<?php echo $rand; ?>").oembed(null,
            {
                embedMethod: "append",
                maxWidth: 1024,
                maxHeight: 768,
                autoplay: false
            }
        );
    });
</script>