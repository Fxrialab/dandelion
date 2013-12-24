<?php
if ($yourFriends && current($yourFriends) != '' && $yourFriendArrays)
{
    ?>
    <div class="uiBoxPeopleYouMayKnow column-group friendRequests">
        <div class="boxTitle large-100">
            People You May Know
        </div>
        <div class="boxContent">
            <?php
            foreach ($randomKeys as $key)
            {
                $randYourFriend         = $yourFriendArrays[$key];
                $yourFriendID           = substr($randYourFriend, strpos($randYourFriend, ':') + 1);
                $yourFriendName         = ucfirst($infoYourFriend[$randYourFriend][0]->firstName)." ".$infoYourFriend[$randYourFriend][0]->lastName;
                $yourFriendProfile      = $infoYourFriend[$randYourFriend][0]->username;
                $yourFriendProfilePic   = $infoYourFriend[$randYourFriend][0]->profilePic;
                $numberMutualFriend     = count($numMutualFriends[$randYourFriend]);
                if ($numMutualFriends[$randYourFriend] != null)
                { ?>
                <div class="rowItemBox column-group" id="unit<?php echo $yourFriendID; ?>">
                    <div class="profilePicDiv large-30">
                        <img src="<?php echo $yourFriendProfilePic; ?>" width="50" height="50">
                    </div>
                    <div class="profileInfoDiv large-70">
                        <p class="timeLineName fixMarginBottom-5"><a class="timeLineLink large-100" href="/content/myPost?username=<?php echo $yourFriendProfile;?>"><?php echo $yourFriendName; ?></a></p>
                        <span><a class="mutualLink large-100" href=""><?php echo $numberMutualFriend; ?> mutual friend</a></span>
                        <a href="" class="uiAddFriend uiSmallButton orange linkHover-fffff" id="<?php echo $yourFriendID; ?>"><i></i>Add friend</a>
                    </div>
                </div>
                <?php
                }
                ?>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
?>