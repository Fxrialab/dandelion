<?php
$notification = F3::get('notification');
if (!empty($notification))
{
    foreach ($notification as $notifications)
    {
        $actor = $notifications->data->actor;
        //get later avatar user
        $user = ElementController::findUser($actor);
        $fullName = ElementController::getFullNameUser($actor);
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
        ?>
        <li>
            <div class="control-group">
                <div class="large-15">
                    <img src="<?php echo $avatar; ?>" width="50" height="50">
                </div>
                <div class="large-45">
                    <div class="fullName">
                        <a href="#" style="font-weight: bold"><?php echo $fullName; ?></a>
                    </div>
                </div>
                <div class="large-40">
                    <div class="option">
                        <a href="#" class="button button35 active">Comfirm</a>
                        <a href="#" class="button button35">Not now</a>
                    </div>
                </div>
            </div>
        </li>
    <?php
    }
}else {
    ?>
    <li>
        <div class="control-group content-center">
            <span>Nothing to display</span>
        </div>
    </li>
<?php
}
?>