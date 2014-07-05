<?php
$myPhoto = $this->f3->get('myPhoto');
$photos = $this->f3->get('photos');
?>
<div class="arrow_timeLineMenuNav">
    <div class="arrow_phototab"></div>
</div>

<div class="uiMainColAbout">
    <div class="uiPhotoWrapper">
        <?php require_once 'boxTitle.php'; ?>
        <div class="arrow_photo"></div>
        <div class="column-group">
            <div class="photoAll">
                <?php
                if (!empty($photos))
                {
                    foreach ($photos as $k => $item)
                    {
                        $recordID = $item['recordID'];
                        $photoURL = $item['fileName'];
                        $photoID = substr($recordID, strpos($recordID, ':') + 1);
                        $postPhotoID = str_replace(':', '_', $recordID);
                        $comment = PhotoController::getFindComment($recordID);
                        $count = PhotoController::countComment($recordID);
                        include 'itemPhoto.php';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('textarea').autosize();

    });
    $(document).on('keypress', '.submitCommentPhoto', function(event) {
        var code = (event.keyCode ? event.keyCode : event.which);
        if (code == '13' && !event.shiftKey)
        {
            var photoID = $(this).attr('id').replace('photoComment-', '');
            var comment = $("#photoComment-" + photoID).val();
            if (comment == '')
            {
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "/content/photo/comment",
                    data: $('#form_' + photoID).serialize(),
                    cache: false,
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        if (obj.height < 190) {
                            $("#box_" + photoID).css('height', obj.height + "px");
                            $("#box_" + photoID).css('bottom', "-" + obj.height + "px");
                        }
                        var rs = [
                            {
                                id: obj.id,
                                content: obj.content,
                                userID: obj.userID,
                                name: obj.name,
                                photoID: obj.photoID,
                                time: obj.time
                            }
                        ];
                        $("#photoComment-" + photoID).val('');
                        $(".comment_" + photoID).html(obj.count);
                        $("#commentPhotoTemplate").tmpl(rs).appendTo(".viewComment_" + obj.photoID + " div.mCustomScrollBox div.mCSB_container");
                        $(".viewComment_" + obj.photoID).mCustomScrollbar("scrollTo", " div.mCustomScrollBox div.mCSB_container li.item_" + obj.id);
                        updateTime();
                    }
                });
                //exit();
            }
        }
        //return false;
    });


</script>
<script id="commentPhotoTemplate" type="text/x-jQuery-tmpl">
    <li  class="itemC_${id}">
    <div class="avatar">
    <img src="<?php echo IMAGES ?>/avatarMenDefault.png">
    </div>
    <div class="content">
    <a href="#" class="fullName">${name}</a>
    ${content}
    <p><a class="swTimeComment" name="${time}"></a></p>
    </div>
    </li>
</script>