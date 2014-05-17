<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="profilePic">
    <a href=""><img src="<?php echo $otherUser->data->profilePic; ?>"></a>
    <div class="profileInfo" >
        <div class="dropdown">
            <a href="#" class="button"><span class="icon icon148"></span><span class="label">Update Avatar</span></a>
            <div class="dropdown-slider left w175">
                <a href="#" class="photoBrowse ddm" role="avatar" title="My Photos"><span class="icon icon147"></span><span class="label">Choose from Photos...</span></a>
                <a href="#" class="ddm"><span class="icon icon189"></span><span class="label">Upload photo</span></a>
                <a href="#" class="ddm"><span class="icon icon58"></span><span class="label">Remove</span></a>
            </div> <!-- /.dropdown-slider -->
        </div> <!-- /.dropdown -->
    </div>
</div>