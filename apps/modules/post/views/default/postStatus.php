<?php
$status     = $this->f3->get('status');
$activity   = $status->data;
$currentUser= $this->f3->get('currentUser');
$statusID   = $this->f3->get('statusID');
$username   = $currentUser->data->username;
$like       = false;
$rand       = rand(100, 100000);
if ($currentUser->data->profilePic == 'none')
    //check man or woman later
    $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
else {
    $photo  = ElementController::findPhoto($currentUser->data->profilePic);
    $avatar = UPLOAD_URL . 'avatar/170px/' . $photo->data->fileName;
}
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