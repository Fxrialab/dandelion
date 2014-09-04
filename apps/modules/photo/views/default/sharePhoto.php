<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 11/5/13 - 3:31 PM
 * Project: dandelion Network - Version: 1.0
 */
$content_stt = F3::get('content_stt');
$getAvatar   = F3::get('getAvatar');
?>
<script >
    $(function(){
        $("#btnShareSt").click(function(e)
        {

            e.preventDefault();
            var status = $("#content_share").val();
            var rid = $("#rid_status").val();
            if(status=='')
            {
                return false;
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: "/content/photo/insertPhoto",
                    data: {status:status,rid : rid},
                    cache: false,
                    success: function(html){
                        $('#wrapperStt').css('display','none');
                        $('#noticeStt').css('display','block');
                    }
                });
            }
            return false;
        });
    });

</script>

<div id="shareStatus" title="Share Photo ?">
    <div class="allWraper" id="wrapperStt">
        <div class="content_stt">
            <textarea class="textInput" placeholder="Hãy viết gì đó..." title="Hãy viết gì đó..." name="content_share" id="content_share" cols="40" rows="3"  ></textarea>
            <div class="pam">
                <div class="avatar">
                    <img src="<?php echo $content_stt->data->url; ?>" class="picture-ava"/>
                </div>
                <div class="prefix_text">
                    <?php echo $content_stt->data->description ?>
                </div>
            </div>
        </div>
        <div class="button-share">
            <div>
                <input class="btnshare"  type="submit" id="btnShareSt" value="Share" />
                <input type="hidden" id="rid_status" value="<?php echo $content_stt->recordID; ?>"/>
            </div>
        </div>
    </div>
    <div id="noticeStt" style="display: none"> This status is was shared</div>
</div>