<?php
$status = $this->f3->get('status');
$user   = $this->f3->get('user');
$userName   = ucfirst($user->data->firstName).' '.ucfirst($user->data->lastName);
$profilePic = $user->data->profilePic;
$statusID   = str_replace(':', '_', $status->recordID);
?>
<script type="text/javascript">
    $(function(){
        $(".shareBtn").on('click', function(e)
        {
            e.preventDefault();
            var statusID = $(this).attr('id').replace('shareStatus-','');
            //var txt = $('#contentShare-'+statusID).val();
            $.ajax({
                type: "POST",
                url: "/content/post/insertStatus",
                data: $('#fmShareStatus-'+statusID).serialize(),
                cache: false,
                success: function(){
                    $('.uiShare').hide();
                    $('.notificationShare').show();
                    setTimeout(function(){
                        $('.notificationShare').hide();
                        $('#fade').hide();
                    }, 3000);
                }
            });
        });
        $('.cancelBtn').click(function(e){
            e.preventDefault();
            $('#fade').hide();
            $('.uiShare').hide();
        });
        $('.taPostShare').autosize();
    });

</script>
<div class="uiContainerPopUp">
    <div class="titlePopUp large-100">
        <span>Share This Status</span>
    </div>
    <div class="mainPopUp large-100">
        <div class="shareFor column-group">
            <span class="large-30 shareIcon">Share: </span>
            <span class="large-70 shareOn">On your own timeline</span>
        </div>
        <div class="uiTextShare large-100">
            <form class="ink-form" id="fmShareStatus-<?php echo $statusID; ?>">
                <fieldset>
                    <div class="control-group">
                        <div class="control">
                            <input type="hidden" id="parentStatus" name="statusID" value="<?php echo $statusID; ?>">
                            <textarea name="shareTxt" class="taPostShare" id="contentShare-<?php echo $statusID; ?>" spellcheck="false" placeholder="Write a something..."></textarea>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="contentShareWrapper column-group">
            <div class="imageContainer large-35">
                <img src="<?php echo $profilePic; ?>" alt=""/>
            </div>
            <div class="textContainer large-65">
                <span class="shareStage">From Status</span>
                <p class="tagFrom">By <span class="tag"><?php echo $userName; ?></span></p>
                <p class="contentShare"><?php echo $status->data->content; ?></p>
            </div>
        </div>
    </div>
    <div class="actionPopUp column-group push-right large-100">
        <a class="uiMediumButton blue shareBtn" id="shareStatus-<?php echo $statusID; ?>">Share</a>
        <a class="uiMediumButton white cancelBtn">Cancel</a>
    </div>
</div>
