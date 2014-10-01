<?php
if ($neighborCurrentUser && current($neighborCurrentUser) != '')
{
    ?>
    <div class="uiBoxFriendRequests column-group friendRequests">
        <div class="boxTitle large-100">
            Friend Requests
        </div>
        <div class="boxContent">
            <?php
            foreach ($randomKeys as $key)
            {
                $randYourFriend         = $requestUserArrays[$key];
                $friendRequestID        = str_replace(':', '_', $randYourFriend);
                $requestProfile         = $infoRequestUser[$randYourFriend][0]->username;
                $requestUserName        = ucfirst($infoRequestUser[$randYourFriend][0]->firstName)." ".$infoRequestUser[$randYourFriend][0]->lastName;
                $requestUserProfilePic  = $infoRequestUser[$randYourFriend][0]->profilePic;
                if ($requestUserProfilePic != 'none'){
                    $photo = HelperController::findPhoto($requestUserProfilePic);
                    $avatar = UPLOAD_URL . 'avatar/170px/' . $photo->data->fileName;
                }else {
                    $gender = HelperController::findGender($randYourFriend);
                    if ($gender =='male')
                        $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
                    else
                        $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
                }
                ?>
                <div class="rowItemBox column-group" id="unit<?php echo $friendRequestID; ?>">
                    <div class="profilePicDiv large-30">
                        <img src="<?php echo $avatar; ?>" width="50" height="50">
                    </div>
                    <div class="profileInfoDiv large-70">
                        <p class="timeLineName fixMarginBottom-5"><a class="timeLineLink large-100" href="/content/post?user=<?php echo $requestProfile;?>"><?php echo $requestUserName; ?></a></p>
                        <?php
                        if (!empty($numMutualFriends[$randYourFriend]))
                        {
                            $numberMutualFriend     = count($numMutualFriends[$randYourFriend]);
                            ?>
                            <span><a class="mutualLink large-100" href=""><?php echo $numberMutualFriend; ?> mutual friend</a></span>
                        <?php
                        }
                        ?>
                        <a class="confirmFriend uiSmallButton orange linkHover-fffff" id="<?php echo $friendRequestID; ?>"><i></i>Confirm friend</a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
?>