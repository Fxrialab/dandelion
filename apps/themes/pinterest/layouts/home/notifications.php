<?php
$notification = F3::get('notification');
if (!empty($notification))
{
    foreach ($notification as $notifications)
    {
        $type = $notifications->data->verb;
        $actor = explode('_',$notifications->data->actor);
        $pos = array_search($currentUserID, $actor);
        if (!is_bool($pos))
        {
            unset($actor[$pos]);
        }
        $actor = array_values($actor);
        if (!empty($actor))
        {
            //get later avatar user
            $user = ElementController::findUser(current($actor));
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
            //get full name
            $str = '';
            if (count($actor) > 2)
            {
                $actor1 = ElementController::getFullNameUser($actor[0]);
                $actor2 = ElementController::getFullNameUser($actor[1]);
                $others = count($actor) - 2;
                $str = $str.'<b>'.$actor1.'</b>, <b>'.$actor2.'</b> and '.$others.' other people';
            }elseif (count($actor) == 2) {
                $actor1 = ElementController::getFullNameUser($actor[0]);
                $actor2 = ElementController::getFullNameUser($actor[1]);
                $str = $str.'<b>'.$actor1.'</b> and <b>'.$actor2.'</b>';
            }else {
                $actor1 = ElementController::getFullNameUser($actor[0]);
                $str = $str.'<b>'.$actor1.'</b>';
            }
            $txtNotifications = $str;

            ?>
            <li>
                <div class="control-group">
                    <div class="large-15">
                        <img src="<?php echo $avatar; ?>" width="50" height="50">
                    </div>
                    <div class="large-80">
                        <div class="notificationContent">
                            <?php
                            echo $txtNotifications.' '.$notifications->data->details;
                            ?>
                        </div>
                        <div class="notificationTimes">
                            <a href="" class="linkColor-999999 swTimeStatus" title="" name="<?php echo $notifications->data->timers; ?>"></a>
                        </div>
                    </div>
                    <div class="large-5">
                    </div>
                </div>
            </li>
            <?php
        }else {
            ?>
            <li>
                <div class="control-group content-center">
                    <span>Nothing to display</span>
                </div>
            </li>
        <?php
        }
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
