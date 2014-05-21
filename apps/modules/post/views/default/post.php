<?php
$listStatus = $this->f3->get('listStatus');
$likeStatus = $this->f3->get('likeStatus');
$rand = rand(100, 100000);
if (!empty($listStatus))
{
    foreach ($listStatus as $key => $status)
    {
        $statusID = $status->recordID;
        $activity = $status->data;
        $user = PostController::getUser($status->data->actor);
        $username = $user->data->username;
        $curUserID = $user->recordID;
        $like = $likeStatus[$statusID];
        if ($user->data->profilePic == 'none')
            $avatar = IMAGES . 'avatarMenDefault.png';
        else
            $avatar = UPLOAD_URL . '150/' . $mod['avatar'];
        $f3 = require('viewPost.php');
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
    });
</script>