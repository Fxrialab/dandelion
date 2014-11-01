<?php
$mod = $this->f3->get('data');
$photo = $mod["photo"];
$status = $mod["status"];
$userID = $mod['user']->recordID;
$username = $mod['user']->data->username;
$like = '';
$actorName = $mod['user']->data->fullName;
$comment = '';
$avatar = UPLOAD_URL . 'avatar/170px/' . $mod['avatar'];
$f3 = require('viewMod.php');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $(".oembed<?php echo rand(); ?>").oembed(null,
                {
                    embedMethod: "append",
                    maxWidth: 1024,
                    maxHeight: 768,
                    autoplay: false
                }
        );
    });
</script>