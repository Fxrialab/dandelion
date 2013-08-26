<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/5/13 - 9:09 AM
 * Project: joinShare Network - Version: 1.0
 */
//get data
$profileInfo    = F3::get('profile');
$otherUser      = F3::get('otherUser');
$currentUser    = F3::get('currentUser');
$status_fr      = F3::get('statusFriendShip');
//prepare data
$otherUserID    = $otherUser->recordID;
$currentUserID  = $currentUser->recordID;
$otherUserName  = ucfirst($otherUser->data->firstName)." ".ucfirst($otherUser->data->lastName);
$currentUserName= ucfirst($currentUser->data->firstName)." ".ucfirst($currentUser->data->lastName);

if($otherUserID != $currentUserID) {
    $rpOtherUserID  = substr($otherUserID, 2);
    ?>
    <div class="module profile">
        <div class="swWelcomeBox clearfix">
            <a class="blockImage">
                <img src="<?php echo $otherUser->data->profilePic; ?>" alt="" class="swWelcomeBoxImage" />
            </a>
            <div class="swWelcomeBoxContent">
                <a href="" class="swWelcomeBoxName"><?php echo $otherUserName; ?></a>
                <div class="swWelcomeBoxCountry">
                    <span><img src="<?php echo F3::get('STATIC'); ?>images/usflag.jpg" alt="" class="countryFlag" /></span>
                    <span>United States...</span>
                </div>
                <div class="addFriendBtn">
                    <?php
                    if($status_fr == 'request' || $status_fr == 'null') {
                        ?>
                        <form id="friendID">
                            <input type="hidden" value="<?php echo $rpOtherUserID; ?>" name="id">
                            <input type="hidden" id="status_fr" value="<?php echo $status_fr; ?>" name="status_fr">
                            <button class="addFriend" type="submit"></button>
                        </form>
                    <?php }else {  ?>
                        <form id="friendID">
                            <input type="hidden" value="<?php echo $rpOtherUserID; ?>" name="id">
                            <input type="hidden" id="status_fr" value="<?php echo $status_fr; ?>" name="status_fr">
                            <button class="friend" type="submit">Friend</button>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="swProfileViewsCount clearfix">
            <span>Profile Views:</span>
            <span class="profileViewsCount">37</span>
        </div>
        <div class="swProfileEdit clearfix">

        </div>
    </div>
<?php
}else {
    ?>
    <div class="module profile">
        <div class="swWelcomeBox clearfix">
            <a class="blockImage">
                <img src="<?php echo $profileInfo->data->profilePic; ?>" alt="" class="swWelcomeBoxImage" />
            </a>
            <div class="swWelcomeBoxContent">
                <a href="" class="swWelcomeBoxName"><?php echo $currentUserName;?></a>
                <div class="swWelcomeBoxCountry">
                    <span><img src="<?php echo F3::get('STATIC'); ?>images/usflag.jpg" alt="" class="countryFlag" /></span>
                    <span>United States...</span>
                </div>
                <div class="swWelcomeBoxMsg">
                    <span><img src="<?php echo F3::get('STATIC'); ?>images/email_icon.png" alt="" class="msgIcon" /></span>
                    <span id="profileMsgReceived">(0)</span>
                </div>
            </div>
        </div>
        <div class="swProfileViewsCount clearfix">
            <span>Profile Views:</span>
            <span class="profileViewsCount">37</span>
        </div>
        <div class="swProfileEdit clearfix">
            <div class="profileEditBtn"><a href="/edit">Edit Profile</a></div>
        </div>
    </div>
<?php
}
?>
<div class="editAvatar"><a id="uploadAvatar">Edit Avatar</a></div>
<div id="lightBoxUploadAvatar" class="faceContent">
    <div class="containerUploadAvatar">
        <div class="headerLightBox">UPLOAD AVATAR</div>
        <div class="contentLightBox">
            <div class="containerAvatar">
                <img src="<?php echo $profileInfo->data->profilePic; ?>" alt="" class="swWelcomeBoxImage" />
            </div>
            <div class="uploadAvatarBtn">
                <input id="avatarURL" type="hidden" name="urlAvatar" value="">
                <input class="currentAvatar" type="hidden" src="<?php echo $profileInfo->data->profilePic; ?>">
                <input id="fileAvatar" class="designUploadBtn" type="file" name="uploadfile" >
                <span class="Tip helpUpload">Note: "Only JPG, PNG or GIF files are allowed"</span>
            </div>
        </div>
        <div class="footerLightBox">
            <input class="uploadAvatar btn btn-small btn-primary" type="button" value="Upload" />
            <a id="closeLightBoxUploadAvatar" class="cancelAction" title="Close">Cancel</a>
        </div>
    </div>
</div>
<div id="fadeUploadAvatar" class="black_overlay"></div>
<script type="text/javascript">
    $('.editAvatar').hide();
    $('.blockImage').mouseover(function() {
        $('.editAvatar').show();
    });
    $('.editAvatar').mouseover(function() {
        $('.editAvatar').show();
    });
    $('.blockImage').mouseout(function() {
        $('.editAvatar').hide();
    });
    $('.editAvatar').live('click', function() {
        $('#lightBoxUploadAvatar').show();
        $('#fadeUploadAvatar').show();
        $('.editAvatar').hide();
    });
    $('#closeLightBoxUploadAvatar').click(function() {
        var currentAvatar = $('.currentAvatar').attr('src');
        $('#lightBoxUploadAvatar').hide();
        $('#fadeUploadAvatar').hide();
        $('.swWelcomeBoxImage').attr('src', currentAvatar);
        $('.editAvatar').hide();
        $('.Tip').removeClass('errorMsgUpload');
        $('.Tip').html('Note: Only JPG, PNG or GIF files are allowed').addClass('helpUpload');
    });
</script>