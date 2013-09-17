<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/11/13 - 2:53 PM
 * Project: UserWired Network - Version: 1.0
 */
$yourFriendArrays   = F3::get('yourFriendArrays');
$randomKeys         = F3::get('randomKeys');
$yourFriends        = F3::get('yourFriend');
$infoYourFriend     = F3::get('infoYourFriend');
$mutualFriends      = F3::get('numMutualFriends');
$infoMutualFriend   = F3::get('infoMutualFriend');

if (current($yourFriends) != '')
{
    ?>
    <div class="module peopleYouMayKnow">
        <div class="moduleHeader"><a href="">People You May Know</a></div>
        <div class="moduleContent">
            <?php
            foreach ($randomKeys as $key)
            {
                $randYourFriend         = $yourFriendArrays[$key];
                $yourFriendName         = ucfirst($infoYourFriend[$randYourFriend][0]->firstName)." ".$infoYourFriend[$randYourFriend][0]->lastName;
                $yourFriendProfilePic   = $infoYourFriend[$randYourFriend][0]->profilePic;
                $numberMutualFriend     = count($mutualFriends[$randYourFriend]);
                if ($mutualFriends[$randYourFriend] != null)
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
                foreach ($mutualFriends[$randYourFriend] as $friend)
                {
                    //var_dump($friend);
                    echo $infoMutualFriend[$friend][0]->email."<br />";
                }*/
            }
            ?>
        </div>
        <div class="clearfix moduleFooter"><a class="viewallc" href="">View all &raquo;</a></div>
    </div>
<?php
}
?>




