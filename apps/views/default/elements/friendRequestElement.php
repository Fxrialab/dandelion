<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/13/13 - 4:04 PM
 * Project: userwired Network - Version: 1.0
 */
$neighborCurrentUser= F3::get('neighborCurrentUser');
$requestRelationShip= F3::get('requestRelationShip');
$infoRequestUser    = F3::get('infoRequestUser');
$mutualFriends      = F3::get('numMutualFriends');
$infoMutualFriend   = F3::get('infoMutualFriend');
//var_dump($infoRequestUser);
if (current($neighborCurrentUser) != '' && $infoRequestUser)
{
    ?>
    <div class="module friendRequests">
        <div class="moduleHeader"><a href="">Friend Requests</a></div>
        <div class="moduleContent">
            <?php
            foreach ($neighborCurrentUser as $neighbor)
            {
                if ($requestRelationShip[$neighbor])
                {
                    $requestUserName        = ucfirst($infoRequestUser[$neighbor][0]->firstName)." ".$infoRequestUser[$neighbor][0]->lastName;
                    $requestUserProfilePic  = $infoRequestUser[$neighbor][0]->profilePic;
                    $numberMutualFriend     = count($mutualFriends[$neighbor]);
                    if ($mutualFriends[$neighbor] != null)
                    { ?>
                        <div class="people clear" id="">
                            <a href="" class="profilePic"><img src="<?php echo F3::get('BASE_URL'); ?><?php echo $requestUserProfilePic; ?>" width="45" height="50" alt="" class="swTinyBoxImage" /></a>
                            <div class="info">
                                <a class="peopleName" href="/profile?id="><?php echo $requestUserName; ?></a>
                                <div class="peopleMutual">
                                    <a href="#"><?php echo $numberMutualFriend; ?> mutual friends</a>
                                </div>
                                <div class="uiAddFriend">
                                    <a href="#">Confirm Friend</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    /*echo "info mutual friend: <br />";
                    foreach ($mutualFriends[$neighbor] as $friend)
                    {
                        //var_dump($friend);
                        echo $infoMutualFriend[$friend][0]->email."<br />";
                    }*/
                }
            }
            ?>
        </div>
        <div class="clearfix moduleFooter"><a class="viewallc" href="">View all &raquo;</a></div>
    </div>
<?php
}
?>