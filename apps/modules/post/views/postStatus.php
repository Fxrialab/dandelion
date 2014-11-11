<?php
$currentProfile = $this->f3->get('SESSION.loggedUser');
$mod = $this->f3->get('data');
$photo = $mod["photo"];
$status = $mod["status"];
$userID = $currentProfile->recordID;
$username = $currentProfile->data->username;
$like = '';
$actorName = $currentProfile->data->fullName;
$comment = '';
$profilePic = $currentProfile->data->profilePic;
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