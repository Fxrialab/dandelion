<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/13/13 - 4:04 PM
 * Project: userwired Network - Version: 1.0
 */
$requestUserArrays  = F3::get('requestUserArrays');
$randomKeys         = F3::get('randomKeys');
$neighborCurrentUser= F3::get('neighborCurrentUser');
$infoRequestUser    = F3::get('infoRequestUser');
$mutualFriends      = F3::get('numMutualFriends');
$infoMutualFriend   = F3::get('infoMutualFriend');

if ($neighborCurrentUser && current($neighborCurrentUser) != '' && $infoRequestUser)
{
    ?>
    <div class="module friendRequests">
        <div class="moduleHeader"><a href="">Friend Requests</a></div>
        <div class="moduleContent">
            <?php
            foreach ($randomKeys as $key)
            {
                $randYourFriend = $requestUserArrays[$key];
                $requestUserName        = ucfirst($infoRequestUser[$randYourFriend][0]->firstName)." ".$infoRequestUser[$randYourFriend][0]->lastName;
                $requestUserProfilePic  = $infoRequestUser[$randYourFriend][0]->profilePic;
                ?>
                    <div class="people clear" id="">
                        <a href="" class="profilePic"><img src="<?php echo F3::get('BASE_URL'); ?><?php echo $requestUserProfilePic; ?>" width="45" height="50" alt="" class="swTinyBoxImage" /></a>
                        <div class="info">
                            <a class="peopleName" href="/profile?id="><?php echo $requestUserName; ?></a>
                            <?php
                            if ($mutualFriends[$randYourFriend] != null)
                            {
                                $numberMutualFriend     = count($mutualFriends[$randYourFriend]);
                            ?>
                                <div class="peopleMutual">
                                    <a href="#"><?php echo $numberMutualFriend; ?> mutual friends</a>
                                </div>
                            <?php
                                //}
                                /*echo "info mutual friend: <br />";
                                foreach ($mutualFriends[$randYourFriend] as $friend)
                                {
                                    //var_dump($friend);
                                    echo $infoMutualFriend[$friend][0]->email."<br />";
                                }*/
                            } ?>
                            <div class="uiAddFriend">
                                <a href="#">Confirm Friend</a>
                            </div>
                        </div>
                    </div>
                <?php
            }
            ?>
        </div>
        <div class="clearfix moduleFooter"><a class="viewallc" href="">View all &raquo;</a></div>
    </div>
<?php
}
?>