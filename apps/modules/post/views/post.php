<?php
$listStatus = $this->f3->get('listStatus');
$likeStatus = $this->f3->get('likeStatus');
$rand = rand(100, 100000);
if (!empty($listStatus))
{
    foreach ($listStatus as $key => $status)
    {
        $objectID = $status->recordID;
        $user = HelperController::findUser($status->data->actor);
        $username = $user->data->username;
        $curUserID = $user->recordID;
        $actorName  = HelperController::getFullNameUser($curUserID);
        $like = $likeStatus[$objectID];
        $avatar = HelperController::getAvatar($user);
        $f3 = require('viewMod.php');
    }
}
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
        $('.taPostComment').autosize();
    });
</script>