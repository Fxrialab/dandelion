<?php
$listStatus = F3::get('listStatus');
$likeStatus = F3::get('likeStatus');
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
        if ($user->data->profilePic == 'none'){
            $gender = ElementController::findGender($user->recordID);
            if ($gender =='male')
                $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
            else
                $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
        }else {
            $photo = ElementController::findPhoto($user->data->profilePic);
            $avatar = UPLOAD_URL . 'avatar/170px/' . $photo->data->fileName;
        }
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
        $('.taPostComment').autosize();
    });
</script>