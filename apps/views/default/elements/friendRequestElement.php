<?php
/*$requestUserArrays  = $this->f3->get('requestUserArrays');
$randomKeys         = $this->f3->get('randomKeys');
$neighborCurrentUser= $this->f3->get('neighborCurrentUser');
$infoRequestUser    = $this->f3->get('infoRequestUser');
$mutualFriends      = $this->f3->get('numMutualFriends');
$infoMutualFriend   = $this->f3->get('infoMutualFriend');*/
if ($neighborCurrentUser && current($neighborCurrentUser) != '' && $infoRequestUser)
{
?>
    <div class="uiBoxPeopleYouMayKnow column-group friendRequests">
        <div class="boxTitle large-100">
            Friend Requests
        </div>
        <div class="boxContent">
            <?php
            foreach ($randomKeys as $key)
            {
                $randYourFriend         = $requestUserArrays[$key];
                $friendRequestID        = substr($randYourFriend, strpos($randYourFriend, ':') + 1);
                $requestUserName        = ucfirst($infoRequestUser[$randYourFriend][0]->firstName)." ".$infoRequestUser[$randYourFriend][0]->lastName;
                $requestUserProfilePic  = $infoRequestUser[$randYourFriend][0]->profilePic;
            ?>
                <div class="rowItemBox column-group" id="unit<?php echo $friendRequestID; ?>">
                    <div class="profilePicDiv large-30">
                        <img src="<?php echo $requestUserProfilePic; ?>" width="50" height="50">
                    </div>
                    <div class="profileInfoDiv large-70">
                        <p class="timeLineName fixMarginBottom-5"><a class="timeLineLink large-100" href=""><?php echo $requestUserName; ?></a></p>
                        <?php
                        if ($numMutualFriends[$randYourFriend] != null)
                        {
                            $numberMutualFriend     = count($numMutualFriends[$randYourFriend]);
                        ?>
                            <span><a class="mutualLink large-100" href=""><?php echo $numberMutualFriend; ?> mutual friend</a></span>
                        <?php
                        }
                        ?>
                        <a href="" class="confirmFriend uiSmallButton orange linkHover-fffff" id="<?php echo $friendRequestID; ?>"><i></i>Confirm friend</a>
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