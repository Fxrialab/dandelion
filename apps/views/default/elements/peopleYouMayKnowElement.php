<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/11/13 - 2:53 PM
 * Project: UserWired Network - Version: 1.0
 */
$yourFriends        = F3::get('yourFriend');
$infoYourFriend     = F3::get('infoYourFriend');
$relationShipAtoB   = F3::get('relationShipAtoB');
$relationShipBtoA   = F3::get('relationShipBtoA');
$mutualFriends      = F3::get('numMutualFriends');
$infoMutualFriend   = F3::get('infoMutualFriend');
//var_dump($mutualFriends);
if (current($yourFriends) != '')
{
    ?>
    <div class="module peopleYouMayKnow">
        <div class="moduleHeader"><a href="">People You May Know</a></div>
        <div class="moduleContent">
            <?php
            foreach ($yourFriends as $yourFriend)
            {
                if (!$relationShipAtoB[$yourFriend] && !$relationShipBtoA[$yourFriend])
                {
                    $yourFriendName         = ucfirst($infoYourFriend[$yourFriend][0]->firstName)." ".$infoYourFriend[$yourFriend][0]->lastName;
                    $yourFriendProfilePic   = $infoYourFriend[$yourFriend][0]->profilePic;
                    $numberMutualFriend     = count($mutualFriends[$yourFriend]);
                    if ($mutualFriends[$yourFriend] != null)
                    { ?>
                        <div class="people clear" id="">
                            <a href="" class="profilePic"><img src="<?php echo F3::get('BASE_URL'); ?><?php echo $yourFriendProfilePic; ?>" width="45" height="50" alt="" class="swTinyBoxImage" /></a>
                            <div class="info">
                                <a class="peopleName" href="/profile?id="><?php echo $yourFriendName; ?></a>
                                <div class="peopleMutual">
                                    <a href="#"><?php echo $numberMutualFriend; ?> mutual friends</a>
                                </div>
                                <div class="uiAddFriend">
                                    <a href="#">Add Friend</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    /*echo "info mutual friend: <br />";
                    foreach ($mutualFriends[$yourFriend] as $friend)
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




